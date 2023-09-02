<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\RegisterPage;
use Tests\DuskTestCase;

class RegistrationTest extends DuskTestCase
{
    use DatabaseTruncation;

    public function test_it_allows_users_to_register(): void
    {
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
    }

    public function test_it_redirects_to_homepage_if_the_user_accessing_register_is_already_logged_in(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $browser->loginAs($user)
                ->visit('/register')
                ->assertPathIs('/');
        });
    }

    public function test_it_displays_information_about_email_notifications_to_newly_registered_users(): void
    {
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
    }

    public function test_it_validated_that_email_has_to_be_unique(): void
    {
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
    }

    public function test_it_validates_that_username_has_to_be_unique(): void
    {
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
    }

    public function test_it_validates_that_username_has_to_be_of_certain_format(): void
    {
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
    }

    public function test_it_validates_that_password_is_of_a_minimum_length(): void
    {
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
    }

    public function test_it_validates_that_password_and_confirm_password_fields_match(): void
    {
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
    }
}
