<?php

namespace App\Http\Controllers;

final readonly class HomeController
{
    public function __invoke()
    {
        return view('home');
    }
}
