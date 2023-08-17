<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $this->get('/')->assertStatus(200);
    }

    public function test_the_application_returns_a_successful_response_when_auth_user_visits_it(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/')
            ->assertStatus(200);
    }

    public function test_the_application_returns_a_successful_response_when_admin_visits_it(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->get('/')
            ->assertStatus(200);
    }
}

