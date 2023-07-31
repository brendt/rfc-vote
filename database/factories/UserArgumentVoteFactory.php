<?php

namespace Database\Factories;

use App\Models\UserArgumentVote;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class UserArgumentVoteFactory extends Factory
{
    protected $model = UserArgumentVote::class;

    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomNumber(),
            'argument_id' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
