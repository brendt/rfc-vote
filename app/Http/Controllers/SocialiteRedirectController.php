<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;

final readonly class SocialiteRedirectController
{
    public function __invoke(string $driver)
    {
        return Socialite::driver($driver)->redirect();
    }
}
