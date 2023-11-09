<?php

uses(\Tests\DuskTestCase::class);
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\EmailVerificationPage;

uses(\Illuminate\Foundation\Testing\DatabaseTruncation::class);

uses(\ProtoneMedia\LaravelDuskFakes\Notifications\PersistentNotifications::class);

test('it redirects users to verify email page if they are not verified', function () {
    $this->browse(function (Browser $browser) {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);
        $browser->loginAs($user)
            ->visit('/profile')
            ->assertPathIs('/email/verify');
    });
});

test('it does not allow verified users to access email verification page if already verified', function () {
    $this->browse(function (Browser $browser) {
        $user = User::factory()->create();
        $browser->loginAs($user)
            ->visit('/email/verify')
            ->assertPathIs('/');
    });
});

test('it renders all necessary elements', function () {
    $this->browse(function (Browser $browser) {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);
        $browser->loginAs($user)
            ->visit(new EmailVerificationPage)
            ->within('form', function (Browser $browser) {
                $browser->assertSeeIn('h2', 'Verify Email Address')
                    ->assertSeeIn('button[type="submit"]', 'Resend Verification Email')
                    ->assertSeeIn('button:last-of-type', 'Logout');
            });
    });
});

test('it allows user to logout by pressing the logout button on email verification page', function () {
    $this->browse(function (Browser $browser) {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);
        $browser->loginAs($user)
            ->visit(new EmailVerificationPage)
            ->within('form', function (Browser $browser) {
                $browser->press('Logout')
                    ->assertGuest();
            });
    });
});

test('it allows to resend verification email', function () {
    $this->browse(function (Browser $browser) {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);
        $browser->loginAs($user)
            ->visit(new EmailVerificationPage)
            ->press('Resend Verification Email');

        Notification::assertSentTo($user, VerifyEmail::class);
    });
});
