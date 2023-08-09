<?php

namespace App\Http\Controllers;

final readonly class AboutController
{
    public function __invoke()
    {
        return view('about');
    }
}
