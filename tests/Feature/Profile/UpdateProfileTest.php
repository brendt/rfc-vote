<?php

namespace Tests\Feature\Profile;

use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class UpdateProfileTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_user_can_update_name_and_username(): void
    {
        $user = User::factory()->create();

        $form_data = [
            'name' => 'Anna',
            'username' => 'anna',
        ];

        $this->actingAs($user)
            ->post(action([ProfileController::class, 'update']), $form_data);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $form_data['name'],
            'username' => $form_data['username'],
        ]);
    }
}
