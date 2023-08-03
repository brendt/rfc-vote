<?php

namespace App\Http\Controllers;

use App\Models\Rfc;

final readonly class HomeController
{
    public function __invoke()
    {
        $rfcs = Rfc::query()
            ->whereNotNull('published_at')
            ->orderByDesc('created_at')
            ->get();

        return view('home', [
            'rfcs' => $rfcs,
        ]);
    }
}
