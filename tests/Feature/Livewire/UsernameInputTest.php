<?php

use App\Actions\GenerateUsername;
use App\Http\Livewire\UsernameInput;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Livewire;

test('component can render', function () {
    $component = Livewire::test(UsernameInput::class);

    $component->assertStatus(200);
});

test('has data passed correctly', function () {
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
});

test('value has proper validation', function (string $fieldKey, array $inputData) {
    User::factory()->create(
        [
            'email' => 'test@test.com',
            'username' => 'test',
        ]
    );
    Livewire::test(UsernameInput::class)
        ->set($fieldKey, $inputData[$fieldKey])
        ->assertHasErrors([$fieldKey]);
})->with('validationDataProvider');

dataset('validationDataProvider', function () {
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
});
