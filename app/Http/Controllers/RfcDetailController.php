<?php

namespace App\Http\Controllers;

use App\Models\Rfc;

final readonly class RfcDetailController
{
    public function __invoke(Rfc $rfc)
    {
        $rfc->load([
            'votes',
            'arguments.user',
        ]);

        $user = auth()->user();

        $vote = $user?->getVoteForRfc($rfc);

        return view('rfc', [
            'rfc' => $rfc,
            'user' => $user,
            'vote' => $vote,
        ]);
    }
}
