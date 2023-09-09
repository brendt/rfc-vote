<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

final readonly class RegisterController
{
    public function __invoke(): RedirectResponse|View
    {
        if (! Auth::check()) {
            return view('register');
        }

        return redirect('/');
    }
}
