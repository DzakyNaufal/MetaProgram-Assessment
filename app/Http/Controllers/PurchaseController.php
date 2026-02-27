<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Course;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\PurchaseNotification;

class PurchaseController extends Controller
{
    public function __construct()
    {
        // Middleware handled in routes
    }

    public function index()
    {
        $purchases = Auth::user()->purchases()
            ->with('course')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $courses = Course::where('is_active', true)->get();
        $bankAccounts = BankAccount::where('is_active', true)->get();

        // Get active coupons that are currently valid
        $activeCoupons = \App\Models\Coupon::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('valid_from')
                    ->orWhere('valid_from', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('valid_until')
                    ->orWhere('valid_until', '>=', now());
            })
            ->where(function ($query) {
                $query->whereNull('max_uses')
                    ->whereRaw('used_count < max_uses')
                    ->orWhere(function ($q) {
                        $q->whereNotNull('max_uses')
                            ->whereRaw('used_count < max_uses');
                    });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('purchases.create', compact('courses', 'bankAccounts', 'activeCoupons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'sender_name' => 'required|string|max:255',
            'sender_bank' => 'required|string|max:255',
            'transfer_date' => 'required|date',
            'proof_image' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'whatsapp_number' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
            'coupon_code' => 'nullable|string|exists:coupons,code',
        ]);

        $course = Course::findOrFail($request->course_id);

        // Free course tidak perlu purchase
        if ($course->isFree()) {
            return redirect()->route('courses.show', $course->slug)
                ->with('success', 'Course ini gratis, Anda otomatis memiliki akses!');
        }

        // Check if user already has a confirmed purchase for this course
        $existingPurchase = Auth::user()->purchases()
            ->where('course_id', $course->id)
            ->where('status', 'confirmed')
            ->where(function ($q) {
                $q->whereNull('expired_at')
                    ->orWhere('expired_at', '>', now());
            })
            ->first();

        if ($existingPurchase) {
            return redirect()->route('courses.show', $course->slug)
                ->with('info', 'Anda sudah memiliki akses ke course ini.');
        }

        // Handle coupon validation if provided
        $coupon = null;
        $discountAmount = 0;

        if ($request->filled('coupon_code')) {
            $coupon = \App\Models\Coupon::where('code', strtoupper($request->coupon_code))->first();

            if (!$coupon) {
                return redirect()->back()->withErrors(['coupon_code' => 'Kode kupon tidak valid.']);
            }

            if (!$coupon->isValid()) {
                return redirect()->back()->withErrors(['coupon_code' => 'Kupon ini tidak berlaku.']);
            }

            if (!$coupon->isApplicableForOrder($course->price)) {
                return redirect()->back()->withErrors(['coupon_code' => 'Kupon ini tidak dapat digunakan untuk pembelian ini.']);
            }
        }

        // Check if user already has a pending purchase for this course
        $pendingPurchase = Auth::user()->purchases()
            ->where('course_id', $course->id)
            ->where('status', 'pending')
            ->where('expired_at', '>', now())
            ->first();

        if ($pendingPurchase) {
            // Update existing pending purchase
            $pendingPurchase->update([
                'sender_name' => $request->sender_name,
                'sender_bank' => $request->sender_bank,
                'transfer_date' => $request->transfer_date,
                'notes' => $request->notes,
                'whatsapp_number' => $request->whatsapp_number,
                'coupon_id' => $coupon ? $coupon->id : null,
            ]);

            // Handle file upload
            if ($request->hasFile('proof_image')) {
                // Delete old proof if exists
                if ($pendingPurchase->proof_image && Storage::disk('public')->exists($pendingPurchase->proof_image)) {
                    Storage::disk('public')->delete($pendingPurchase->proof_image);
                }
                $path = $request->file('proof_image')->store('proofs', 'public');
                $pendingPurchase->proof_image = $path;
                $pendingPurchase->save();
            }

            // Send notification
            $pendingPurchase->load(['user', 'course', 'coupon']);
            Mail::to(config('mail.from.address'))->send(new PurchaseNotification($pendingPurchase));

            return redirect()->route('purchases.index')
                ->with('success', 'Bukti pembayaran berhasil diupload. Silakan tunggu konfirmasi admin.');
        }

        // Handle file upload
        $proofPath = null;
        if ($request->hasFile('proof_image')) {
            $proofPath = $request->file('proof_image')->store('proofs', 'public');
        }

        // Calculate discounted amount if coupon is applied
        $originalAmount = $course->price;
        $finalAmount = $originalAmount;

        if ($coupon) {
            $discountAmount = $coupon->calculateDiscount($originalAmount);
            $finalAmount = max(0, $originalAmount - $discountAmount); // Ensure amount doesn't go below 0

            // Increment coupon usage
            $coupon->incrementUsedCount();
        }

        // Hitung expiry date untuk payment (48 jam)
        $paymentExpiry = now()->addHours(48);

        // Create purchase record with all details
        $purchase = Purchase::create([
            'user_id' => Auth::id(),
            'coupon_id' => $coupon ? $coupon->id : null,
            'course_id' => $course->id,
            'amount' => $finalAmount,
            'sender_name' => $request->sender_name,
            'sender_bank' => $request->sender_bank,
            'transfer_date' => $request->transfer_date,
            'proof_image' => $proofPath,
            'notes' => $request->notes,
            'whatsapp_number' => $request->whatsapp_number,
            'status' => 'pending',
            'expired_at' => $paymentExpiry,
        ]);

        // Send notification to admin
        $purchase->load(['user', 'course', 'coupon']);
        Mail::to(config('mail.from.address'))->send(new PurchaseNotification($purchase));

        return redirect()->route('purchases.index')
            ->with('success', 'Pembelian berhasil. Silakan tunggu konfirmasi admin.');
    }

    public function showPayment($id)
    {
        $purchase = Purchase::with(['course', 'user'])->findOrFail($id);

        // Check if purchase belongs to current user
        if ($purchase->user_id !== Auth::id()) {
            abort(403);
        }

        $bankAccounts = BankAccount::where('is_active', true)->get();

        return view('purchases.payment', compact('purchase', 'bankAccounts'));
    }

    public function uploadProof(Request $request, $id)
    {
        $request->validate([
            'sender_name' => 'required|string|max:255',
            'sender_bank' => 'required|string|max:255',
            'transfer_date' => 'required|date',
            'proof_image' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
            'notes' => 'nullable|string',
            'whatsapp_number' => 'nullable|string|max:20',
            'coupon_code' => 'nullable|string|exists:coupons,code',
        ]);

        $purchase = Purchase::with('coupon')->findOrFail($id);

        // Check if purchase belongs to current user and is still pending
        if ($purchase->user_id !== Auth::id() || $purchase->status !== 'pending') {
            abort(403);
        }

        // Handle coupon validation if provided
        $coupon = null;
        $discountAmount = 0;

        if ($request->filled('coupon_code')) {
            $coupon = \App\Models\Coupon::where('code', strtoupper($request->coupon_code))->first();

            if (!$coupon) {
                return redirect()->back()->withErrors(['coupon_code' => 'Kode kupon tidak valid.']);
            }

            if (!$coupon->isValid()) {
                return redirect()->back()->withErrors(['coupon_code' => 'Kupon ini tidak berlaku.']);
            }

            // Check if coupon was already applied or if it's applicable for the original amount
            $originalAmount = $purchase->course->price; // Original course price
            if (!$coupon->isApplicableForOrder($originalAmount)) {
                return redirect()->back()->withErrors(['coupon_code' => 'Kupon ini tidak dapat digunakan untuk pembelian ini.']);
            }

            // If coupon is valid and not already applied, apply it
            if (!$purchase->coupon_id) {
                $discountAmount = $coupon->calculateDiscount($originalAmount);
                $finalAmount = max(0, $originalAmount - $discountAmount); // Ensure amount doesn't go below 0

                // Increment coupon usage
                $coupon->incrementUsedCount();

                // Update purchase amount with discount
                $purchase->update([
                    'coupon_id' => $coupon->id,
                    'amount' => $finalAmount,
                ]);
            }
        }

        // Handle file upload
        if ($request->hasFile('proof_image')) {
            $path = $request->file('proof_image')->store('proofs', 'public');
            $purchase->proof_image = $path;
        }

        // Update purchase details
        $purchase->update([
            'sender_name' => $request->sender_name,
            'sender_bank' => $request->sender_bank,
            'transfer_date' => $request->transfer_date,
            'notes' => $request->notes,
            'whatsapp_number' => $request->whatsapp_number,
            'status' => 'pending', // Keep as pending for admin review
        ]);

        // Reload purchase with relationships for email
        $purchase->load(['user', 'course', 'coupon']);

        // Send notification to admin
        Mail::to(config('mail.from.address'))->send(new PurchaseNotification($purchase));

        return redirect()->route('purchases.index')
            ->with('success', 'Bukti pembayaran berhasil diupload. Silakan tunggu konfirmasi admin.');
    }

    public function validateCoupon(Request $request, $code)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'original_amount' => 'required|numeric|min:0',
        ]);

        $course = Course::findOrFail($request->course_id);
        $originalAmount = $request->original_amount;

        $coupon = \App\Models\Coupon::where('code', strtoupper($code))->first();

        if (!$coupon) {
            return response()->json([
                'valid' => false,
                'message' => 'Kode kupon tidak valid.'
            ]);
        }

        if (!$coupon->isValid()) {
            return response()->json([
                'valid' => false,
                'message' => 'Kupon ini tidak berlaku.'
            ]);
        }

        if (!$coupon->isApplicableForOrder($originalAmount)) {
            return response()->json([
                'valid' => false,
                'message' => 'Kupon ini tidak dapat digunakan untuk pembelian ini.'
            ]);
        }

        if (!$coupon->isApplicableForCourseType($course->type)) {
            return response()->json([
                'valid' => false,
                'message' => 'Kupon ini tidak dapat digunakan untuk tipe course ini.'
            ]);
        }

        $discountAmount = $coupon->calculateDiscount($originalAmount);
        $finalAmount = max(0, $originalAmount - $discountAmount);

        return response()->json([
            'valid' => true,
            'message' => 'Kupon valid',
            'discount_type' => $coupon->type,
            'discount_value' => $coupon->value,
            'discount_amount' => $discountAmount,
            'final_amount' => $finalAmount,
            'original_amount' => $originalAmount
        ]);
    }
}
