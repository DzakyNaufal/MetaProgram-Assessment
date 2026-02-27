<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PDF;

class ProductsController extends Controller
{
    public function index()
    {
        return view('pricing');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'product_id' => 'required|exists:tiers,id', // This should remain as 'product_id' for backward compatibility with the form
        ]);

        try {
            // Create the purchase record
            $purchase = \App\Models\Purchase::create([
                'user_id' => Auth::id(),
                'tier_id' => $request->product_id, // Changed from product_id to tier_id
                'amount' => \App\Models\Tier::findOrFail($request->product_id)->price, // Get the price of the tier
                'status' => 'pending', // Default status
                'expired_at' => now()->addHours(48), // Expire after 48 hours
            ]);

            // Generate dummy PDF report using DomPDF
            $pdfData = [
                'user' => Auth::user(),
                'tier' => \App\Models\Tier::find($request->product_id), // Changed from product to tier
                'purchase' => $purchase,
            ];

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.purchase-report', $pdfData);
            $pdfPath = storage_path('app/public/reports/' . $purchase->id . '_report.pdf');

            // Ensure the directory exists
            if (!file_exists(storage_path('app/public/reports'))) {
                mkdir(storage_path('app/public/reports'), 0755, true);
            }

            $pdf->save($pdfPath);

            // Send confirmation email
            Mail::to($request->email)->send(new \App\Mail\PurchaseConfirmation($pdfPath));

            return redirect()->back()->with('success', 'Pembelian sukses!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
