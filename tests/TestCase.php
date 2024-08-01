<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Spatie\Browsershot\Browsershot;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        app()->singleton(Browsershot::class, function () {
            return new FakeBrowsershot;
        });
    }

    public function login(?User $user = null, bool $isAdmin = false): User
    {
        $user ??= User::factory()->create([
            'is_admin' => $isAdmin,
        ]);

        $this->actingAs($user);

        return $user;
    }
}
