<?php

namespace Database\Seeders;

use App\Models\Rfc;
use App\Models\User;
use App\Models\Vote;
use App\Models\VoteType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Brent',
            'email' => 'brent.roose@jetbrains.com',
            'is_admin' => true,
        ]);

        $users = User::factory()->count(50)->create();

        $rfcs = Rfc::factory()->count(1)->create([
            'title' => 'Interface Default Methods',
        ]);

        foreach ($rfcs as $rfc) {
            foreach ($users as $user) {
                $user->createVote($rfc, fake()->boolean(70) ? VoteType::YES : VoteType::NO);
            }
        }
    }
}
