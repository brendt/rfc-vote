<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

final readonly class DisableEmailOptinController
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->to($request->get('back', '/'));
        }

        $user->update([
            'email_optin' => false,
        ]);

        flash("Your email preferences were updated!");

        return redirect()->to($request->get('back', '/'));
    }
}
