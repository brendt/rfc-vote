<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;
    use RefreshDatabase;

    public function login(User $user = null, bool $isAdmin = false): User
    {
        $user ??= User::factory()->create([
            'is_admin' => $isAdmin,
        ]);

        $this->actingAs($user);

        return $user;
    }
}
