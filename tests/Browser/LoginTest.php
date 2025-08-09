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

    public function test_it_redirects_to_homepage_if_user_is_already_authenticated(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->createOne();

            $browser->loginAs($user)
                ->visit('/login')
                ->assertPathIs('/');
        });
    }

    public function test_it_provides_button_to_login_with_github(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new LoginPage)
                ->assertSee('Log in with GitHub');
        });
    }
}
