<?php

namespace App\Policies;

use App\Models\Argument;
use App\Models\User;

class ArgumentPolicy
{
    public function edit(User $user, Argument $argument): bool
    {
        return $user->is_admin || $argument->user_id === $user->id;
    }

    public function delete(User $user, Argument $argument): bool
    {
        return $user->is_admin || $argument->user_id === $user->id;
    }
}
