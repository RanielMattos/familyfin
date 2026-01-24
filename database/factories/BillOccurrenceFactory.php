<?php

namespace Database\Factories;

use App\Models\Bill;
use App\Models\BillOccurrence;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BillOccurrence>
 */
class BillOccurrenceFactory extends Factory
{
    protected $model = BillOccurrence::class;

    public function definition(): array
    {
        $due = now()->addDays($this->faker->numberBetween(1, 20))->toDateString();
        $competence = now()->startOfMonth()->toDateString();

        return [
            'bill_id' => Bill::factory(),
            'competence' => $competence,
            'due_date' => $due,
            'installment_number' => null,
            'planned_amount_cents' => $this->faker->numberBetween(1_000, 500_000),
            'paid_amount_cents' => 0,
            'status' => BillOccurrence::STATUS_OPEN,
            'paid_at' => null,
            'external_ref' => null,
            'notes' => null,
        ];
    }

    public function paid(int $paidCents = 10_000): self
    {
        return $this->state(fn () => [
            'status' => BillOccurrence::STATUS_PAID,
            'paid_amount_cents' => $paidCents,
            'paid_at' => now()->toDateString(),
        ]);
    }
}
