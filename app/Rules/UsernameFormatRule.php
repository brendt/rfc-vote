<?php

namespace App\Rules;

use App\Actions\GenerateUsername;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Validation\Validator;

class UsernameFormatRule implements ValidationRule, ValidatorAwareRule
{
    protected Validator $validator;

    protected array $rules = [
        'required',
        'doesnt_start_with:-,_',
        'doesnt_end_with:-,_',
        'string',
        'min:2',
        'max:50',
        'unique:users,username',
    ];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $validator = ValidatorFacade::make(
            [$attribute => $value],
            [$attribute => $this->rules],
        )->after(function () use ($value, $fail) {
            if (! is_string($value)) {
                return;
            }

            if ($value !== (new GenerateUsername())($value)) {
                $fail(
                    __(
                        'The :attribute must be valid. Only lowercase characters and non-repeating hyphens (-) are allowed.'
                    )
                );
            }
        });

        if ($validator->fails()) {
            $this->validator->errors()->merge($validator->errors());
            $failedRules = $validator->failed()[$attribute];
            collect($failedRules)->each(
                fn ($failedRuleItem, $failedRuleKey) => $this->validator->addFailure(
                    $attribute,
                    $failedRuleKey,
                    $failedRuleItem
                )
            );
        }
    }

    public function setValidator(Validator $validator): void
    {
        $this->validator = $validator;
    }
}
