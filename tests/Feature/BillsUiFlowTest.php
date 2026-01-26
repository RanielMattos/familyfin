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
        $this->get(route('family.bills.create', ['family' => $family]))
            ->assertOk()
            ->assertSee('Nova Conta');

        // cria conta
        $payload = [
            'name'      => 'Internet',
            'direction' => 'PAYABLE',
        ];

        $this->post(route('family.bills.store', ['family' => $family]), $payload)
            ->assertRedirect(route('family.bills.index', ['family' => $family]));

        // confirma sucesso e presença na listagem
        $this->get(route('family.bills.index', ['family' => $family]))
            ->assertOk()
            ->assertSee('Conta criada com sucesso.')
            ->assertSee('Internet');

        $this->assertDatabaseHas('bills', [
            'family_id' => $family->id,
            'name'      => 'Internet',
            'direction' => 'PAYABLE',
        ]);

        $bill = Bill::query()
            ->where('family_id', $family->id)
            ->where('name', 'Internet')
            ->first();

        $this->assertNotNull($bill);
        $this->assertNotEmpty($bill->slug);
    }

    public function test_member_can_edit_and_delete_bill(): void
    {
        $user = User::factory()->create();

        $family = Family::factory()->create([
            'created_by_user_id' => $user->id,
        ]);

        FamilyMember::factory()->owner()->create([
            'family_id' => $family->id,
            'user_id'   => $user->id,
        ]);

        $this->actingAs($user);

        // cria uma conta via fluxo real (não depende de factory de Bill)
        $this->post(route('family.bills.store', ['family' => $family]), [
            'name'      => 'Internet',
            'direction' => 'PAYABLE',
        ])->assertRedirect(route('family.bills.index', ['family' => $family]));

        $bill = Bill::query()
            ->where('family_id', $family->id)
            ->where('name', 'Internet')
            ->firstOrFail();

        // abre edit
        $this->get(route('family.bills.edit', ['family' => $family, 'bill' => $bill]))
            ->assertOk()
            ->assertSee('Editar Conta');

        // atualiza
        $this->put(route('family.bills.update', ['family' => $family, 'bill' => $bill]), [
            'name'      => 'Internet 2',
            'direction' => 'RECEIVABLE',
        ])->assertRedirect(route('family.bills.index', ['family' => $family]));

        $this->get(route('family.bills.index', ['family' => $family]))
            ->assertOk()
            ->assertSee('Conta atualizada com sucesso.')
            ->assertSee('Internet 2');

        $this->assertDatabaseHas('bills', [
            'id'        => $bill->id,
            'family_id' => $family->id,
            'name'      => 'Internet 2',
            'direction' => 'RECEIVABLE',
        ]);

        // exclui
        $this->delete(route('family.bills.destroy', ['family' => $family, 'bill' => $bill]))
            ->assertRedirect(route('family.bills.index', ['family' => $family]));

        $this->get(route('family.bills.index', ['family' => $family]))
            ->assertOk()
            ->assertSee('Conta removida com sucesso.');

        $this->assertDatabaseMissing('bills', [
            'id' => $bill->id,
        ]);
    }

    public function test_member_can_toggle_bill_active_status(): void
    {
        $user = User::factory()->create();

        $family = Family::factory()->create([
            'created_by_user_id' => $user->id,
        ]);

        FamilyMember::factory()->owner()->create([
            'family_id' => $family->id,
            'user_id'   => $user->id,
        ]);

        $this->actingAs($user);

        // cria conta via fluxo real
        $this->post(route('family.bills.store', ['family' => $family]), [
            'name'      => 'Internet',
            'direction' => 'PAYABLE',
        ])->assertRedirect(route('family.bills.index', ['family' => $family]));

        $bill = Bill::query()
            ->where('family_id', $family->id)
            ->where('name', 'Internet')
            ->firstOrFail();

        // default do banco: is_active=true
        $this->assertTrue((bool) $bill->is_active);

        // inativa
        $this->post(route('family.bills.toggleActive', ['family' => $family, 'bill' => $bill]))
            ->assertRedirect(route('family.bills.index', ['family' => $family]));

        $this->get(route('family.bills.index', ['family' => $family]))
            ->assertOk()
            ->assertSee('Conta inativada com sucesso.');

        $bill->refresh();
        $this->assertFalse((bool) $bill->is_active);

        // ativa novamente
        $this->post(route('family.bills.toggleActive', ['family' => $family, 'bill' => $bill]))
            ->assertRedirect(route('family.bills.index', ['family' => $family]));

        $this->get(route('family.bills.index', ['family' => $family]))
            ->assertOk()
            ->assertSee('Conta ativada com sucesso.');

        $bill->refresh();
        $this->assertTrue((bool) $bill->is_active);
    }
}
