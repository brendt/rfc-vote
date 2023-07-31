<?php

namespace App\Http\Controllers;

use App\Models\Vote;

final readonly class VoteController
{
    public function __invoke(int $voteId)
    {
        $vote = Vote::query()
            ->with('argumentsWithBody.user')
            ->where('id', $voteId)
            ->first();

        return view('vote', [
            'user' => request()->user(),
            'vote' => $vote,
        ]);
    }
}
