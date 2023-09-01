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

    /**
     * @return array<string, string>
     */
    public function elements(): array
    {
        return [
            '@email-field' => 'input[name="email"]',
            '@password-field' => 'input[name="password"]',
            '@remember-me-field' => 'input[name="remember"]',
            '@login-form-btn' => 'button[type="submit"]',
        ];
    }
}
