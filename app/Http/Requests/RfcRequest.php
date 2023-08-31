<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RfcRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, ValidationRule|string>|ValidationRule|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'teaser' => ['required', 'string'],
            'description' => ['required', 'string'],
            'published_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date'],
            'url' => ['required', 'url'],
            'externals_url' => ['require', 'sometimes', 'nullable', 'url'],
        ];
    }
}
