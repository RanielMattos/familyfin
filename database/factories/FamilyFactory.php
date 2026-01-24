<?php

namespace Database\Factories;

use App\Models\Family;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Family>
 */
class FamilyFactory extends Factory
{
    protected $model = Family::class;

    public function definition(): array
    {
        return [
            'name' => 'Família ' . $this->faker->lastName(),
            'created_by_user_id' => User::factory(),
            'currency' => 'BRL',
            'timezone' => 'America/Bahia',
        ];
    }
}
