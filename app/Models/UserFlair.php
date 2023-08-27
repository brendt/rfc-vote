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
            UserFlair::CONTRIBUTOR => "This user has contribute to rfc-vote repository.",
            UserFlair::INTERNALS => "This user is the PHP Internals people.",
            UserFlair::ADMIN => "This user is Admin.",
            UserFlair::LARAVEL => "This user is the member of Laravel core team.",
            UserFlair::SYMFONY => "This user is the member of Symfony core team.",
        };
    }
}
