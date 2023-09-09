<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Laravel\Dusk\Browser;

use ProtoneMedia\LaravelDuskFakes\Notifications\PersistentNotifications;
use Tests\Browser\Pages\EmailVerificationPage;
use Tests\DuskTestCase;

class EmailVerificationTest extends DuskTestCase
{
    use DatabaseTruncation;
    use PersistentNotifications;

    public function test_it_redirects_users_to_verify_email_page_if_they_are_not_verified(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create([
                'email_verified_at' => null,
            ]);
            $browser->loginAs($user)
                ->visit('/profile')
                ->assertPathIs('/email/verify');
        });
    }

    public function test_it_does_not_allow_verified_users_to_access_email_verification_page_if_already_verified(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $browser->loginAs($user)
                ->visit('/email/verify')
                ->assertPathIs('/');
        });
    }

    public function test_it_renders_all_necessary_elements(): void
    {
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
    }

    public function test_it_allows_user_to_logout_by_pressing_the_logout_button_on_email_verification_page(): void
    {
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
    }

    public function test_it_allows_to_resend_verification_email(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create([
                'email_verified_at' => null,
            ]);
            $browser->loginAs($user)
                ->visit(new EmailVerificationPage)
                ->press('Resend Verification Email');

            Notification::assertSentTo($user, VerifyEmail::class);
        });
    }
}
