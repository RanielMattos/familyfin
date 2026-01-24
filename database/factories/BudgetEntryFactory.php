<?php

namespace Database\Factories;

use App\Models\BudgetEntry;
use App\Models\BudgetLine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BudgetEntry>
 */
class BudgetEntryFactory extends Factory
{
    protected $model = BudgetEntry::class;

    public function definition(): array
    {
        return [
            'budget_line_id' => BudgetLine::factory(),
            'competence' => now()->startOfMonth()->toDateString(),
            'amount_cents' => $this->faker->numberBetween(0, 2_000_000),
        ];
    }
}
