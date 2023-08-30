<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\HomePage;
use Tests\DuskTestCase;

class HomePageTest extends DuskTestCase
{
    use DatabaseTruncation;

    public function test_it_renders_all_main_sections(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage)
                ->assertPresent('@main-header')
                ->assertPresent('@logo')
                ->assertPresent('@footer');
        });
    }

    public function test_it_renders_email_notification_disclaimer_to_unauthenticated_users(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage)
                ->assertPresent('@disclaimer')
                ->click('@disclaimer a')
                ->assertUrlIs(route('login'));
        });
    }

    public function test_it_renders_email_notification_disclaimer_for_auth_users_that_didnt_verify_email(
    ): void {
        $user = User::factory()->unverified()->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(new HomePage)
                ->assertPresent('@disclaimer')
                ->click('@disclaimer a')
                ->assertUrlIs(route('verification.notice'));
        });
    }

    public function test_it_renders_email_notification_disclaimer_for_auth_users_that_do_not_have_email_notifications_enabled(
    ): void {
        $user = User::factory()->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(new HomePage)
                ->assertPresent('@disclaimer')
                ->click('@disclaimer a')
                ->assertPathIs('/')
                ->assertNotPresent('@disclaimer');
        });
    }

    public function test_it_does_not_render_email_notifications_if_user_already_opted_for_email_notifications(
    ): void {
        $user = User::factory()->withEmailOptin()->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(new HomePage)
                ->assertNotPresent('@disclaimer');
        });
    }
}
