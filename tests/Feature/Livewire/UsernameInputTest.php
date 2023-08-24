<?php

namespace Tests\Feature\Livewire;

use App\Actions\GenerateUsername;
use App\Http\Livewire\UsernameInput;
use App\Models\User;
use Illuminate\Support\Str;
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
        $value = 'just-a-test';
        $placeholder = 'placeholder';
        $label = 'label';
        $required = true;

        Livewire::test(
            UsernameInput::class,
            [
                'value' => $value,
                'placeholder' => $placeholder,
                'label' => $label,
                'required' => $required,
            ]
        )
            ->assertSet('value', $value)
            ->assertSet('placeholder', $placeholder)
            ->assertSet('label', $label)
            ->assertSet('required', $required);
    }

    /**
     * @dataProvider validationDataProvider
     */
    public function test_value_has_proper_validation(string $fieldKey, array $inputData): void
    {
        User::factory()->create(
            [
                'email' => 'test@test.com',
                'username' => 'test',
            ]
        );
        Livewire::test(UsernameInput::class)
            ->set($fieldKey, $inputData[$fieldKey])
            ->assertHasErrors([$fieldKey]);
    }

    public static function validationDataProvider(): array
    {
        return [
            'Username is required' => ['value', ['value' => null]],
            'Username must have a minimum length of 2' => ['value', ['value' => 't']],
            'Username must have a maximum length of 50' => [
                'value',
                ['value' => (new GenerateUsername)(Str::random(51))],
            ],
            'Username must follow a slug like format' => ['value', ['value' => 'this is not ok']],
            'Username should not start with hyphen' => ['value', ['value' => '-this-is-not-ok']],
            'Username should not end with hyphen' => ['value', ['value' => 'this-is-not-ok-']],
            'Username should not start with underscore' => ['value', ['value' => '_this-is-not-ok']],
            'Username should not end with underscore' => ['value', ['value' => 'this-is-not-ok_']],
            'Username is unique' => ['value', ['value' => 'test']],
        ];
    }
}
