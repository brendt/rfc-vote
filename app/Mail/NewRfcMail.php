<?php

namespace App\Mail;

use App\Models\Rfc;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewRfcMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Rfc $rfc,
        public User $user,
    ) {
    }

    public function build(): Mailable
    {
        return $this->markdown('emails.new-rfc')
            ->subject("New RFC: {$this->rfc->title}")
            ->with('user',$this->user)
            ->with('rfc',$this->rfc);
    }
}
