<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

final readonly class LogoutController
{
    public function __invoke(): View
    {
        return view('auth.logout');
    }
}
