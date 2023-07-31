<?php

namespace Database\Factories;

use App\Models\Vote;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class VoteFactory extends Factory
{
    protected $model = Vote::class;

    public function definition(): array
    {
        $countYes = $this->faker->numberBetween(0, 100);
        $countNo = 100 - $countYes;

        return [
            'title' => 'Interface Default Methods',
            'rfc_link' => 'https://wiki.php.net/rfc/interface-default-methods',
            'count_yes' => $countYes,
            'count_no' => $countNo,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
