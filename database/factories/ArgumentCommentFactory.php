<?php

namespace Database\Factories;

use App\Models\ArgumentComment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ArgumentCommentFactory extends Factory
{
    protected $model = ArgumentComment::class;

    public function definition(): array
    {
        return [
            'body' => $this->faker->paragraphs(fake()->numberBetween(1, 4), true),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
