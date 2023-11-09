<?php

use App\Models\User;

test('the application returns a successful response', function () {
    $this->get('/')->assertStatus(200);
});

test('the application returns a successful response when auth user visits it', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/')
        ->assertStatus(200);
});

test('the application returns a successful response when admin visits it', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin)
        ->get('/')
        ->assertStatus(200);
});
