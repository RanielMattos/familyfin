<?php

namespace App\Http\Controllers;

use App\Models\BudgetEntry;
use App\Models\BudgetLine;
use App\Models\Family;
use App\Models\Scenario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FamilyBudgetEntriesController extends Controller
{
    /**
     * Store = UPSERT por competência (normaliza para YYYY-MM-01).
     * Aceita amount_cents (int) OU amount (texto "1.234,56").
     */
    public function store(Request $request, Family $family, Scenario $scenario, BudgetLine $line): JsonResponse
    {
        if ((string) $scenario->family_id !== (string) $family->id) {
            abort(404);
        }

        if ((string) $line->scenario_id !== (string) $scenario->id || (string) $line->family_id !== (string) $family->id) {
            abort(404);
        }

        $this->authorize('create', [BudgetEntry::class, $line]);

        $validated = $request->validate([
            'competence' => ['required', 'date'],
            'amount_cents' => ['nullable', 'integer'],
            'amount' => ['nullable', 'string'],
        ]);

        $competence = Carbon::parse($validated['competence'])->startOfMonth()->toDateString();

        $amountCents = null;

        if ($request->filled('amount_cents')) {
            $amountCents = (int) $request->input('amount_cents');
        } elseif ($request->filled('amount')) {
            $amountCents = $this->parseMoneyToCents((string) $request->input('amount'));
        }

        if ($amountCents === null) {
            $amountCents = 0;
        }

        $entry = BudgetEntry::updateOrCreate(
            [
                'budget_line_id' => $line->id,
                'competence' => $competence,
            ],
            [
                'amount_cents' => $amountCents,
            ]
        );

        return response()->json([
            'data' => $entry->only([
                'id',
                'budget_line_id',
                'competence',
                'amount_cents',
            ]),
        ]);
    }

    public function destroy(Family $family, Scenario $scenario, BudgetLine $line, BudgetEntry $entry): JsonResponse
    {
        if ((string) $scenario->family_id !== (string) $family->id) {
            abort(404);
        }

        if ((string) $line->scenario_id !== (string) $scenario->id || (string) $line->family_id !== (string) $family->id) {
            abort(404);
        }

        if ((string) $entry->budget_line_id !== (string) $line->id) {
            abort(404);
        }

        $this->authorize('delete', $entry);

        $entry->delete();

        return response()->json([], 204);
    }

    private function parseMoneyToCents(string $raw): ?int
    {
        $raw = trim($raw);

        if ($raw === '') {
            return null;
        }

        $negative = str_contains($raw, '-');

        $clean = preg_replace('/[^\d,\.]/', '', $raw) ?? '';
        $clean = trim($clean);

        if ($clean === '') {
            return null;
        }

        $lastComma = strrpos($clean, ',');
        $lastDot = strrpos($clean, '.');

        $decimalSep = null;
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
