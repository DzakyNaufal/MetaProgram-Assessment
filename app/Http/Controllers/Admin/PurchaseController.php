<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Course;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PurchaseConfirmation;
use App\Mail\PurchaseRejection;

class PurchaseController extends Controller
{
    public function __construct()
    {
        // Middleware already handled in routes/web.php
    }

    public function index(Request $request)
    {
        $query = Purchase::with(['user', 'course']);

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $purchases = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.purchases.index', compact('purchases'));
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['user', 'course']);
        return view('admin.purchases.show', compact('purchase'));
    }

    public function confirm(Request $request, Purchase $purchase)
    {
        // Update purchase to confirmed
        // For course purchases, access is lifetime (no expiry)
        $purchase->update([
            'status' => 'confirmed',
            'expired_at' => null, // Lifetime access
        ]);

        // Send confirmation email to user
        Mail::to($purchase->user->email)->send(new PurchaseConfirmation($purchase));

        return redirect()->route('admin.purchases.index')->with('success', 'Pembelian berhasil dikonfirmasi.');
    }

    public function reject(Request $request, Purchase $purchase)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $purchase->update(['status' => 'rejected']);

        // Send rejection email to user with reason
        Mail::to($purchase->user->email)->send(new PurchaseRejection($purchase, $request->reason));

        return redirect()->route('admin.purchases.index')->with('success', 'Pembelian berhasil ditolak.');
    }

    public function destroy(Purchase $purchase)
    {
        // Delete the purchase (cascade delete will handle user history)
        $purchase->delete();

        return redirect()->route('admin.purchases.index')->with('success', 'Pembelian dan history user berhasil dihapus.');
    }
}
