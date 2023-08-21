<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\UsernameInput;
use Livewire\Livewire;
use Tests\TestCase;

class UsernameInputTest extends TestCase
{
    public function test_component_can_render(): void
    {
        $component = Livewire::test(UsernameInput::class);

        $component->assertStatus(200);
    }

    public function test_has_data_passed_correctly(): void
    {
        $value       = 'just-a-test';
        $placeholder = 'placeholder';
        $label       = 'label';
        $required    = true;

        Livewire::test(
            UsernameInput::class,
            [
                'value'       => $value,
                'placeholder' => $placeholder,
                'label'       => $label,
                'required'    => $required,
            ]
        )
                ->assertSet('value', $value)
                ->assertSet('placeholder', $placeholder)
                ->assertSet('label', $label)
                ->assertSet('required', $required);
    }
}
