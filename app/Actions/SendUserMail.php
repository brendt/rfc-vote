<?php

namespace App\Actions;

use App\Mail\HasMailId;
use App\Models\User;
use App\Models\UserMail;
use Illuminate\Mail\Mailable;
use Mail;

final readonly class SendUserMail
{
    public function __invoke(User $user, Mailable $mailable): void
    {
        if (! $user->email_optin || ! method_exists($mailable, 'envelope')) {
            return;
        }

        if ($user->hasGottenMail($mailable)) {
            return;
        }

        UserMail::create([
            'user_id' => $user->id,
            'mail_type' => $mailable instanceof HasMailId ? $mailable->getMailId() : $mailable::class,
            'subject' => $mailable->envelope()->subject,
        ]);

        Mail::to($user)->send($mailable);
    }
}
