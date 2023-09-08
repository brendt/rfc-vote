<?php

namespace App\Http\Requests;

use App\Models\UserFlair;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int,Enum|string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'username' => ['required', 'string'],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')
                    ->ignore($this->route('user')),
                'max:255'],
            'website_url' => ['nullable', 'url'],
            'github_url' => ['nullable', 'url'],
            'twitter_url' => ['nullable', 'url'],
            'reputation' => ['required'],
            'flair' => ['nullable', new Enum(UserFlair::class)],
            'is_admin' => ['nullable', 'boolean'],
        ];
    }
}
