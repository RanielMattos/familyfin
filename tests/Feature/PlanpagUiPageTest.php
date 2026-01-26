<?php

namespace Tests\Feature;

use App\Models\Bill;
use App\Models\BillOccurrence;
use App\Models\FamilyMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
