<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final readonly class EnableEmailOptinController
{
    public const string STAY_UPDATED_MESSAGE = 'Stay updated! Get an email whenever a new RFC is added.';

    public const string BUTTON_MESSAGE = 'Enable notifications';

    public const string ENABLED_MESSAGE = 'Your email preferences were updated!
        You can change them at any time in your Settings.';

    public function __invoke(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->to($request->get('back', '/'));
        }

        $user->update(['email_optin' => true]);

        flash(self::ENABLED_MESSAGE);

        return redirect()->to($request->get('back', '/'));
    }
}
