<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\LoginPage;
use Tests\DuskTestCase;

class LoginPageTest extends DuskTestCase
{
    use DatabaseTruncation;

    public function test_it_allows_users_to_login(): void
    {

        $this->browse(function (Browser $browser) {
            $password = 'password';
            $user = User::factory()->createOne(['password' => bcrypt($password)]);

            $browser->visit(new LoginPage)
                ->fillLoginFormAndSubmit(email: $user->email, password: $password)
                ->assertAuthenticatedAs($user)
                ->on(new HomePage);
        });
    }
}
