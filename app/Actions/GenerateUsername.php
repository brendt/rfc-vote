<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Str;

final class GenerateUsername
{
    public function __invoke(User|string $userOrString): string
    {
        if ($userOrString instanceof User) {
            return $this->generateUsername($userOrString->name);
        }

        return $this->generateUsername($userOrString);
    }

    private function generateUsername(string $string): string
    {
        return Str::slug($string);
    }
}
