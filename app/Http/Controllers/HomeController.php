<?php

namespace App\Http\Controllers;

use App\Models\Vote;

final readonly class HomeController
{
    public function __invoke()
    {
        $votes = Vote::all();

        return view('home', [
            'user' => request()->user(),
            'votes' => $votes,
        ]);
    }
}
