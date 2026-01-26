<?php

namespace Tests\Feature;

use App\Models\Bill;
use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BillsUiFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_can_create_bill_and_is_redirected_to_index_with_success_message(): void
    {
        $user = User::factory()->create();

        $family = Family::factory()->create([
            'created_by_user_id' => $user->id,
        ]);

        // vínculo de membro/owner (isso é o que o EnsureFamilyAccess vai checar)
        FamilyMember::factory()->owner()->create([
            'family_id' => $family->id,
            'user_id'   => $user->id,
        ]);

        $this->actingAs($user);

        // abre create
        $this->get(route('family.bills.create', ['family' => $family->id]))
            ->assertOk()
            ->assertSee('Nova Conta');

        // cria conta
        $payload = [
            'name'      => 'Internet',
            'direction' => 'PAYABLE',
        ];

        $this->post(route('family.bills.store', ['family' => $family->id]), $payload)
            ->assertRedirect(route('family.bills.index', ['family' => $family->id]));

        // confirma sucesso e presença na listagem
        $this->get(route('family.bills.index', ['family' => $family->id]))
            ->assertOk()
            ->assertSee('Conta criada com sucesso.')
            ->assertSee('Internet');

        $this->assertDatabaseHas('bills', [
            'family_id'  => $family->id,
            'name'       => 'Internet',
            'direction'  => 'PAYABLE',
        ]);

        $bill = Bill::query()
            ->where('family_id', $family->id)
            ->where('name', 'Internet')
            ->first();

        $this->assertNotNull($bill);
        $this->assertNotEmpty($bill->slug);
    }
}
