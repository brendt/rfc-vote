<?php

namespace App\Http\Livewire;

use App\Rules\UsernameFormatRule;
use Illuminate\Contracts\Foundation\Application as ApplicationAlias;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class UsernameInput extends Component
{
    public string $name;

    public string $label;

    public ?string $value;

    public string $placeholder;

    public bool $required;

    protected function rules(): array
    {
        return [
            'value' => ['required', 'string', 'min:1', 'max:50', 'unique:users,username', new UsernameFormatRule],
        ];
    }

    public function updated(string $propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function render(): View|Application|Factory|ApplicationAlias
    {
        return view('livewire.username-input');
    }
}
