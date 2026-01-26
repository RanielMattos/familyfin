<?php

namespace App\Http\Controllers;

use App\Models\BillOccurrence;
use App\Models\Family;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlanpagController extends Controller
{
    /**
     * Public:  GET /planpag?from=YYYY-MM-DD&to=YYYY-MM-DD  => JSON (tests)
     * Scoped:  GET /f/{family}/planpag?from=...&to=...     => HTML (default), JSON se pedir
     */
    public function index(Request $request): JsonResponse|View
    {
        /** @var Family|null $family */
        $family = $request->attributes->get('currentFamily');

        $wantsJson = $request->expectsJson();
        $isScoped = (bool) $family;

        // Public: obrigatório (mantém PlanpagEndpointTest)
        // Scoped + HTML: permite vazio e aplica defaults (UX)
        $rules = [
            'from' => ['required', 'date'],
            'to'   => ['required', 'date', 'after_or_equal:from'],
        ];

        if ($isScoped && ! $wantsJson) {
            $rules = [
                'from' => ['nullable', 'date'],
                'to'   => ['nullable', 'date', 'after_or_equal:from'],
            ];
        }

        $validated = $request->validate($rules);

        $from = $validated['from'] ?? now()->startOfMonth()->toDateString();
        $to   = $validated['to']   ?? now()->endOfMonth()->toDateString();

        $items = BillOccurrence::query()
            ->with(['bill:id,family_id,direction,name,slug'])
            ->whereBetween('due_date', [$from, $to])
            ->when($family, function ($q) use ($family) {
                // ✅ não usa whereHas('bill') pra não cair em scopes do Model Bill
                $q->whereIn('bill_id', function ($sub) use ($family) {
                    $sub->select('id')
                        ->from('bills')
                        ->where('family_id', $family->id);
                });
            })
            ->orderBy('due_date')
            ->orderBy('status')
            ->get();

        // HTML (scoped)
        if ($family && ! $wantsJson) {
            return view('planpag.index', [
                'family' => $family,
                'from'   => $from,
                'to'     => $to,
                'items'  => $items,
            ]);
        }

        // JSON (public ou quando pedir JSON)
        $payload = $items->map(function (BillOccurrence $o) {
            return [
                'id' => $o->id,
                'status' => $o->status,
                // ✅ usa format() pra agradar o VSCode/PHPTools (sem erro de "date::toDateString")
                'due_date' => $o->due_date ? $o->due_date->format('Y-m-d') : null,
                'competence' => $o->competence ? $o->competence->format('Y-m-d') : null,
                'planned_amount_cents' => $o->planned_amount_cents,
                'paid_amount_cents' => $o->paid_amount_cents,
                'paid_at' => $o->paid_at ? $o->paid_at->format('Y-m-d') : null,
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
