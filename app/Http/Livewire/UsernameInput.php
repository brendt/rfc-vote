<?php

namespace App\Http\Livewire;

use App\Rules\UsernameFormatRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class UsernameInput extends Component
{
    public string $name;

    public string $label;

    public ?string $value;

    public string $placeholder;

    public bool $required;

    /**
     * @return array<string, array<int, string|ValidationRule>|ValidationRule|string>
     */
    protected function rules(): array
    {
        return [
            'value' => new UsernameFormatRule,
        ];
    }

    public function updated(string $propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function render(): View
    {
        return view('livewire.username-input');
    }
}
