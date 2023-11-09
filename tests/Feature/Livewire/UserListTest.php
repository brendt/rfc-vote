<?php

use App\Http\Livewire\UserList;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Livewire;

uses(\Illuminate\Foundation\Testing\LazilyRefreshDatabase::class);

uses(\Illuminate\Foundation\Testing\WithFaker::class);

test('the component can render', function () {
    $component = Livewire::test(UserList::class)
        ->assertStatus(200);
});

it('can filter users by search user name', function () {
    $user1 = $this->faker->name;
    $user2 = $this->faker->name;
    User::factory()->create(['name' => $user1]);
    User::factory()->create(['name' => $user2]);

    Livewire::test(UserList::class)
        ->set('search', $user1)
        ->assertSee($user1)
        ->assertDontSee($user2);
});

it('can filter users by search user email', function () {
    $userEmail1 = $this->faker->email;
    $userEmail2 = $this->faker->email;
    User::factory()->create(['name' => $userEmail1]);
    User::factory()->create(['name' => $userEmail2]);

    Livewire::test(UserList::class)
        ->set('search', Str::limit($userEmail1, 3, ''))
        ->assertSee($userEmail1)
        ->assertDontSee($userEmail2);
});

it('can delete a user', function () {
    $user = User::factory()->create();

    Livewire::test(UserList::class)
        ->call('deleteUser', $user->id)
        ->assertDontSee($user->name);
});
