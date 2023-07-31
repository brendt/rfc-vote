<?php

namespace App\Http\Controllers;

use App\Models\Rfc;

final readonly class HomeController
{
    public function __invoke()
    {
        $rfcs = Rfc::all();

        return view('home', [
            'rfcs' => $rfcs,
        ]);
    }
}
