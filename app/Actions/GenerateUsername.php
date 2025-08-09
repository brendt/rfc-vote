<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Str;

final class GenerateUsername
{
    public function __invoke(User|string $userOrString): string
    {
        if ($userOrString instanceof User) {
            return Str::slug($userOrString->name);
        }

        return Str::slug($userOrString);
    }
}
