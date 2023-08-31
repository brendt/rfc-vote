<?php

namespace App\Http\Controllers;

use App\Models\Rfc;
use Illuminate\Contracts\View\View;

final readonly class RfcAdminController
{
    public function __invoke(): View
    {
        $rfcs = Rfc::query()->orderByDesc('created_at')->get();

        return view('rfc-admin', [
            'rfcs' => $rfcs,
        ]);
    }
}
