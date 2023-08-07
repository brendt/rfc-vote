<?php

namespace Database\Seeders;

use App\Models\Rfc;
use App\Models\User;
use App\Models\VoteType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Brent',
            'email' => 'brendt@stitcher.io',
            'is_admin' => true,
        ]);

        $users = User::factory()->count(50)->create();

        $rfcs = Rfc::factory()->count(10)->create([
            'title' => 'Interface Default Methods',
            'published_at' => now()->subDay(),
        ]);

        foreach ($rfcs as $rfc) {
            foreach ($users as $user) {
                if (fake()->boolean(80)) {
                    $user->createVote($rfc, fake()->boolean(70) ? VoteType::YES : VoteType::NO);

                    if (fake()->boolean(20)) {
                        $user->saveArgument($rfc, fake()->paragraphs(fake()->numberBetween(1, 4), true));
                    }
                }
            }
        }
    }
}
