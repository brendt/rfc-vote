<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Validation\ValidationRule;
use Laravel\Fortify\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, array<int, ValidationRule|string>|ValidationRule|string>
     */
    protected function passwordRules(): array
    {
        return ['required', 'string', new Password, 'confirmed'];
    }
}
