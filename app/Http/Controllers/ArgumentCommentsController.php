<?php

namespace App\Http\Controllers;

use App\Models\Argument;

final readonly class ArgumentCommentsController
{
    public function __invoke(Argument $argument)
    {
        $user = auth()->user();

        return view('argument-comments', [
            'rfc' => $argument->rfc,
            'argument' => $argument,
            'user' => $user,
        ]);
    }
}
