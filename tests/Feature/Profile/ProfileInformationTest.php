<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Laravel\Jetstream\Http\Livewire\UpdateProfileInformationForm;
use Livewire\Livewire;

test('current profile information is available', function () {
    $this->actingAs($user = User::factory()->create());

    $component = Livewire::test(UpdateProfileInformationForm::class);

    expect($component->state['name'])->toEqual($user->name);
    expect($component->state['email'])->toEqual($user->email);
});

test('profile information can be updated', function () {
    $this->actingAs($user = User::factory()->create());

    $file = UploadedFile::fake()->image('avatar.png');

    Livewire::test(UpdateProfileInformationForm::class)
        ->set('state', ['name' => 'Test Name', 'email' => 'test@example.com'])
        ->set('photo', $file)
        ->call('updateProfileInformation');

    expect($user->fresh()->name)->toEqual('Test Name');
    expect($user->fresh()->email)->toEqual('test@example.com');
    expect($user->fresh()->profile_photo_path)->not->toBeNull();
});

test('profile update force full', function () {
    $this->actingAs($user = User::factory()->create());

    $originalEmail = $user->email;

    Livewire::test(UpdateProfileInformationForm::class)
        ->set('state', ['name' => 'Test Name', 'email' => $originalEmail])
        ->call('updateProfileInformation');

    expect($user->fresh()->name)->toEqual('Test Name');
    expect($user->fresh()->email)->toEqual($originalEmail);
});
