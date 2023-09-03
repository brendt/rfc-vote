<?php

namespace Tests\Feature;

use App\Http\Controllers\UserEditController;
use App\Models\User;
use App\Models\UserFlair;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminUserTest extends TestCase
{
    use LazilyRefreshDatabase;
    use WithFaker;

    /** @test */
    public function user_management_only_accessible_by_admin()
    {
        $this->login();
        $this->get('/admin/users')
            ->assertRedirect('/');
    }

    /** @test */
    public function edit_rfc_screen_can_be_rendered()
    {
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
    }

    /** @test */
    public function user_can_be_updated()
    {
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
            'is_admin' => (int) $this->faker->boolean,
        ];
        $this->post(action([UserEditController::class, 'update'], $user), $payload)
            ->assertRedirect(action([UserEditController::class, 'update'], $user));

        $this->assertDatabaseCount('users', 2);
        $this->assertDatabaseHas('users', $payload);
    }

    /** @test */
    public function user_request_validation_rules_are_applied()
    {
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
    }
}
