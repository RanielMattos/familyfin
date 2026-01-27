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
            $paidAmountCents = null;

            // 1) Se vier em centavos, usa direto
            if ($request->filled('paid_amount_cents')) {
                $paidAmountCents = (int) $request->input('paid_amount_cents');
            }
            // 2) Se vier em reais (texto), converte pra centavos
            elseif ($request->filled('paid_amount')) {
                $paidAmountCents = $this->parseMoneyToCents((string) $request->input('paid_amount'));
            }

            // 3) Fallback: planned_amount_cents
            if ($paidAmountCents === null) {
                $paidAmountCents = (int) $occurrence->planned_amount_cents;
            }

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

    /**
     * Aceita valores tipo:
     * - "129,90" / "129.90"
     * - "1.234,56" / "1,234.56"
     * - "129" (inteiro)
     * Retorna centavos (int) ou null se não der pra interpretar.
     */
    private function parseMoneyToCents(string $raw): ?int
    {
        $raw = trim($raw);

        if ($raw === '') {
            return null;
        }

        $negative = str_contains($raw, '-');

        // Mantém só dígitos e separadores
        $clean = preg_replace('/[^\d,\.]/', '', $raw) ?? '';
        $clean = trim($clean);

        if ($clean === '') {
            return null;
        }

        $lastComma = strrpos($clean, ',');
        $lastDot = strrpos($clean, '.');

        // Decide separador decimal pelo último separador encontrado
        $decimalSep = null; // ',' ou '.'
        $thousandSep = null;

        if ($lastComma !== false && $lastDot !== false) {
            if ($lastComma > $lastDot) {
                $decimalSep = ',';
                $thousandSep = '.';
            } else {
                $decimalSep = '.';
                $thousandSep = ',';
            }
        } elseif ($lastComma !== false) {
            $decimalSep = ',';
            $thousandSep = '.';
        } elseif ($lastDot !== false) {
            $decimalSep = '.';
            $thousandSep = ',';
        }

        $normalized = $clean;

        if ($thousandSep !== null) {
            $normalized = str_replace($thousandSep, '', $normalized);
        }

        if ($decimalSep !== null) {
            $normalized = str_replace($decimalSep, '.', $normalized);
        }

        // Agora deve ficar: "1234" ou "1234.56"
        if (! preg_match('/^\d+(\.\d+)?$/', $normalized)) {
            return null;
        }

        [$intPart, $decPart] = array_pad(explode('.', $normalized, 2), 2, '');
        $decPart = substr($decPart, 0, 2);
        $decPart = str_pad($decPart, 2, '0');

        $cents = ((int) $intPart) * 100 + (int) $decPart;

        if ($negative) {
            $cents *= -1;
        }

        return $cents;
    }
}
