<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

final readonly class RegisterController
{
    public function __invoke(): View
    {
        return view('register');
    }
}
