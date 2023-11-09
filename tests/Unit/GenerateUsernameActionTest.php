<?php

use App\Actions\GenerateUsername;
use App\Models\User;

test('username generation for user', function () {
    $user = User::factory()->create(['name' => 'John Doe']);

    $username = (new GenerateUsername)($user);

    expect($username)->toEqual('john-doe');
});

test('username generation for string', function () {
    $username = (new GenerateUsername)('one two three');

    expect($username)->toEqual('one-two-three');
});
