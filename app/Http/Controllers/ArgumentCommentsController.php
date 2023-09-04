<?php

namespace App\Http\Controllers;

use App\Models\Argument;
use Illuminate\Contracts\View\View;

final readonly class ArgumentCommentsController
{
    public function __invoke(Argument $argument): View
    {
        $user = auth()->user();

        $argument->load([
            'comments.user',
        ]);

        $user?->load([
            'argumentVotes.argument',
        ]);

        return view('argument-comments', [
            'rfc' => $argument->rfc,
            'argument' => $argument,
            'user' => $user,
        ]);
    }
}
