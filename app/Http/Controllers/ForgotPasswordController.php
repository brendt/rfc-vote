<?php

namespace App\Http\Controllers;

final readonly class ForgotPasswordController
{
    public function __invoke()
    {
        return view('auth.forgot-password');
    }
}
