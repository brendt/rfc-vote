<?php

namespace App\Http\Controllers;

use App\Actions\GenerateUsername;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Laravel\Socialite\Facades\Socialite;

final readonly class SocialiteCallbackController
{
    public function __invoke(string $driver, Request $request): RedirectResponse
    {
        if ($request->has('error') || $request->missing('code')) {
            return redirect()->route('login');
        }

        $socialiteUser = Socialite::driver('github')->user();

        $user = User::query()->where('email', $socialiteUser->getEmail())->first();

        if (! $user) {

            $user = User::create([
                'email' => $socialiteUser->getEmail(),
                'name' => $socialiteUser->getName() ?? $socialiteUser->getEmail(),
                'username' => $this->resolveUsername($socialiteUser),
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

        $request->session()->regenerate();

        return redirect()->to('/');
    }

    private function resolveUsername(SocialiteUser $socialiteUser): string
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
