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
        $user   = User::factory()->create();

        // Garante membership (libera EnsureFamilyAccess)
        FamilyMember::factory()->owner()->create([
            'family_id' => $family->id,
            'user_id'   => $user->id,
            'is_active' => true,
            'joined_at' => now(),
        ]);

        $this->actingAs($user);

        $response = $this->post(route('incomes.store', ['family' => $family->id]), [
            'description' => 'Salário Mensal',
            'amount'      => 3500.75,
            'received_at' => now()->toDateString(),
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('incomes', [
            'family_id'    => $family->id,
            'description'  => 'Salário Mensal',
            'amount'       => 3500.75,
        ]);
    }

    public function test_income_is_not_visible_to_other_families(): void
    {
        $familyA = Family::factory()->create();
        $familyB = Family::factory()->create();

        $userA = User::factory()->create();
        $userB = User::factory()->create();

        FamilyMember::factory()->owner()->create([
            'family_id' => $familyA->id,
            'user_id'   => $userA->id,
            'is_active' => true,
            'joined_at' => now(),
        ]);

        FamilyMember::factory()->owner()->create([
            'family_id' => $familyB->id,
            'user_id'   => $userB->id,
            'is_active' => true,
            'joined_at' => now(),
        ]);

        Income::factory()->create([
            'family_id'    => $familyA->id,
            'description'  => 'Receita Oculta',
            'amount'       => 123.45,
            'received_at'  => now()->toDateString(),
        ]);

        $this->actingAs($userB);

        $response = $this->get(route('incomes.index', ['family' => $familyB->id]));

        $response->assertOk();
        $response->assertDontSee('Receita Oculta');
    }

    public function test_member_of_two_families_cannot_update_or_delete_income_through_wrong_family_route(): void
    {
        $user = User::factory()->create();

        $familyA = Family::factory()->create();
        $familyB = Family::factory()->create();

        // ✅ NUNCA use attach() aqui (pivô tem ULID). Crie via model/factory.
        FamilyMember::factory()->owner()->create([
            'family_id' => $familyA->id,
            'user_id'   => $user->id,
            'is_active' => true,
            'joined_at' => now(),
        ]);

        FamilyMember::factory()->owner()->create([
            'family_id' => $familyB->id,
            'user_id'   => $user->id,
            'is_active' => false,
            'joined_at' => now(),
        ]);

        $income = Income::factory()->create([
            'family_id'    => $familyA->id,
            'description'  => 'A-only',
            'amount'       => 123.45,
            'received_at'  => now()->toDateString(),
        ]);

        $this->actingAs($user);

        // ✅ Com scopeBindings, tentar acessar income(A) pela rota da family(B) dá 404.
        $this->put(route('incomes.update', ['family' => $familyB->id, 'income' => $income->id]), [
            'description' => 'hacked',
            'amount'      => 999.99,
            'received_at' => now()->toDateString(),
        ])->assertNotFound();

        $this->delete(route('incomes.destroy', ['family' => $familyB->id, 'income' => $income->id]))
            ->assertNotFound();

        // ✅ Confirma que não alterou nem deletou
        $this->assertDatabaseHas('incomes', [
            'id'          => $income->id,
            'family_id'   => $familyA->id,
            'description' => 'A-only',
        ]);
    }
}
