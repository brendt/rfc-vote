<?php

namespace App\Mail;

use App\Models\Rfc;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewRfcMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Rfc $rfc,
        public User $user,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->rfc->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-rfc',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
