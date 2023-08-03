<?php

namespace Database\Factories;

use App\Models\Rfc;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RfcFactory extends Factory
{
    protected $model = Rfc::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'url' => $this->faker->url(),
            'description' => $this->faker->sentences(3, true),
            'count_yes' => 0,
            'count_no' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
