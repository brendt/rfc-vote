<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class RegisterPage extends Page
{
    public function url(): string
    {
        return '/register';
    }

    public function assert(Browser $browser): void
    {
        $browser->assertPathIs($this->url());
    }

    public function fillRegisterFormAndSubmit(
        Browser $browser = null,
        string $name = null,
        string $email = null,
        string $username = null,
        string $password = null,
        string $confirmPassword = null
    ): Browser {
        $browser->type('name', $name)
            ->type('email', $email)
            ->type('username', $username)
            ->type('password', $password)
            ->type('password_confirmation', $confirmPassword)
            ->press('Register');

        return $browser;
    }
}
