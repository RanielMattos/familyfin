<?php

namespace Tests\Feature;

use App\Models\Bill;
use App\Models\BillOccurrence;
use App\Models\FamilyMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BillPaymentFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_mark_occurrence_as_paid_and_store_paid_fields(): void
    {
        $user = User::factory()->create();

        $bill = Bill::factory()->payable()->create([
            'created_by_user_id' => $user->id,
        ]);

        FamilyMember::factory()->owner()->create([
            'family_id' => $bill->family_id,
            'user_id' => $user->id,
        ]);

        $occ = BillOccurrence::factory()->create([
            'bill_id' => $bill->id,
            'competence' => '2026-01-01',
            'due_date' => '2026-01-10',
            'planned_amount_cents' => 12990,
            'status' => BillOccurrence::STATUS_OPEN,
            'paid_amount_cents' => 0,
            'paid_at' => null,
        ]);

        // "pagar"
        $occ->update([
            'status' => BillOccurrence::STATUS_PAID,
            'paid_amount_cents' => 12990,
            'paid_at' => '2026-01-09',
        ]);

        $fresh = $occ->fresh();

        $this->assertEquals(BillOccurrence::STATUS_PAID, $fresh->status);
        $this->assertEquals(12990, $fresh->paid_amount_cents);
        $this->assertEquals('2026-01-09', $fresh->paid_at?->toDateString());
    }
}
