<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\BillOccurrence;
use App\Models\Family;
use Carbon\CarbonImmutable;
use Illuminate\Database\QueryException;

class BillOccurrenceGenerator
{
    /**
     * Gera ocorrências (idempotente) para Bills ATIVAS em um intervalo.
     * - Não duplica: respeita unique(bill_id, due_date)
     * - planned_amount_cents vem de bills.default_amount_cents
     * - status default OPEN
     * - competence = YYYY-MM-01 (início do mês do due_date)
     */
    public function generateForRange(CarbonImmutable $from, CarbonImmutable $to, ?Family $family = null): int
    {
        $from = $from->startOfDay();
        $to = $to->endOfDay();

        $query = Bill::query()
            ->where('is_active', true);

        if ($family) {
            $query->where('family_id', $family->id);
        }

        $bills = $query->get([
            'id',
            'family_id',
            'direction',
            'name',
            'slug',
            'recurrence',
            'day_of_month',
            'interval_days',
            'total_installments',
            'default_amount_cents',
            'is_active',
            'created_at',
        ]);

        $created = 0;

        foreach ($bills as $bill) {
            $dueDates = $this->dueDatesForBillInRange($bill, $from, $to);

            if ($dueDates === []) {
                continue;
            }

            $nextInstallment = null;
            if (!is_null($bill->total_installments)) {
                $max = BillOccurrence::query()
                    ->where('bill_id', $bill->id)
                    ->max('installment_number');

                $nextInstallment = ((int) ($max ?? 0)) + 1;
            }

            foreach ($dueDates as $due) {
                // Se for parcelado e já atingiu o total, para de gerar novas
                if (!is_null($bill->total_installments) && $nextInstallment > (int) $bill->total_installments) {
                    break;
                }

                $defaults = [
                    'competence' => $due->startOfMonth()->toDateString(),
                    'planned_amount_cents' => (int) $bill->default_amount_cents,
                    'paid_amount_cents' => 0,
                    'status' => BillOccurrence::STATUS_OPEN,
                    'paid_at' => null,
                    'external_ref' => null,
                    'notes' => null,
                ];

                if (!is_null($bill->total_installments)) {
                    $defaults['installment_number'] = $nextInstallment;
                }

                try {
                    $occ = BillOccurrence::query()->firstOrCreate(
                        [
                            'bill_id' => $bill->id,
                            'due_date' => $due->toDateString(),
                        ],
                        $defaults
                    );
                } catch (QueryException $e) {
                    // Em caso de corrida, o unique(bill_id, due_date) pode estourar.
                    // Considera como já existente.
                    continue;
                }

                if ($occ->wasRecentlyCreated) {
                    $created++;

                    if (!is_null($bill->total_installments)) {
                        $nextInstallment++;
                    }
                }
            }
        }

        return $created;
    }

    /**
     * Retorna os due_dates esperados (CarbonImmutable) para um Bill no intervalo.
     */
    private function dueDatesForBillInRange(Bill $bill, CarbonImmutable $from, CarbonImmutable $to): array
    {
        $rec = (string) $bill->recurrence;

        if ($rec === Bill::REC_NONE) {
            return [];
        }

        if ($rec === Bill::REC_MONTHLY) {
            return $this->monthlyDueDates($bill, $from, $to);
        }

        if ($rec === Bill::REC_YEARLY) {
            return $this->yearlyDueDates($bill, $from, $to);
        }

        if ($rec === Bill::REC_WEEKLY) {
            return $this->intervalDueDates($bill, $from, $to, 7);
        }

        if ($rec === Bill::REC_CUSTOM) {
            $interval = (int) ($bill->interval_days ?? 0);
            if ($interval <= 0) {
                return [];
            }
            return $this->intervalDueDates($bill, $from, $to, $interval);
        }

        // default seguro
        return [];
    }

    private function monthlyDueDates(Bill $bill, CarbonImmutable $from, CarbonImmutable $to): array
    {
        $dayOfMonth = (int) ($bill->day_of_month ?? 1);
        if ($dayOfMonth <= 0) {
            $dayOfMonth = 1;
        }

        $cursor = CarbonImmutable::create($from->year, $from->month, 1)->startOfDay();
        $end = CarbonImmutable::create($to->year, $to->month, 1)->startOfDay();

        $dates = [];

        while ($cursor <= $end) {
            $lastDay = $cursor->endOfMonth()->day;
            $day = min($dayOfMonth, $lastDay);

            $due = CarbonImmutable::create($cursor->year, $cursor->month, $day)->startOfDay();

            if ($due >= $from->startOfDay() && $due <= $to->endOfDay()) {
                $dates[] = $due;
            }

            $cursor = $cursor->addMonthNoOverflow();
        }

        return $dates;
    }

    private function yearlyDueDates(Bill $bill, CarbonImmutable $from, CarbonImmutable $to): array
    {
        $createdAt = CarbonImmutable::parse($bill->created_at)->startOfDay();

        $month = (int) $createdAt->month;
        $day = (int) ($bill->day_of_month ?? $createdAt->day);
        if ($day <= 0) {
            $day = 1;
        }

        $dates = [];

        for ($year = (int) $from->year; $year <= (int) $to->year; $year++) {
            $base = CarbonImmutable::create($year, $month, 1)->startOfDay();
            $lastDay = $base->endOfMonth()->day;

            $due = CarbonImmutable::create($year, $month, min($day, $lastDay))->startOfDay();

            if ($due >= $from->startOfDay() && $due <= $to->endOfDay()) {
                $dates[] = $due;
            }
        }

        return $dates;
    }

    private function intervalDueDates(Bill $bill, CarbonImmutable $from, CarbonImmutable $to, int $intervalDays): array
    {
        if ($intervalDays <= 0) {
            return [];
        }

        $anchor = CarbonImmutable::parse($bill->created_at)->startOfDay();

        // acha o primeiro due >= from
        if ($anchor < $from->startOfDay()) {
            $diffDays = $anchor->diffInDays($from->startOfDay());
            $steps = (int) ceil($diffDays / $intervalDays);
            $anchor = $anchor->addDays($steps * $intervalDays);
        }

        $dates = [];
        $cursor = $anchor;

        while ($cursor <= $to->endOfDay()) {
            if ($cursor >= $from->startOfDay()) {
                $dates[] = $cursor;
            }
            $cursor = $cursor->addDays($intervalDays);
        }

        return $dates;
    }
}
