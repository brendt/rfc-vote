<?php

namespace Tests\Feature\Profile;

use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class UpdateProfileTest extends TestCase
{
    use LazilyRefreshDatabase;

    private string $url;

    public function setUp(): void
    {
        parent::setUp();
        $this->url = action([ProfileController::class, 'update']);
    }

    public function test_user_can_update_name_and_username(): void
    {
        $user = User::factory()->create();

        $formData = [
            'name' => 'Anna',
            'username' => 'anna',
        ];

        $this->actingAs($user)->post($this->url, $formData);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $formData['name'],
            'username' => $formData['username'],
        ]);
    }

    public function test_username_is_required(): void
    {
        $user = User::factory()->create();

        $formData = ['name' => 'Sam'];

        $this->actingAs($user)
            ->post($this->url, $formData)
            ->assertSessionHasErrors('username');
    }

    public function test_name_is_required(): void
    {
        $user = User::factory()->create();

        $formData = ['username' => 'serhii-cho'];

        $this->actingAs($user)
             ->post($this->url, $formData)
             ->assertSessionHasErrors('name');
    }

    public function test_name_cannot_be_more_than_255_characters(): void
    {
        $user = User::factory()->create();

        $formData = [
            'name' => str_repeat('a', 256),
            'username' => 'anna',
        ];

        $this->actingAs($user)
            ->post($this->url, $formData)
            ->assertSessionHasErrors('name');
    }
}
