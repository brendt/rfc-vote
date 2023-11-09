<?php

uses(\Tests\DuskTestCase::class);
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\RegisterPage;

uses(\Illuminate\Foundation\Testing\DatabaseTruncation::class);

test('it allows users to register', function () {
    $this->browse(function (Browser $browser) {
        $user = User::factory()->make();
        $browser->visit(new RegisterPage)
            ->fillRegisterFormAndSubmit(
                name: $user->name,
                email: $user->email,
                username: $user->username,
                password: 'password',
                confirmPassword: 'password',
            )->assertPathIs('/')
            ->assertAuthenticated();
    });
});

test('it redirects to homepage if the user accessing register is already logged in', function () {
    $this->browse(function (Browser $browser) {
        $user = User::factory()->create();
        $browser->loginAs($user)
            ->visit('/register')
            ->assertPathIs('/');
    });
});

test('it displays information about email notifications to newly registered users', function () {
    $this->browse(function (Browser $browser) {
        $user = User::factory()->make();
        $browser->visit(new RegisterPage)
            ->fillRegisterFormAndSubmit(
                name: $user->name,
                email: $user->email,
                username: $user->username,
                password: 'password',
                confirmPassword: 'password',
            )->assertPathIs('/')
            ->assertAuthenticated()
            ->assertSee("We've added email notifications. We'll email you when a new RFC is added so that you don't have to check the website manually.")
            ->assertSeeLink('Enable it here');
    });
});

test('it validated that email has to be unique', function () {
    $this->browse(function (Browser $browser) {
        User::factory()->create(['email' => 'test@test.com']);
        $user = User::factory()->make();

        $browser->visit(new RegisterPage)
            ->fillRegisterFormAndSubmit(
                name: $user->name,
                email: 'test@test.com',
                username: $user->username,
                password: 'password',
                confirmPassword: 'password',
            )
            ->assertSee('The email has already been taken');
    });
});

test('it validates that username has to be unique', function () {
    $this->browse(function (Browser $browser) {
        User::factory()->create(['username' => 'test']);
        $user = User::factory()->make();

        $browser->visit(new RegisterPage)
            ->fillRegisterFormAndSubmit(
                name: $user->name,
                email: $user->email,
                username: 'test',
                password: 'password',
                confirmPassword: 'password',
            )
            ->assertSee('The username has already been taken');
    });
});

test('it validates that username has to be of certain format', function () {
    $this->browse(function (Browser $browser) {
        User::factory()->create(['username' => 'test']);
        $user = User::factory()->make();

        $browser->visit(new RegisterPage)
            ->fillRegisterFormAndSubmit(
                name: $user->name,
                email: $user->email,
                username: 'invalid username',
                password: 'password',
                confirmPassword: 'password',
            )
            ->assertSee('The username must be valid. Only lowercase characters and non-repeating hyphens (-) are allowed.');
    });
});

test('it validates that password is of a minimum length', function () {
    $this->browse(function (Browser $browser) {
        User::factory()->create(['username' => 'test']);
        $user = User::factory()->make();

        $browser->visit(new RegisterPage)
            ->fillRegisterFormAndSubmit(
                name: $user->name,
                email: $user->email,
                username: $user->username,
                password: 'p',
                confirmPassword: 'p',
            )
            ->assertSee('The password must be at least 8 characters');
    });
});

test('it validates that password and confirm password fields match', function () {
    $this->browse(function (Browser $browser) {
        User::factory()->create(['username' => 'test']);
        $user = User::factory()->make();

        $browser->visit(new RegisterPage)
            ->fillRegisterFormAndSubmit(
                name: $user->name,
                email: $user->email,
                username: $user->username,
                password: 'password',
                confirmPassword: 'password2',
            )
            ->assertSee('The password field confirmation does not match');
    });
});
