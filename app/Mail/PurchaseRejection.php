<?php

namespace App\Mail;

use App\Models\Purchase;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchaseRejection extends Mailable
{
    use Queueable, SerializesModels;

    public $purchase;
    public $reason;

    /**
     * Create a new message instance.
     */
    public function __construct(Purchase $purchase, string $reason)
    {
        $this->purchase = $purchase;
        $this->reason = $reason;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Your Payment Has Been Rejected - Purchase #' . $this->purchase->id)
            ->view('emails.purchase-rejection');
    }
}
