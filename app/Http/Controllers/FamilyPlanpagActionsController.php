<?php

namespace App\Http\Controllers;

use App\Models\BillOccurrence;
use App\Models\Family;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FamilyPlanpagActionsController extends Controller
{
    public function markPaid(Request $request, Family $family, BillOccurrence $occurrence): RedirectResponse
    {
        $occurrence->loadMissing('bill:id,family_id');

        if (! $occurrence->bill || (string) $occurrence->bill->family_id !== (string) $family->id) {
            abort(404);
        }

        if ($occurrence->status !== BillOccurrence::STATUS_PAID) {
            $paidAmountCents = $request->integer('paid_amount_cents', (int) $occurrence->planned_amount_cents);

            if ($paidAmountCents < 0) {
                $paidAmountCents = 0;
            }

            $occurrence->status = BillOccurrence::STATUS_PAID;
            $occurrence->paid_amount_cents = $paidAmountCents;
            $occurrence->paid_at = now()->toDateString();
            $occurrence->save();
        }

        return redirect()->back()->with('success', 'Pagamento registrado com sucesso.');
    }

    public function unmarkPaid(Family $family, BillOccurrence $occurrence): RedirectResponse
    {
        $occurrence->loadMissing('bill:id,family_id');

        if (! $occurrence->bill || (string) $occurrence->bill->family_id !== (string) $family->id) {
            abort(404);
        }

        if ($occurrence->status === BillOccurrence::STATUS_PAID) {
            $occurrence->status = BillOccurrence::STATUS_OPEN;
            $occurrence->paid_amount_cents = 0;
            $occurrence->paid_at = null;
            $occurrence->save();
        }

        return redirect()->back()->with('success', 'Pagamento desfeito com sucesso.');
    }
}
