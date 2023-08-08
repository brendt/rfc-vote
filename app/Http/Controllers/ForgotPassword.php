<?php

namespace App\Http\Controllers;

final readonly class ForgotPassword
{
    public function __invoke()
    {
        return view('auth.forgot-password');
    }
}
