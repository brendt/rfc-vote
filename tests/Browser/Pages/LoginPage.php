<?php

namespace Tests\Browser\Pages;

use Facebook\WebDriver\Exception\ElementClickInterceptedException;
use Facebook\WebDriver\Exception\NoSuchElementException;
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
     * @throws ElementClickInterceptedException
     * @throws NoSuchElementException
     */
    public function fillLoginFormAndSubmit(
        Browser $browser,
        string $email,
        string $password,
    ): void {
        $browser->type('@email-field', $email)
            ->type('@password-field', $password)
            ->check('@remember-me-field')
            ->click('@login-form-btn');
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
