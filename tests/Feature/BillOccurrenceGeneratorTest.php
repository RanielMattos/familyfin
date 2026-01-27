<?php

namespace Tests\Feature;

use App\Models\Bill;
use App\Models\BillOccurrence;
use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\User;
use App\Services\BillOccurrenceGenerator;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BillOccurrenceGeneratorTest extends TestCase
{
    use RefreshDatabase;

    public function test_generates_monthly_occurrences_idempotently_and_respects_day_of_month(): void
    {
        $user = User::factory()->create();
        $family = Family::factory()->create(['created_by_user_id' => $user->id]);

        FamilyMember::factory()->owner()->create([
            'family_id' => $family->id,
            'user_id'   => $user->id,
        ]);

        $bill = Bill::factory()->create([
            'family_id' => $family->id,
            'created_by_user_id' => $user->id,
            'name' => 'Aluguel',
            'direction' => Bill::DIR_PAYABLE,
            'slug' => 'aluguel',
            'recurrence' => Bill::REC_MONTHLY,
            'day_of_month' => 31,
            'default_amount_cents' => 250000,
            'is_active' => true,
        ]);

        $svc = new BillOccurrenceGenerator();

        $from = CarbonImmutable::parse('2026-01-01');
        $to   = CarbonImmutable::parse('2026-03-31');

        $created1 = $svc->generateForRange($from, $to, $family);
        $this->assertSame(3, $created1);

        // fevereiro deve respeitar último dia do mês (28 em 2026)
        $occFeb = BillOccurrence::query()
            ->where('bill_id', $bill->id)
            ->whereDate('due_date', '2026-02-28')
            ->first();

        $this->assertNotNull($occFeb);
        $this->assertSame('2026-02-28', $occFeb->due_date?->toDateString());
        $this->assertSame(BillOccurrence::STATUS_OPEN, $occFeb->status);
        $this->assertSame(250000, (int) $occFeb->planned_amount_cents);
        $this->assertSame(0, (int) $occFeb->paid_amount_cents);
        $this->assertSame('2026-02-01', $occFeb->competence?->toDateString());

        // rodar de novo não pode duplicar
        $created2 = $svc->generateForRange($from, $to, $family);
        $this->assertSame(0, $created2);

        $this->assertSame(3, BillOccurrence::query()->where('bill_id', $bill->id)->count());
    }

    public function test_does_not_generate_for_inactive_bill(): void
    {
        $user = User::factory()->create();
        $family = Family::factory()->create(['created_by_user_id' => $user->id]);

        FamilyMember::factory()->owner()->create([
            'family_id' => $family->id,
            'user_id'   => $user->id,
        ]);

        $bill = Bill::factory()->create([
            'family_id' => $family->id,
            'created_by_user_id' => $user->id,
            'name' => 'Internet',
            'direction' => Bill::DIR_PAYABLE,
            'slug' => 'internet',
            'recurrence' => Bill::REC_MONTHLY,
            'day_of_month' => 10,
            'default_amount_cents' => 10000,
            'is_active' => false,
        ]);

        $svc = new BillOccurrenceGenerator();

        $created = $svc->generateForRange(
            CarbonImmutable::parse('2026-01-01'),
            CarbonImmutable::parse('2026-01-31'),
            $family
        );

        $this->assertSame(0, $created);
        $this->assertSame(0, BillOccurrence::query()->where('bill_id', $bill->id)->count());
    }
}
