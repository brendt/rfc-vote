<?php

namespace App\Actions;

use App\Models\Enums\ReputationType;
use App\Models\User;

final readonly class AddReputation
{
    public function __invoke(User $user, ReputationType $reputationType): void
    {
        $user->increment('reputation', $reputationType->getPoints());
    }
}
