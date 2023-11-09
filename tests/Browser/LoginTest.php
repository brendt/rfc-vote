<?php

uses(\Tests\DuskTestCase::class);
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\LoginPage;

uses(\Illuminate\Foundation\Testing\DatabaseTruncation::class);

test('it allows users to login', function () {
    $this->browse(function (Browser $browser) {
        $password = 'some-test-password';
        $user = User::factory()->createOne(['password' => bcrypt($password)]);

        $browser->visit(new LoginPage)
            ->fillLoginFormAndSubmit(email: $user->email, password: $password)
            ->assertAuthenticatedAs($user)
            ->assertPathIs('/');
    });
});

test('it redirects to homepage if user is already authenticated', function () {
    $this->browse(function (Browser $browser) {
        $user = User::factory()->createOne();

        $browser->loginAs($user)
            ->visit('/login')
            ->assertPathIs('/');
    });
});

test('it displays error if wrong credentials where provided', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit(new LoginPage)
            ->fillLoginFormAndSubmit(email: 'some-bad-email@test.com', password: 'wrongPassword')
            ->assertSee('These credentials do not match our records.')
            ->assertGuest()
            ->assertPathIs('/login');
    });
});

test('it renders a link to reset password', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit(new LoginPage)
            ->clickLink('Forget Password?')
            ->assertPathIs('/forgot-password');
    });
});

test('it renders a link to register', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit(new LoginPage)
            ->clickLink('Register')
            ->assertPathIs('/register');
    });
});

test('it provides button to login with ghithub', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit(new LoginPage)
            ->assertSee('Log in with GitHub');
    });
});
