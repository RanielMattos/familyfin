<?php

namespace Tests\Feature;

use App\Models\Bill;
use App\Models\BillOccurrence;
use App\Models\FamilyMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanpagEndpointTest extends TestCase
{
    use RefreshDatabase;

    public function test_planpag_endpoint_filters_by_due_date_range(): void
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

        // 3 ocorrências: 2 no range, 1 fora
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

        $res = $this->get('/planpag?from=2026-01-01&to=2026-02-28')
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'status',
                        'due_date',
                        'competence',
                        'planned_amount_cents',
                        'paid_amount_cents',
                        'paid_at',
                        'bill' => ['id', 'direction', 'name', 'slug'],
                    ],
                ],
            ]);

        $data = $res->json('data');

        $this->assertCount(2, $data);
        $this->assertEquals('2026-01-10', $data[0]['due_date']);
        $this->assertEquals('2026-02-10', $data[1]['due_date']);
        $this->assertEquals('Internet', $data[0]['bill']['name']);
    }

    public function test_planpag_requires_from_and_to(): void
    {
        $this->get('/planpag')
            ->assertStatus(302); // web middleware => redirect on validation error
    }
}
