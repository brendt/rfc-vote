<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\LoginPage;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseTruncation;

    public function test_it_allows_users_to_login(): void
    {
        $this->browse(function (Browser $browser) {
            $password = 'some-test-password';
            $user = User::factory()->createOne(['password' => bcrypt($password)]);

            $browser->visit(new LoginPage)
                ->fillLoginFormAndSubmit(email: $user->email, password: $password)
                ->assertAuthenticatedAs($user)
                ->assertPathIs('/');
        });
    }

    public function test_it_redirects_to_homepage_if_user_is_already_authenticated(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->createOne();

            $browser->loginAs($user)
                ->visit('/login')
                ->assertPathIs('/');
        });
    }

    public function test_it_displays_error_if_wrong_credentials_where_provided(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new LoginPage)
                ->fillLoginFormAndSubmit(email: 'some-bad-email@test.com', password: 'wrongPassword')
                ->assertSee('These credentials do not match our records.')
                ->assertGuest()
                ->assertPathIs('/login');
        });
    }

    public function test_it_renders_a_link_to_reset_password(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new LoginPage)
                ->clickLink('Forget Password?')
                ->assertPathIs('/forgot-password');
        });
    }

    public function test_it_renders_a_link_to_register(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new LoginPage)
                ->clickLink('Register')
                ->assertPathIs('/register');
        });
    }

    public function test_it_provides_button_to_login_with_ghithub(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new LoginPage)
                ->assertPresent('@login-with-github-btn');
        });
    }
}
