<?php

namespace App\Http\Controllers;

use App\Actions\GenerateUsername;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Contracts\User as SocialiteUser;
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
                'username' => $this->resolveUserName($socialiteUser),
                'reputation' => 0,
                'socialite' => serialize($socialiteUser),
            ]);
        }

        Auth::login($user);

        return redirect()->to('/');
    }

    private function resolveUserName(SocialiteUser $socialiteUser): string
    {
        $username = (new GenerateUsername)($socialiteUser->getNickname()); // normalize username to our rules

        /**
         * We need to check for duplicates, this is because users can register directly on the app and because of
         * that there is a chance that when a user attempts to register with github the username is already taken.
         */
        $usernameCount = User::query()->where('username', 'like', "{$username}%")->count() + 1;

        return $usernameCount === 1 ? $username : "{$username}-{$usernameCount}";
    }
}
