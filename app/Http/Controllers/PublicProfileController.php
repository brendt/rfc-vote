<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;

final readonly class PublicProfileController
{
    public function __invoke(User $user): View
    {
        $user->load([
            'arguments.rfc',
            'argumentVotes.argument.rfc',
            'argumentVotes.argument.user',
        ]);

        $user->loadCount('arguments', 'argumentVotes');

        return view('public-profile', compact('user'));
    }
}
