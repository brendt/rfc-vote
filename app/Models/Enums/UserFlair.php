<?php

namespace App\Models\Enums;

enum UserFlair: string
{
    case CONTRIBUTOR = 'contributor';
    case INTERNALS = 'internals';
    case ADMIN = 'admin';
    case LARAVEL = 'laravel';
    case SYMFONY = 'symfony';
}
