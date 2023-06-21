<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmailPayment extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $user;
    public $carts;
    public $cartAttributes;
    public $voucherId;
    public $allPrice;
    public $paymentPrice;
    public $saleEd;

    public function __construct($user, $carts, $cartAttributes, $voucherId, $allPrice, $paymentPrice, $saleEd)
    {
        $this->user = $user;
        $this->carts = $carts;
        $this->cartAttributes = $cartAttributes;
        $this->voucherId = $voucherId;
        $this->allPrice = $allPrice;
        $this->paymentPrice = $paymentPrice;
        $this->saleEd = $saleEd;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'user.test',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
        return $this->view('user.test')
            ->with([
                'user' => $this->user,
                'carts' => $this->carts,
                'cartAttributes' => $this->cartAttributes,
                'voucherId' => $this->voucherId,
                'allPrice' => $this->allPrice,
                'paymentPrice' => $this->paymentPrice,
                'saleEd' => $this->saleEd
            ])
            ->subject('Chúc mừng bạn đã đặt hàng thành công!');
    }
}
