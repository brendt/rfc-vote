<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class LoginPage extends Page
{
    public function url(): string
    {
        return '/login';
    }

    public function assert(Browser $browser): void
    {
        $browser->assertPathIs($this->url());
    }

    public function fillLoginFormAndSubmit(
        ?Browser $browser = null,
        ?string $email = null,
        ?string $password = null,
    ): Browser {
        $browser->type('email', $email)
            ->type('password', $password)
            ->check('remember')
            ->press('Login');

        return $browser;
    }
}
