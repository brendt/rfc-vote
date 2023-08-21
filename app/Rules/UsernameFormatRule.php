<?php

namespace App\Rules;

use App\Actions\GenerateUsername;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UsernameFormatRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        if (! is_string($value) || $value !== (new GenerateUsername())($value)) {
            $fail('The :attribute must be valid. Only lowercase ASCII characters are allowed. Hyphens can be used. Whitespace, underscores, and multiple hyphens are not permitted. The username cannot start or end with a hyphen.');
        }
    }
}
