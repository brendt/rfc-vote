<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $verificationLink)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Email Verification Mail');
    }

    public function build(): Mailable
    {
        return $this->markdown('emails.email-verification')
            ->subject('Email Verification Mail')
            ->with('verificationLink', $this->verificationLink);
    }
}
