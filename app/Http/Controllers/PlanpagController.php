<?php

namespace App\Http\Controllers;

use App\Models\BillOccurrence;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlanpagController extends Controller
{
    /**
     * GET /planpag?from=YYYY-MM-DD&to=YYYY-MM-DD
     * Retorna ocorrências por vencimento (due_date) no intervalo informado.
     *
     * Payload:
     * {
     *   data: [
     *     {
     *       id, status, due_date, competence,
     *       planned_amount_cents, paid_amount_cents, paid_at,
     *       bill: { id, direction, name, slug }
     *     }
     *   ]
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'from' => ['required', 'date'],
            'to'   => ['required', 'date', 'after_or_equal:from'],
        ]);

        $from = $validated['from'];
        $to   = $validated['to'];

        $items = BillOccurrence::query()
            ->with(['bill:id,family_id,direction,name,slug'])
            ->whereBetween('due_date', [$from, $to])
            ->orderBy('due_date')
            ->orderBy('status')
            ->get();

        $payload = $items->map(function (BillOccurrence $o) {
            return [
                'id' => $o->id,
                'status' => $o->status,
                'due_date' => $o->due_date?->toDateString(),
                'competence' => $o->competence?->toDateString(),
                'planned_amount_cents' => $o->planned_amount_cents,
                'paid_amount_cents' => $o->paid_amount_cents,
                'paid_at' => $o->paid_at?->toDateString(),
                'bill' => [
                    'id' => $o->bill->id,
                    'direction' => $o->bill->direction,
                    'name' => $o->bill->name,
                    'slug' => $o->bill->slug,
                ],
            ];
        })->values();

        return response()->json(['data' => $payload]);
    }
}
