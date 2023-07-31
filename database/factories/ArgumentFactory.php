<?php

namespace Database\Factories;

use App\Models\Argument;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ArgumentFactory extends Factory
{
    protected $model = Argument::class;

    public function definition(): array
    {
        return [
            'user_id' => fn () => User::factory()->create(),
            'rfc_id' => fn () => User::factory()->create(),
            'body' => $this->faker->word(),
            'vote_count' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
