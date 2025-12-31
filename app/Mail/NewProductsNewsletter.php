<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewProductsNewsletter extends Mailable
{
    use Queueable, SerializesModels;

    public $products;
    public $subscriberEmail;

    /**
     * Create a new message instance.
     */
    public function __construct($products, $subscriberEmail)
    {
        $this->products = $products;
        $this->subscriberEmail = $subscriberEmail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $businessName = __('messages.business_name');
        $subject = __('messages.new_products_newsletter_subject');
        $subject = str_replace('{{ $business_name }}', $businessName, $subject);

        $envelope = new Envelope(
            subject: $subject,
        );

        // Add BCC to admin email so it appears in Hostinger mailbox
        $adminEmail = config('mail.from.address');
        if ($adminEmail && $adminEmail !== 'hello@example.com') {
            $envelope->bcc($adminEmail);
        }

        return $envelope;
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.newsletter.new-products',
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
}
