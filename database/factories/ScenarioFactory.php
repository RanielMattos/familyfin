<?php

namespace Database\Factories;

use App\Models\Family;
use App\Models\Scenario;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Scenario>
 */
class ScenarioFactory extends Factory
{
    protected $model = Scenario::class;

    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('-1 years', 'now')->format('Y-01-01');

        return [
            'family_id' => Family::factory(),
            'name' => 'Base ' . $this->faker->year(),
            'start_date' => $start,
            'end_date' => date('Y-m-d', strtotime($start . ' + 1 year - 1 day')),
            'status' => Scenario::STATUS_DRAFT,
            'cloned_from_scenario_id' => null,
            'created_by_user_id' => User::factory(),
        ];
    }
}
