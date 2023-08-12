<?php

namespace App\Actions;

use App\Mail\EmailVerificationMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

final readonly class RequestEmailChange
{
    public function __invoke(User $user, string $newEmail): void
    {
        $token = Str::random(64);

        $user->emailChangeRequests()->create([
            'new_email' => $newEmail,
            'token' => $token,
        ]);

        $verificationLink = URL::signedRoute('email.verify', ['token' => $token]);

        Mail::to($newEmail)->send(new EmailVerificationMail($verificationLink));
    }
}
