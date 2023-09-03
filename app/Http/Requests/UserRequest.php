<?php

namespace App\Http\Requests;

use App\Models\UserFlair;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'username' => ['required', 'string'],
            'email' => ['required', 'email', 'max:255'],
            'website_url' => ['nullable'],
            'github_url' => ['nullable'],
            'twitter_url' => ['nullable'],
            'reputation' => ['required'],
            'flair' => ['nullable', new Enum(UserFlair::class)],
            'is_admin' => ['nullable', 'boolean'],
        ];
    }
}
