<?php

namespace Database\Factories;

use App\Models\Family;
use App\Models\Income;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Income>
 */
class IncomeFactory extends Factory
{
    protected $model = Income::class;

    public function definition(): array
    {
        return [
            'family_id' => Family::factory(),
            'description' => $this->faker->sentence(3),
            'amount' => $this->faker->randomFloat(2, 500, 10000),
            'received_at' => $this->faker->dateTimeBetween('-2 months', 'now')->format('Y-m-d'),
        ];
    }
}
