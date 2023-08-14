<?php

namespace App\Http\Controllers;

use App\Models\User;

final readonly class PublicProfileController
{
    public function __invoke(User $user)
    {
        return view('publicProfile', [
            'user' => $user->load([
                'arguments.rfc',
                'argumentVotes.argument.rfc',
                'argumentVotes.argument.user',
            ]),
        ]);
    }
}
