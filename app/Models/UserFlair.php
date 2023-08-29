<?php

namespace App\Models;

enum UserFlair: string
{
    case CONTRIBUTOR = 'contributor';
    case INTERNALS = 'internals';
    case ADMIN = 'admin';
    case LARAVEL = 'laravel';
    case SYMFONY = 'symfony';

    public function getDescription(): string
    {
        return match ($this) {
            self::CONTRIBUTOR => 'This user has contributed to rfc-vote repository.',
            self::INTERNALS => 'This user is a PHP Internals contributor.',
            self::ADMIN => 'This user is Admin.',
            self::LARAVEL => 'This user is a member of Laravel core team.',
            self::SYMFONY => 'This user is a member of Symfony core team.',
        };
    }
}
