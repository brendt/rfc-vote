<?php

namespace App\Actions;

use App\Models\Argument;
use App\Models\ReputationType;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final readonly class DeleteArgument
{
    public function __invoke(User $user, Argument $argument): void
    {
        if (! $user->can('delete', $argument)) {
            return;
        }

        DB::transaction(function () use ($argument) {
            $argumentUser = $argument->user;

            (new RemoveReputation)(
                user: $argumentUser,
                reputationType: ReputationType::GAIN_ARGUMENT_VOTE,
                times: $argument->votes->count(),
            );

            (new RemoveReputation)(
                user: $argumentUser,
                reputationType: ReputationType::VOTE_FOR_ARGUMENT,
            );

            $argument->delete();

            $argument->rfc->updateVoteCount();
        });
    }
}
