<?php

namespace App\Policies;

use App\Models\Rfc;
use App\Models\User;

class RfcPolicy
{
    public function vote(User $user, Rfc $rfc): bool
    {
        $maxAmount = $user->getVotesPerRfc();

        return $maxAmount > $user->getArgumentVotesForRfc($rfc)->count();
    }
}
