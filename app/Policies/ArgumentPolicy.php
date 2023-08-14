<?php

namespace App\Policies;

use App\Models\Argument;
use App\Models\User;

class ArgumentPolicy
{
    public function vote(User $user, Argument $argument): bool
    {
        if ($user->id === $argument->user_id) {
            return false;
        }

        if ($user->hasVotedForArgument($argument)) {
            return true;
        }

        return $user->can('vote', $argument->rfc);
    }

    public function edit(User $user, Argument $argument): bool
    {
        return $user->is_admin || $argument->user_id === $user->id;
    }

    public function delete(User $user, Argument $argument): bool
    {
        return $user->is_admin || $argument->user_id === $user->id;
    }
}
