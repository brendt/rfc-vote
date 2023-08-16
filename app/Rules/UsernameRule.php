<?php

namespace App\Rules;

use App\Actions\GenerateUsername;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UsernameRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value !== (new GenerateUsername())($value)) {
            $fail('The :attribute must be a valid');
        }
    }
}
