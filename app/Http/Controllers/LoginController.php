<?php

namespace App\Http\Controllers;

final readonly class LoginController
{
    public function __invoke()
    {
        return view('login');
    }
}
