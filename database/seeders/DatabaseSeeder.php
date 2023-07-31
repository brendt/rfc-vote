<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Argument;
use App\Models\User;
use App\Models\Vote;
use Auth;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $mainUser = User::factory()->create([
             'name' => 'Brent',
             'email' => 'brent.roose@jetbrains.com',
             'is_admin' => true,
         ]);

         $users = User::factory()->count(random_int(50, 200))->create();

         $votes = Vote::factory()->count(10)->create();

         foreach ($votes as $vote) {
             foreach ($users as $user) {
                 Argument::factory()->create([
                     'user_id' => $user->id,
                     'vote_id' => $vote->id,
                 ]);
             }

             $vote->updateCounts();
         }
    }
}
