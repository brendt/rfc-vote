<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\LoginPage;
use Tests\DuskTestCase;

class LoginPageTest extends DuskTestCase
{
    use DatabaseTruncation;

    public function test_it_renders_all_elements(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new LoginPage)
                ->assertPresent('@email-field')
                ->assertPresent('@password-field')
                ->assertPresent('@remember-me-field')
                ->assertPresent('@login-form-btn')
                ->assertPresent('@reset-password-link')
                ->assertPresent('@register-link')
                ->assertPresent('@login-with-github-btn');
        });
    }
}
