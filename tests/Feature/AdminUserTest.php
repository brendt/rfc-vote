<?php

use App\Http\Controllers\UserEditController;
use App\Models\User;
use App\Models\UserFlair;

uses(\Illuminate\Foundation\Testing\LazilyRefreshDatabase::class);

uses(\Illuminate\Foundation\Testing\WithFaker::class);

test('user management only accessible by admin', function () {
    $this->login();
    $this->get('/admin/users')
        ->assertRedirect('/');
});

test('edit rfc screen can be rendered', function () {
    $user = User::factory()->create();
    $this->login(isAdmin: true);

    $this->get(action([UserEditController::class, 'edit'], $user))
        ->assertViewIs('user-form')
        ->assertSee($user->name)
        ->assertSee($user->username)
        ->assertSee($user->website_url)
        ->assertSee($user->github_url)
        ->assertSee($user->twitter_url)
        ->assertSee($user->reputation)
        ->assertSee($user->flair)
        ->assertSee($user->is_admin)
        ->assertSee('Save')
        ->assertOk();
});

test('user can be updated', function () {
    $user = User::factory()->create();
    $this->login(isAdmin: true);
    $flair = $this->faker->randomElement(array_column(UserFlair::cases(), 'value'));
    $payload = [
        'name' => $this->faker->name,
        'username' => $this->faker->userName,
        'email' => $this->faker->email,
        'website_url' => $this->faker->url,
        'github_url' => $this->faker->url,
        'twitter_url' => $this->faker->url,
        'reputation' => $this->faker->numberBetween(999, 3000),
        'flair' => $flair,
    ];
    $isAdmin = (int) $this->faker->boolean;
    if ($isAdmin) {
        $payload['is_admin'] = $isAdmin;
    }

    $this->post(action([UserEditController::class, 'update'], $user), $payload)
        ->assertRedirect(action([UserEditController::class, 'update'], $user));

    $this->assertDatabaseCount('users', 2);
    if (! $isAdmin) {
        $payload['is_admin'] = 0;
    }
    $this->assertDatabaseHas('users', $payload);
});

test('user request validation rules are applied', function () {
    $user = User::factory()->create();
    $this->login(isAdmin: true);

    $invalidData = [
        'name' => '',
        'username' => 1333,
        'email' => 'invalid-email',
        'website_url' => 'not-a-url',
        'reputation' => '',
    ];
    $this->post(action([UserEditController::class, 'update'], $user), $invalidData)
        ->assertStatus(302)
        ->assertSessionHasErrors('name')
        ->assertSessionHasErrors('username')
        ->assertSessionHasErrors('email')
        ->assertSessionHasErrors('website_url')
        ->assertSessionHasErrors('reputation');
});
