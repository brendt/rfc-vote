<?php

namespace App\Mail;

use App\Models\Rfc;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

final class NewRfcMail extends Mailable implements HasMailId
{
    use Queueable, SerializesModels;

    public function __construct(public Rfc $rfc, public User $user)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->rfc->title);
    }

    public function build(): Mailable
    {
        return $this->markdown('emails.new-rfc')
            ->subject("New RFC: {$this->rfc->title}")
            ->with('user', $this->user)
            ->with('rfc', $this->rfc);
    }

    public function getMailId(): string
    {
        return self::class.':'.$this->rfc->id;
    }
}
