<?php

namespace App\Mail;

use App\Models\Purchase;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchaseConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $purchase;

    /**
     * Create a new message instance.
     */
    public function __construct(Purchase $purchase)
    {
        $this->purchase = $purchase;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Bukti Pembayaran - Invoice #' . str_pad($this->purchase->id, 6, '0', STR_PAD_LEFT) . ' - ' . config('app.name'))
            ->view('emails.purchase-confirmation');
    }
}
