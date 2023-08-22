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

    /**
     * @dataProvider validationDataProvider
     */
    public function test_value_has_proper_validation(string $fieldKey, array $inputData): void
    {
        User::factory()->create(
            [
                'email'    => 'test@test.com',
                'username' => 'test',
            ]
        );
        Livewire::test(UsernameInput::class)
                ->set($fieldKey, $inputData[$fieldKey])
                ->assertHasErrors([$fieldKey]);
    }

    public function test_value_follows_specific_rule(): void
    {
        Livewire::test(UsernameInput::class)
                ->set('value', 'Another bad username')
                ->assertSee(
                    'The value must be valid. Only lowercase ASCII characters are allowed. Hyphens can be used. Whitespace, underscores, and multiple hyphens are not permitted. The username cannot start or end with a hyphen.'
                );
    }

    public static function validationDataProvider(): array
    {
        return [
            'Value is required'                      => ['value', ['value' => null]],
            'Value must have a minimum length of 1'  => ['value', ['value' => '']],
            'Value must have a maximum length of 50' => [
                'value',
                ['value' => (new GenerateUsername)(Str::random(51))]
            ],
            'Value is unique'                        => ['value', ['value' => 'test']],
        ];
    }

}
