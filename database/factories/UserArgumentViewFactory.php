<?php

namespace Database\Factories;

use App\Models\UserArgumentView;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class UserArgumentViewFactory extends Factory
{
    protected $model = UserArgumentView::class;

    public function definition(): array
    {
        return [
            'user_id' => $this->faker->word(),
            'argument_id' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
