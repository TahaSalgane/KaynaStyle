<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\ContactMessage;

class ContactResponse extends Mailable
{
    use Queueable, SerializesModels;

    public $contactMessage;

    /**
     * Create a new message instance.
     */
    public function __construct(ContactMessage $message)
    {
        $this->contactMessage = $message;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $envelope = new Envelope(
            subject: __('messages.contact_response_subject', ['subject' => $this->contactMessage->subject]),
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
            view: 'emails.contact.response',
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
