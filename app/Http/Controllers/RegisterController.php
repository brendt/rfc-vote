<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

final readonly class RegisterController
{
    public function __invoke(): RedirectResponse|View
    {
        // Only allow GitHub login
        return redirect('/');

        if (! Auth::check()) {
            return view('auth.register');
        }

        return redirect('/');
    }
}
