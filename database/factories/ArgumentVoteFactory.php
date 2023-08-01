<?php

namespace Database\Factories;

use App\Models\ArgumentVote;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ArgumentVoteFactory extends Factory
{
    protected $model = ArgumentVote::class;

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
