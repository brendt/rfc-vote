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
            self::CONTRIBUTOR => 'This user has contribute to rfc-vote repository.',
            self::INTERNALS => 'This user is the PHP Internals people.',
            self::ADMIN => 'This user is Admin.',
            self::LARAVEL => 'This user is the member of Laravel core team.',
            self::SYMFONY => 'This user is the member of Symfony core team.',
        };
    }
}
