<?php

namespace Database\Factories;

use App\Models\UserMail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class UserMailFactory extends Factory
{
    protected $model = UserMail::class;

    public function definition(): array
    {
        return [
            'user_id' => $this->faker->word(),
            'mail_type' => $this->faker->word(),
            'subject' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
