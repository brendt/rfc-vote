<?php

namespace App\Http\Controllers;

final readonly class LogoutController
{
    public function __invoke()
    {
        return view('logout');
    }
}
