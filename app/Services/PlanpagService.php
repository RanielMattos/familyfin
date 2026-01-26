<?php

namespace App\Services;

use App\Models\BillOccurrence;
use App\Models\Family;
use Illuminate\Support\Collection;

class PlanpagService
{
    /**
     * Lista ocorrências por vencimento no range.
     * Se $family for informado, filtra por bills.family_id.
     *
     * @return Collection<int, BillOccurrence>
     */
    public function listByDueDateRange(string $from, string $to, ?Family $family = null): Collection
    {
        $q = BillOccurrence::query()
            ->with(['bill:id,family_id,direction,name,slug'])
            ->whereBetween('due_date', [$from, $to]);

        if ($family) {
            $q->whereHas('bill', fn ($b) => $b->where('family_id', $family->id));
        }

        return $q->orderBy('due_date')
            ->orderBy('status')
            ->get();
    }
}
