<?php

namespace App\Http\Controllers;

use App\Models\User;

final readonly class PublicProfileController
{
    public function __invoke(User $user)
    {
        $user->load([
            'arguments.rfc',
            'argumentVotes.argument.rfc',
            'argumentVotes.argument.user',
        ]);

        $user->loadCount('arguments', 'argumentVotes');

        return view('publicProfile', compact('user'));
    }
}
