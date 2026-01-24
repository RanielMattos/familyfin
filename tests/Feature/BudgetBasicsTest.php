<?php

namespace Tests\Feature;

use App\Models\BudgetEntry;
use App\Models\BudgetLine;
use App\Models\FamilyMember;
use App\Models\Scenario;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BudgetBasicsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_store_12_months_of_budget_entries_and_sum(): void
    {
        $user = User::factory()->create();

        $scenario = Scenario::factory()->create();
        // garante coerência família/usuário (núcleo multi-tenant)
        FamilyMember::factory()->owner()->create([
            'family_id' => $scenario->family_id,
            'user_id' => $user->id,
        ]);

        $line = BudgetLine::factory()->income()->create([
            'family_id' => $scenario->family_id,
            'scenario_id' => $scenario->id,
            'slug' => 'salario',
            'name' => 'Salário',
        ]);

        $base = '2025-01-01';

        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $competence = date('Y-m-01', strtotime($base . " +{$i} months"));
            $amount = 100_000; // R$ 1.000,00

            BudgetEntry::create([
                'budget_line_id' => $line->id,
                'competence' => $competence,
                'amount_cents' => $amount,
            ]);

            $sum += $amount;
        }

        $this->assertCount(12, $line->entries()->get());
        $this->assertEquals($sum, $line->entries()->sum('amount_cents'));
    }

    public function test_budget_entry_competence_is_unique_per_line(): void
    {
        $scenario = Scenario::factory()->create();
        $line = BudgetLine::factory()->create([
            'family_id' => $scenario->family_id,
            'scenario_id' => $scenario->id,
            'slug' => 'internet',
            'name' => 'Internet',
        ]);

        BudgetEntry::create([
            'budget_line_id' => $line->id,
            'competence' => '2025-01-01',
            'amount_cents' => 10_000,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        // mesma competência na mesma linha => deve estourar UNIQUE
        BudgetEntry::create([
            'budget_line_id' => $line->id,
            'competence' => '2025-01-01',
            'amount_cents' => 20_000,
        ]);
    }
}
