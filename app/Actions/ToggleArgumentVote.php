<?php

namespace App\Actions;

use App\Models\Argument;
use App\Models\ArgumentVote;
use App\Models\ReputationType;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final readonly class ToggleArgumentVote
{
    public function __invoke(User $user, Argument $argument): void
    {
        DB::transaction(function () use ($user, $argument) {
            $argumentVote = $user->getArgumentVoteForArgument($argument);

            if ($argumentVote) {
                $argumentVote->delete();

                (new RemoveReputation)(
                    user: $user,
                    reputationType: ReputationType::VOTE_FOR_ARGUMENT,
                );

                (new RemoveReputation)(
                    user: $argument->user,
                    reputationType: ReputationType::GAIN_ARGUMENT_VOTE,
                );
            } else {
                if (!$argument->user()->is($user)) {
                    ArgumentVote::create([
                        'argument_id' => $argument->id,
                        'user_id' => $user->id,
                    ]);

                    (new AddReputation)(
                        user: $user,
                        reputationType: ReputationType::VOTE_FOR_ARGUMENT,
                    );
                }

                (new AddReputation)(
                    user: $argument->user,
                    reputationType: ReputationType::GAIN_ARGUMENT_VOTE,
                );
            }

            $argument->update([
                'vote_count' => $argument->votes()->count(),
            ]);

            $argument->rfc->updateVoteCount();
        });
    }
}
