<?php

namespace Webkul\UTap\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Webkul\UTap\Contracts\PaymentLink;

class PaymentLinkReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public PaymentLink $paymentLink
    ) {}

    public function build(): self
    {
        return $this->from(
            core()->getSenderEmailDetails()['email'],
            core()->getSenderEmailDetails()['name'] ?: config('app.name')
        )
            ->to($this->paymentLink->email, $this->paymentLink->name)
            ->subject('💖 Payment Confirmation: AED '.number_format((float) $this->paymentLink->amount, 2).' received! — Kawaii Blessings')
            ->view('utap::emails.payment-receipt');
    }
}
