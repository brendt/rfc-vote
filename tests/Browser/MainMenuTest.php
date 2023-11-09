<?php

uses(\Tests\DuskTestCase::class);
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Components\Profile\UserMenu\Menu;

uses(\Illuminate\Foundation\Testing\DatabaseTruncation::class);

test('it renders all menu links for guests', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/')
            ->with(new Navbar, function (Browser $browser) {
                $browser->assertSeeLink('Open RFCs')
                    ->assertSeeLink('About')
                    ->assertSeeLink('Login')
                    ->assertSeeLink('Register')
                    ->assertNotPresent('@navbar-link-messages-link')
                    ->assertNotPresent('@user-menu-menu')
                    ->assertPresent('@dark-mode-button');
            });
    });
});

test('it does not render login and register for authenticated users', function () {
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
});

test('it renders links for settings profile and logout', function () {
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
});

test('it allows users to logout from navbar', function () {
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
});

test('it renders a settings link which points to verification page for unverified users', function () {
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
});

test('it renders a settings link which points to user private profile page for verified users', function () {
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
});

test('it renders public profile', function () {
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
});

test('it renders unread messages count', function () {
    $this->browse(function (Browser $browser) {
        $user = User::factory()->create(['unread_message_count' => 10]);
        $browser->loginAs($user)
            ->visit('/')
            ->with(new Navbar, function (Browser $browser) {
                $browser->assertSeeIn('@navbar-link-messages-link ~ @navbar-link-messages-count', 10);
            });
    });
});
