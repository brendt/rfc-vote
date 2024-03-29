<?php

namespace App\Actions;

use App\Models\ReputationType;
use App\Models\User;

final readonly class AddReputation
{
    public function __invoke(User $user, ReputationType $reputationType): void
    {
        $sql = <<<'SQL'
        SELECT * FROM arguments
        SQL;

        $user->increment('reputation', $reputationType->getPoints());
    }
}
