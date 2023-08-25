<?php

namespace App\Http\Requests\Profile;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', Rule::unique('users', 'username')->ignore($this->user()->id)],
            'website_url' => ['nullable', 'url'],
            'github_url' => ['nullable', 'url'],
            'twitter_url' => ['nullable', 'url'],
            'avatar' => ['nullable', File::types(['png', 'jpg'])->max(1024)],
        ];
    }
}
