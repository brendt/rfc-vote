<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Components\Profile\UserMenu\Menu;
use Tests\DuskTestCase;

class MainMenuTest extends DuskTestCase
{
    use DatabaseTruncation;

    public function test_it_renders_all_menu_links_for_guests(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->with(new Navbar, function (Browser $browser) {
                    $browser->assertSeeLink('Open RFCs')
                        ->assertSeeLink('About')
                        ->assertSeeLink('Login')
                        ->assertNotPresent('@navbar-link-messages-link')
                        ->assertNotPresent('@user-menu-menu')
                        ->assertPresent('@dark-mode-button');
                });
        });
    }

    public function test_it_does_not_render_login_and_register_for_authenticated_users(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $browser->loginAs($user)
                ->visit('/')
                ->with(new Navbar, function (Browser $browser) use ($user) {
                    $browser->assertSeeLink('Open RFCs')
                        ->assertSeeLink('About')
                        ->assertDontSeeLink('Login')
                        ->assertDontSeeLink('Register')
                        ->assertPresent('@navbar-link-messages-link')
                        ->assertPresent('@dark-mode-button')
                        ->with(new Menu, function (Browser $browser) use ($user) {
                            $browser->assertSee($user->username);
                        });
                });
        });
    }

    public function test_it_renders_links_for_settings_profile_and_logout(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $browser->loginAs($user)
                ->visit('/')
                ->click('@user-menu-menu')
                ->with(new Menu, function (Browser $browser) {
                    $browser->click('button')
                        ->assertSeeLink('My profile')
                        ->assertSeeLink('Settings')
                        ->assertSee('Logout');
                });
        });
    }

    public function test_it_allows_users_to_logout_from_navbar(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $browser->loginAs($user)
                ->visit('/')
                ->click('@user-menu-menu')
                ->with(new Menu, function (Browser $browser) {
                    $browser->click('button')
                        ->press('Logout')
                        ->assertGuest();
                });
        });
    }

    public function test_it_renders_a_settings_link_which_points_to_verification_page_for_unverified_users(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create([
                'email_verified_at' => null,
            ]);
            $browser->loginAs($user)
                ->visit('/')
                ->with(new Menu, function (Browser $browser) {
                    $browser->click('button')
                        ->clickLink('Settings')
                        ->assertPathIs('/email/verify');
                });
        });
    }

    public function test_it_renders_a_settings_link_which_points_to_user_private_profile_page_for_verified_users(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $browser->loginAs($user)
                ->visit('/')
                ->with(new Menu, function (Browser $browser) {
                    $browser->click('button')
                        ->clickLink('Settings')
                        ->assertPathIs('/profile');
                });
        });
    }

    public function test_it_renders_public_profile(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $browser->loginAs($user)
                ->visit('/')
                ->with(new Menu, function (Browser $browser) use ($user) {
                    $browser->click('button')
                        ->clickLink('My profile')
                        ->assertPathIs("/profile/$user->username");
                });
        });
    }

    public function test_it_renders_unread_messages_count(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create(['unread_message_count' => 10]);
            $browser->loginAs($user)
                ->visit('/')
                ->with(new Navbar, function (Browser $browser) {
                    $browser->assertSeeIn('@navbar-link-messages-link ~ @navbar-link-messages-count', 10);
                });
        });
    }
}
