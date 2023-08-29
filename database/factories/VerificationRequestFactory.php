<?php

namespace Database\Factories;

use App\Models\VerificationRequest;
use App\Models\VerificationRequestStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class VerificationRequestFactory extends Factory
{
    protected $model = VerificationRequest::class;

    public function definition(): array
    {
        return [
            'motivation' => $this->faker->word(),
            'status' => VerificationRequestStatus::PENDING,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
