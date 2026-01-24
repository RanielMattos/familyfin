<?php

namespace Database\Factories;

use App\Models\BudgetLine;
use App\Models\Family;
use App\Models\Scenario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<BudgetLine>
 */
class BudgetLineFactory extends Factory
{
    protected $model = BudgetLine::class;

    public function definition(): array
    {
        $name = $this->faker->randomElement(['Salário', 'Aluguel', 'Internet', 'Mercado', 'Combustível']);

        return [
            'family_id' => Family::factory(),
            'scenario_id' => Scenario::factory(),
            'direction' => $this->faker->randomElement([BudgetLine::DIR_INCOME, BudgetLine::DIR_EXPENSE]),
            'group_node_id' => null,
            'category_node_id' => null,
            'subcategory_node_id' => null,
            'name' => $name,
            'nature' => BudgetLine::NATURE_FIXED,
            'visibility' => BudgetLine::VIS_FAMILY,
            'is_active' => true,
            'slug' => Str::of($name)->lower()->ascii()->replace(' ', '-')->toString(),
            'sort_order' => 10,
        ];
    }

    public function income(): self
    {
        return $this->state(fn () => ['direction' => BudgetLine::DIR_INCOME]);
    }

    public function expense(): self
    {
        return $this->state(fn () => ['direction' => BudgetLine::DIR_EXPENSE]);
    }
}
