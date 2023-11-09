<?php

use App\Actions\RequestEmailChange;
use App\Mail\EmailVerificationMail;
use App\Models\EmailChangeRequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

test('request change', function () {
    Mail::fake();

    $user = User::factory()->create();
    $newEmail = 'new@email.com';

    (new RequestEmailChange)($user, $newEmail);

    $this->assertDatabaseHas(EmailChangeRequest::class, [
        'user_id' => $user->id,
        'new_email' => $newEmail,
    ]);

    Mail::assertSent(EmailVerificationMail::class, fn (EmailVerificationMail $mail) => $mail->hasTo($newEmail));
});
