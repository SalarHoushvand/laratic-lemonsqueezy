<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewContactRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly array $data
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('New Contact Form Submission'),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.contact-request',
            with: [
                'data' => $this->data,
            ],
        );
    }
}
