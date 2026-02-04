<?php

namespace Tests\Feature;

use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\Income;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IncomeFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_family_member_can_create_income(): void
    {
        $family = Family::factory()->create();
        $user = User::factory()->create();

        // ✅ O QUE REALMENTE LIBERA O EnsureFamilyAccess:
        FamilyMember::factory()->owner()->create([
            'family_id' => $family->id,
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $response = $this->post("/f/{$family->id}/incomes", [
            'description' => 'Salário Mensal',
            'amount' => 3500.75,
            'received_at' => now()->toDateString(),
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('incomes', [
            'description' => 'Salário Mensal',
            'amount' => 3500.75,
            'family_id' => $family->id,
        ]);
    }

    public function test_income_is_not_visible_to_other_families(): void
    {
        $familyA = Family::factory()->create();
        $familyB = Family::factory()->create();

        $userA = User::factory()->create();
        $userB = User::factory()->create();

        // ✅ Vincula membros corretamente nas famílias
        FamilyMember::factory()->owner()->create([
            'family_id' => $familyA->id,
            'user_id' => $userA->id,
        ]);

        FamilyMember::factory()->owner()->create([
            'family_id' => $familyB->id,
            'user_id' => $userB->id,
        ]);

        Income::factory()->create([
            'family_id' => $familyA->id,
            'description' => 'Receita Oculta',
        ]);

        $this->actingAs($userB);

        $response = $this->get("/f/{$familyB->id}/incomes");

        $response->assertStatus(200);
        $response->assertDontSee('Receita Oculta');
    }
}
