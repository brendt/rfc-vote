<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final readonly class EnableEmailOptinController
{
    public function __invoke(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->to($request->get('back', '/'));
        }

        $user->update(['email_optin' => true]);

        flash(<<<'HTML'
        Your email preferences were updated!
        You can change them at any time in your Settings.
        HTML);

        return redirect()->to($request->get('back', '/'));
    }
}
