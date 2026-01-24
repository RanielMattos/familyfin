<?php

namespace Database\Factories;

use App\Models\Bill;
use App\Models\Family;
use App\Models\Scenario;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Bill>
 */
class BillFactory extends Factory
{
    protected $model = Bill::class;

    public function definition(): array
    {
        $name = $this->faker->randomElement(['Aluguel', 'Internet', 'Cartão', 'Escola', 'Energia', 'Água']);
        $slug = Str::of($name)->lower()->ascii()->replace(' ', '-')->toString();

        return [
            'family_id' => Family::factory(),
            'scenario_id' => null, // opcional na fase 0
            'direction' => $this->faker->randomElement([Bill::DIR_PAYABLE, Bill::DIR_RECEIVABLE]),
            'group_node_id' => null,
            'category_node_id' => null,
            'subcategory_node_id' => null,
            'name' => $name,
            'slug' => $slug,
            'recurrence' => Bill::REC_MONTHLY,
            'day_of_month' => $this->faker->numberBetween(1, 28),
            'interval_days' => null,
            'total_installments' => null,
            'default_amount_cents' => $this->faker->numberBetween(5_00, 5_000_00), // 5 a 5000 reais approx
            'is_active' => true,
            'sort_order' => 10,
            'notes' => null,
            'created_by_user_id' => User::factory(),
        ];
    }

    public function payable(): self
    {
        return $this->state(fn () => ['direction' => Bill::DIR_PAYABLE]);
    }

    public function receivable(): self
    {
        return $this->state(fn () => ['direction' => Bill::DIR_RECEIVABLE]);
    }

    public function scenarioBound(): self
    {
        return $this->state(fn () => ['scenario_id' => Scenario::factory()]);
    }
}
