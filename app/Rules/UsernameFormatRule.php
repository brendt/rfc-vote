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
            $fail('The :attribute must be a valid');
        }
    }
}
