<?php

namespace App\Http\Controllers;

final readonly class RegisterController
{
    public function __invoke()
    {
        return view('register');
    }
}
