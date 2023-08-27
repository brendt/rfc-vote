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
        return $this->messages()[$this->value];
    }

    private function messages(): array
    {   
        return [
            'contributor' => 'This user has contribute to rfc-vote repository.',
            'internals' => 'This user is the PHP Internals people.',
            'admin' => 'This user is Admin.',
            'laravel' => 'This user is the member of Laravel core team.',
            'symfony' => 'This user is the member of Symfony core team.',
        ];
    }
}
