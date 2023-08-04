<?php

namespace App\Http\Controllers;

use App\Models\Rfc;

final readonly class RfcAdminController
{
    public function __invoke()
    {
        $rfcs = Rfc::query()->orderByDesc('created_at')->get();

        return view('rfc-admin', [
            'rfcs' => $rfcs,
        ]);
    }
}
