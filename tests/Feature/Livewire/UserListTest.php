<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\UserList;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class UserListTest extends TestCase
{
    use LazilyRefreshDatabase;
    use WithFaker;

    /** @test */
    public function the_component_can_render(): void
    {
        $component = Livewire::test(UserList::class)
            ->assertStatus(200);
    }

    /** @test */
    public function it_can_filter_users_by_search_user_name(): void
    {
        $user1 = $this->faker->name;
        $user2 = $this->faker->name;
        User::factory()->create(['name' => $user1]);
        User::factory()->create(['name' => $user2]);

        Livewire::test(UserList::class)
            ->set('search', $user1)
            ->assertSee($user1)
            ->assertDontSee($user2);
    }

    /** @test */
    public function it_can_filter_users_by_search_user_email(): void
    {
        $userEmail1 = $this->faker->email;
        $userEmail2 = $this->faker->email;
        User::factory()->create(['name' => $userEmail1]);
        User::factory()->create(['name' => $userEmail2]);

        Livewire::test(UserList::class)
            ->set('search', Str::limit($userEmail1, 3, ''))
            ->assertSee($userEmail1)
            ->assertDontSee($userEmail2);
    }

    /** @test */
    public function it_can_delete_a_user(): void
    {
        $user = User::factory()->create();

        Livewire::test(UserList::class)
            ->call('deleteUser', $user->id)
            ->assertDontSee($user->name);
    }
}
