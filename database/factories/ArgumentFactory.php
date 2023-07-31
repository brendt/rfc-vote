<?php

namespace Database\Factories;

use App\Models\Argument;
use App\Models\User;
use App\Models\Vote;
use App\Models\VoteType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ArgumentFactory extends Factory
{
    protected $model = Argument::class;

    public function definition(): array
    {
        return [
            'user_id' => fn () => User::factory()->create(),
            'vote_id' => fn () => Vote::factory()->create(),
            'vote_count' => $this->faker->numberBetween(0, 20),
            'type' => $this->faker->boolean(70) ? VoteType::YES : VoteType::NO,
            'body' => $this->faker->boolean(2) ? $this->faker->paragraph(2) : null,
            'is_highlighted' => $this->faker->boolean(20),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
