<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;

final readonly class SocialiteRedirectController
{
    public function __invoke(string $driver): RedirectResponse|SymfonyRedirectResponse
    {
        return Socialite::driver($driver)->redirect();
    }
}
