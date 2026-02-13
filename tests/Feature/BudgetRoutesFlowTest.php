<?php

namespace Tests\Feature;

use App\Models\BudgetEntry;
use App\Models\BudgetLine;
use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\Scenario;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BudgetRoutesFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_can_create_scenario_line_and_entry_upsert(): void
    {
        $user = User::factory()->create();
        $family = Family::factory()->create();

        FamilyMember::factory()->owner()->create([
            'family_id' => $family->id,
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $rScenario = $this->post(route('family.scenarios.store', $family), [
            'name' => 'Base 2025',
            'start_date' => '2025-01-01',
            'end_date' => '2025-12-31',
        ]);

        $rScenario->assertStatus(201);

        $scenarioId = $rScenario->json('data.id');
        $scenario = Scenario::findOrFail($scenarioId);

        $rLine = $this->post(route('family.budget.lines.store', [$family, $scenario]), [
            'direction' => BudgetLine::DIR_INCOME,
            'name' => 'Salário',
            'nature' => BudgetLine::NATURE_FIXED,
            'visibility' => BudgetLine::VIS_FAMILY,
        ]);

        $rLine->assertStatus(201);

        $lineId = $rLine->json('data.id');
        $line = BudgetLine::findOrFail($lineId);

        // cria entry (normaliza competência para YYYY-MM-01)
        $this->post(route('family.budget.entries.store', [$family, $scenario, $line]), [
            'competence' => '2025-01-15',
            'amount_cents' => 100_000,
        ])->assertOk();

        $this->assertDatabaseHas('budget_entries', [
            'budget_line_id' => $line->id,
            'competence' => '2025-01-01',
            'amount_cents' => 100_000,
        ]);

        // upsert mesma competência -> atualiza
        $this->post(route('family.budget.entries.store', [$family, $scenario, $line]), [
            'competence' => '2025-01-01',
            'amount_cents' => 200_000,
        ])->assertOk();

        $this->assertDatabaseHas('budget_entries', [
            'budget_line_id' => $line->id,
            'competence' => '2025-01-01',
            'amount_cents' => 200_000,
        ]);
    }

    public function test_non_member_gets_403_on_family_budget_routes(): void
    {
        $user = User::factory()->create();
        $family = Family::factory()->create();

        $this->actingAs($user);

        $this->get(route('family.scenarios.index', $family))
            ->assertForbidden();
    }

    public function test_scope_bindings_blocks_cross_family_access(): void
    {
        $user = User::factory()->create();

        $familyA = Family::factory()->create();
        $familyB = Family::factory()->create();

        FamilyMember::factory()->owner()->create(['family_id' => $familyA->id, 'user_id' => $user->id]);
        FamilyMember::factory()->owner()->create(['family_id' => $familyB->id, 'user_id' => $user->id]);

        $scenarioB = Scenario::factory()->create(['family_id' => $familyB->id]);
        $lineB = BudgetLine::factory()->expense()->create([
            'family_id' => $familyB->id,
            'scenario_id' => $scenarioB->id,
        ]);
        $entryB = BudgetEntry::factory()->create([
            'budget_line_id' => $lineB->id,
            'competence' => '2025-01-01',
            'amount_cents' => 123,
        ]);

        $this->actingAs($user);

        // tenta acessar scenarioB via familyA => 404 (scoped binding)
        $this->put(route('family.scenarios.update', [$familyA, $scenarioB]), ['name' => 'X'])
            ->assertNotFound();

        $this->delete(route('family.budget.lines.destroy', [$familyA, $scenarioB, $lineB]))
            ->assertNotFound();

        $this->delete(route('family.budget.entries.destroy', [$familyA, $scenarioB, $lineB, $entryB]))
            ->assertNotFound();
    }
}
