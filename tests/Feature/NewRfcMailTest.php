<?php

use App\Actions\SendUserMail;
use App\Mail\NewRfcMail;
use App\Models\Rfc;
use App\Models\User;
use App\Models\UserMail;
use Illuminate\Support\Facades\Mail;

test('sent to the correct users', function () {
    Mail::fake();

    [$a, $b, $c] = User::factory()->count(3)->sequence(
        ['email_optin' => true],
        ['email_optin' => true],
        ['email_optin' => false],
    )->create();

    $rfc = Rfc::factory()->create([
        'title' => 'Test RFC',
    ]);

    Mail::assertSentCount(2);

    $this->assertDatabaseHas('user_mails', [
        'user_id' => $a->id,
        'mail_type' => NewRfcMail::class.':'.$rfc->id,
    ]);

    $this->assertDatabaseHas('user_mails', [
        'user_id' => $b->id,
        'mail_type' => NewRfcMail::class.':'.$rfc->id,
    ]);

    $this->assertDatabaseMissing('user_mails', [
        'user_id' => $c->id,
        'mail_type' => NewRfcMail::class.':'.$rfc->id,
    ]);
});

test('it wont send email to user that didnt opt in', function () {
    Mail::fake();

    $rfc = Rfc::factory()->create([
        'title' => 'Test RFC',
    ]);

    $user = User::factory()->create(['email_optin' => false]);

    (new SendUserMail)(
        user: $user,
        mailable: new NewRfcMail(
            $rfc,
            $user,
        ),
    );

    $this->assertDatabaseMissing('user_mails', [
        'user_id' => $user->id,
        'mail_type' => NewRfcMail::class,
    ]);

    Mail::assertNothingOutgoing();
});

test('it wont send email to user that has already gotten it', function () {
    Mail::fake();

    $rfc = Rfc::factory()->create([
        'title' => 'Test RFC',
    ]);

    $user = User::factory()->create(['email_optin' => true]);

    UserMail::factory()->create([
        'user_id' => $user->id,
        'mail_type' => ((new NewRfcMail($rfc, $user))->getMailId()),
    ]);

    (new SendUserMail)(
        user: $user,
        mailable: new NewRfcMail(
            $rfc,
            $user,
        ),
    );

    Mail::assertNothingOutgoing();
});

test('it will send emails for multiple created rfcs', function () {
    Mail::fake();

    User::factory()->create(['email_optin' => true]);

    Rfc::factory()->count(3)->sequence(
        ['title' => 'Test RFC 1'],
        ['title' => 'Test RFC 2'],
        ['title' => 'Test RFC 3'],
    )->create();

    Mail::assertSentCount(3);
});
