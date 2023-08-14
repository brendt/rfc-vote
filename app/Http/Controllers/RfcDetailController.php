<?php

namespace App\Http\Controllers;

use App\Models\Rfc;

final readonly class RfcDetailController
{
    public function __invoke(Rfc $rfc)
    {
        $rfc->load([
            'arguments.user',
            'arguments.rfc',
        ]);

        $user = auth()->user();

        $user?->load([
            'arguments',
            'argumentVotes.argument',
        ]);

        return view('rfc', [
            'rfc' => $rfc,
            'user' => $user,
        ]);
    }
}
