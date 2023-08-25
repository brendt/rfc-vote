<?php

namespace App\Actions;

use App\Models\Argument;
use App\Models\Rfc;
use App\Models\User;
use App\Models\Enums\VoteType;
use Illuminate\Support\Facades\DB;

final readonly class CreateArgument
{
    public function __invoke(Rfc $rfc, User $user, VoteType $voteType, string $body): Argument
    {
        $argument = new Argument([
            'user_id' => $user->id,
            'rfc_id' => $rfc->id,
            'vote_type' => $voteType,
            'body' => $body,
        ]);

        DB::transaction(function () use ($user, $argument) {
            $argument->save();

            (new ToggleArgumentVote)(
                user: $user,
                argument: $argument,
            );
        });

        return $argument;
    }
}
