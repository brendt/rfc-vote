<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

final readonly class SocialiteCallbackController
{
    public function __invoke(string $driver)
    {
        $socialiteUser = Socialite::driver('github')->user();

        $user = User::query()->where('email', $socialiteUser->getEmail())->first();

        if (! $user) {
            $user = User::create([
                'email' => $socialiteUser->getEmail(),
                'name' => $socialiteUser->getName() ?? $socialiteUser->getEmail(),
                'reputation' => 0,
                'socialite' => serialize($socialiteUser),
            ]);
        }

        if (! $user->email_verified_at) {
            $user->update([
                'email_verified_at' => now(),
            ]);
        }

        Auth::login($user);

        return redirect()->to('/');
    }
}
