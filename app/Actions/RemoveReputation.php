<?php

namespace App\Actions;

use App\Models\ReputationType;
use App\Models\User;

final readonly class RemoveReputation
{
    public function __invoke(User $user, ReputationType $reputationType, int $times = 1): void
    {
        $user->decrement(
            column: 'reputation',
            amount: $reputationType->getPoints() * $times,
        );
    }
}
