<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    // بنستقبل الطلب هنا عشان نبعت بياناته للإيميل
    public function __construct($order)
    {
        $this->order = $order;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'تأكيد طلبك من Xero Office - طلب رقم #' . $this->order->id,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order_confirmation', // ده ملف التصميم اللي هنعمله الخطوة الجاية
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
