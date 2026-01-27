<?php

namespace Tests\Feature;

use App\Models\Bill;
use App\Models\BillOccurrence;
use App\Models\FamilyMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class PlanpagUiPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_family_planpag_page_renders_html_and_lists_occurrences_in_range(): void
    {
        $user = User::factory()->create();

        $bill = Bill::factory()->payable()->create([
            'name' => 'Internet',
            'slug' => 'internet',
            'created_by_user_id' => $user->id,
        ]);

        FamilyMember::factory()->owner()->create([
            'family_id' => $bill->family_id,
            'user_id' => $user->id,
        ]);

        BillOccurrence::create([
            'bill_id' => $bill->id,
            'competence' => '2026-01-01',
            'due_date' => '2026-01-10',
            'planned_amount_cents' => 12990,
            'paid_amount_cents' => 0,
            'status' => BillOccurrence::STATUS_OPEN,
        ]);

        BillOccurrence::create([
            'bill_id' => $bill->id,
            'competence' => '2026-02-01',
            'due_date' => '2026-02-10',
            'planned_amount_cents' => 12990,
            'paid_amount_cents' => 0,
            'status' => BillOccurrence::STATUS_OPEN,
        ]);

        BillOccurrence::create([
            'bill_id' => $bill->id,
            'competence' => '2026-03-01',
            'due_date' => '2026-03-10',
            'planned_amount_cents' => 12990,
            'paid_amount_cents' => 0,
            'status' => BillOccurrence::STATUS_OPEN,
        ]);

        $url = route('family.planpag', [
            'family' => $bill->family_id,
            'from' => '2026-01-01',
            'to' => '2026-02-28',
        ], false);

        $this->actingAs($user)
            ->get($url)
            ->assertOk()
            // UI: precisa ter form de filtro (pra diferenciar de JSON)
            ->assertSee('name="from"', false)
            ->assertSee('name="to"', false)
            // Dados
            ->assertSee('Internet')
            ->assertSee('2026-01-10')
            ->assertSee('2026-02-10')
            ->assertDontSee('2026-03-10');
    }

    public function test_planpag_page_shows_toggle_actions_based_on_status(): void
    {
        $user = User::factory()->create();

        $bill = Bill::factory()->payable()->create([
            'name' => 'Internet',
            'slug' => 'internet',
            'created_by_user_id' => $user->id,
        ]);

        FamilyMember::factory()->owner()->create([
            'family_id' => $bill->family_id,
            'user_id' => $user->id,
        ]);

        $open = BillOccurrence::create([
            'bill_id' => $bill->id,
            'competence' => '2026-02-01',
            'due_date' => '2026-02-10',
            'planned_amount_cents' => 12990,
            'paid_amount_cents' => 0,
            'status' => BillOccurrence::STATUS_OPEN,
        ]);

        $paid = BillOccurrence::create([
            'bill_id' => $bill->id,
            'competence' => '2026-02-01',
            'due_date' => '2026-02-11',
            'planned_amount_cents' => 12990,
            'paid_amount_cents' => 12990,
            'status' => BillOccurrence::STATUS_PAID,
            'paid_at' => '2026-02-11',
        ]);

        $canceled = BillOccurrence::create([
            'bill_id' => $bill->id,
            'competence' => '2026-02-01',
            'due_date' => '2026-02-12',
            'planned_amount_cents' => 12990,
            'paid_amount_cents' => 0,
            'status' => 'CANCELED',
        ]);

        $url = route('family.planpag', [
            'family' => $bill->family_id,
            'from' => '2026-02-01',
            'to' => '2026-02-28',
        ], false);

        $familyId = (string) $bill->family_id;

        $openMarkPath = "/f/{$familyId}/planpag/{$open->id}/mark-paid";
        $openUnmarkPath = "/f/{$familyId}/planpag/{$open->id}/unmark-paid";

        $paidMarkPath = "/f/{$familyId}/planpag/{$paid->id}/mark-paid";
        $paidUnmarkPath = "/f/{$familyId}/planpag/{$paid->id}/unmark-paid";

        $canceledMarkPath = "/f/{$familyId}/planpag/{$canceled->id}/mark-paid";
        $canceledUnmarkPath = "/f/{$familyId}/planpag/{$canceled->id}/unmark-paid";

        $this->actingAs($user)
            ->get($url)
            ->assertOk()
            // OPEN: tem mark-paid, não tem unmark-paid
            ->assertSee($openMarkPath, false)
            ->assertDontSee($openUnmarkPath, false)
            // PAID: tem unmark-paid, não tem mark-paid
            ->assertSee($paidUnmarkPath, false)
            ->assertDontSee($paidMarkPath, false)
            // CANCELED: não tem ações
            ->assertDontSee($canceledMarkPath, false)
            ->assertDontSee($canceledUnmarkPath, false)
            // sanity: textos existem na UI
            ->assertSee('Marcar como pago')
            ->assertSee('Desfazer');
    }

    public function test_member_can_mark_occurrence_as_paid_and_defaults_paid_amount_to_planned(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-02-15'));

        $user = User::factory()->create();

        $bill = Bill::factory()->payable()->create([
            'name' => 'Internet',
            'slug' => 'internet',
            'created_by_user_id' => $user->id,
        ]);

        FamilyMember::factory()->owner()->create([
            'family_id' => $bill->family_id,
            'user_id' => $user->id,
        ]);

        $occurrence = BillOccurrence::create([
            'bill_id' => $bill->id,
            'competence' => '2026-02-01',
            'due_date' => '2026-02-10',
            'planned_amount_cents' => 12990,
            'paid_amount_cents' => 0,
            'status' => BillOccurrence::STATUS_OPEN,
        ]);

        $planpagUrl = route('family.planpag', [
            'family' => $bill->family_id,
            'from' => '2026-02-01',
            'to' => '2026-02-28',
        ], false);

        $markPaidUrl = route('family.planpag.markPaid', [
            'family' => $bill->family_id,
            'occurrence' => $occurrence->id,
        ], false);

        // Sem enviar paid_amount_cents: deve assumir planned_amount_cents (idempotente)
        $this->actingAs($user)
            ->from($planpagUrl)
            ->post($markPaidUrl, [])
            ->assertRedirect($planpagUrl)
            ->assertSessionHas('success', 'Pagamento registrado com sucesso.');

        $occurrence->refresh();

        $this->assertSame(BillOccurrence::STATUS_PAID, $occurrence->status);
        $this->assertSame(12990, (int) $occurrence->paid_amount_cents);
        $this->assertNotNull($occurrence->paid_at);
        $this->assertSame('2026-02-15', $occurrence->paid_at->toDateString());
    }

    public function test_cannot_mark_paid_for_occurrence_from_another_family(): void
    {
        $user = User::factory()->create();

        // Family A (usuário é membro)
        $billA = Bill::factory()->payable()->create([
            'name' => 'Internet A',
            'slug' => 'internet-a',
            'created_by_user_id' => $user->id,
        ]);

        FamilyMember::factory()->owner()->create([
            'family_id' => $billA->family_id,
            'user_id' => $user->id,
        ]);

        // Family B (ocorrência pertence a outra família)
        $billB = Bill::factory()->payable()->create([
            'name' => 'Internet B',
            'slug' => 'internet-b',
            'created_by_user_id' => $user->id,
        ]);

        $occurrenceB = BillOccurrence::create([
            'bill_id' => $billB->id,
            'competence' => '2026-02-01',
            'due_date' => '2026-02-10',
            'planned_amount_cents' => 12990,
            'paid_amount_cents' => 0,
            'status' => BillOccurrence::STATUS_OPEN,
        ]);

        // Tentando pagar ocorrência de B usando rota da família A -> deve 404 (segurança)
        $markPaidUrl = route('family.planpag.markPaid', [
            'family' => $billA->family_id,
            'occurrence' => $occurrenceB->id,
        ], false);

        $this->actingAs($user)
            ->post($markPaidUrl, [])
            ->assertNotFound();

        $occurrenceB->refresh();
        $this->assertSame(BillOccurrence::STATUS_OPEN, $occurrenceB->status);
        $this->assertSame(0, (int) $occurrenceB->paid_amount_cents);
        $this->assertNull($occurrenceB->paid_at);
    }
}
