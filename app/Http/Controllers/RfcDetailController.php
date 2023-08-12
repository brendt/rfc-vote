<?php

namespace App\Http\Controllers;

use App\Models\Rfc;

final readonly class RfcDetailController
{
    public function __invoke(Rfc $rfc)
    {
        $rfc->load([
            'arguments.user',
        ]);

        $user = auth()->user();

        return view('rfc', [
            'rfc' => $rfc,
            'user' => $user,
        ]);
    }
}
