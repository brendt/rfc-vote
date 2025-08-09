<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

final readonly class RegisterController
{
    public function __invoke(): RedirectResponse|View
    {
        // Only allow GitHub login
        return redirect('/');
    }
}
