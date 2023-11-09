<?php

use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->url = action([ProfileController::class, 'update']);
});

test('user can update name and username', function () {
    $user = User::factory()->create();

    $formData = [
        'name' => 'Anna',
        'username' => 'anna',
    ];

    $this->actingAs($user)->post($this->url, $formData);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        ...$formData,
    ]);
});

test('user can update urls', function () {
    $user = User::factory()->create();

    $formData = [
        'name' => 'Anna',
        'username' => 'anna',
        'website_url' => 'https://anna.com',
        'twitter_url' => 'https://twitter.com/anna',
        'github_url' => 'https://github.com/anna',
    ];

    $this->actingAs($user)->post($this->url, $formData);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        ...$formData,
    ]);
});

test('username is required', function () {
    $user = User::factory()->create();

    $formData = ['name' => 'Sam'];

    $this->actingAs($user)
        ->post($this->url, $formData)
        ->assertSessionHasErrors('username');
});

test('name is required', function () {
    $user = User::factory()->create();

    $formData = ['username' => 'serhii-cho'];

    $this->actingAs($user)
        ->post($this->url, $formData)
        ->assertSessionHasErrors('name');
});

test('name cannot be more than 255 characters', function () {
    $user = User::factory()->create();

    $formData = [
        'name' => str_repeat('a', 256),
        'username' => 'anna',
    ];

    $this->actingAs($user)
        ->post($this->url, $formData)
        ->assertSessionHasErrors('name');
});

test('username cannot be more than 255 characters', function () {
    $user = User::factory()->create();

    $formData = [
        'username' => str_repeat('a', 256),
        'name' => 'anna',
    ];

    $this->actingAs($user)
        ->post($this->url, $formData)
        ->assertSessionHasErrors('username');
});

test('website url cannot be more than 255 characters', function () {
    $user = User::factory()->create();

    $formData = [
        'username' => 'anna',
        'name' => 'Anna',
        'website_url' => str_repeat('a', 256),
    ];

    $this->actingAs($user)
        ->post($this->url, $formData)
        ->assertSessionHasErrors('website_url');
});

test('github url cannot be more than 255 characters', function () {
    $user = User::factory()->create();

    $formData = [
        'username' => 'anna',
        'name' => 'Anna',
        'github_url' => str_repeat('a', 256),
    ];

    $this->actingAs($user)
        ->post($this->url, $formData)
        ->assertSessionHasErrors('github_url');
});

test('twitter url cannot be more than 255 characters', function () {
    $user = User::factory()->create();

    $formData = [
        'username' => 'anna',
        'name' => 'Anna',
        'twitter_url' => str_repeat('a', 256),
    ];

    $this->actingAs($user)
        ->post($this->url, $formData)
        ->assertSessionHasErrors('twitter_url');
});

test('it saves avatar', function () {
    $user = User::factory()->create();
    Storage::fake();

    $formData = [
        'username' => 'anna',
        'name' => 'Anna',
        'avatar' => UploadedFile::fake()->image('avatar.jpg'),
    ];

    $this->actingAs($user)->post($this->url, $formData);

    $fileName = $formData['avatar']->hashName();

    Storage::assertExists("public/avatars/{$fileName}");

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'avatar' => "public/avatars/{$fileName}",
    ]);
});

test('avatar is not updated to null when avatar in request is null', function () {
    $avatar = 'public/avatars/alex.jpg';
    $user = User::factory()->create(compact('avatar'));

    $formData = [
        'username' => 'alex',
        'name' => 'alex',
        'avatar' => null,
    ];

    $this->actingAs($user)->post($this->url, $formData);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'avatar' => $avatar,
    ]);
});

test('avatar is not updated to null when not provided', function () {
    $avatar = 'public/avatars/sam.jpg';
    $user = User::factory()->create(compact('avatar'));

    $formData = [
        'username' => 'sam',
        'name' => 'Sam',
    ];

    $this->actingAs($user)->post($this->url, $formData);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'avatar' => $avatar,
    ]);
});
