<?php

namespace Database\Factories;

use App\Models\Argument;
use App\Models\ArgumentVote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ArgumentVoteFactory extends Factory
{
    protected $model = ArgumentVote::class;

    public function definition(): array
    {
        return [
            'user_id' => fn () => User::factory()->create(),
            'argument_id' => fn () => Argument::factory()->create(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
