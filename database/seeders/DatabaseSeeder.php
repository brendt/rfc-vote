<?php

namespace Database\Seeders;

use App\Actions\CreateArgument;
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
            'reputation' => 10_000,
        ]);

        $users = User::factory()->count(50)->create();

        $rfcs = Rfc::factory()->count(10)->create([
            'title' => 'Interface Default Methods',
            'published_at' => now()->subDay(),
        ]);

        foreach ($rfcs as $rfc) {
            $majority = fake()->boolean() ? VoteType::YES : VoteType::NO;

            $minority = $majority === VoteType::YES ? VoteType::NO : VoteType::YES;

            foreach ($users as $user) {
                if (fake()->boolean(80)) {
                    (new CreateArgument())(
                        rfc: $rfc,
                        user: $user,
                        voteType: fake()->boolean(70) ? $majority : $minority,
                        body: fake()->paragraphs(fake()->numberBetween(1, 4), true),
                    );
                }
            }
        }
    }
}
