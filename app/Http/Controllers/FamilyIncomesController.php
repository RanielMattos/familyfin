<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Income;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FamilyIncomesController extends Controller
{
    public function index(Family $family): View
    {
        $incomes = Income::query()
            ->where('family_id', $family->id)
            ->orderByDesc('received_at')
            ->orderByDesc('id')
            ->get(['id', 'family_id', 'description', 'amount', 'received_at', 'created_at']);

        return view('family.incomes.index', [
            'family' => $family,
            'incomes' => $incomes,
        ]);
    }

    public function store(Request $request, Family $family): RedirectResponse
    {
        $data = $request->validate([
            'description' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'received_at' => ['required', 'date'],
        ]);

        $family->incomes()->create($data);

        return redirect("/f/{$family->id}/incomes")
            ->with('success', 'Receita adicionada com sucesso.');
    }

    public function update(Request $request, Family $family, Income $income): RedirectResponse
    {
        $this->ensureIncomeBelongsToFamily($family, $income);

        $data = $request->validate([
            'description' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'received_at' => ['required', 'date'],
        ]);

        $income->update($data);

        return redirect("/f/{$family->id}/incomes")
            ->with('success', 'Receita atualizada com sucesso.');
    }

    public function destroy(Family $family, Income $income): RedirectResponse
    {
        $this->ensureIncomeBelongsToFamily($family, $income);

        $income->delete();

        return redirect("/f/{$family->id}/incomes")
            ->with('success', 'Receita removida com sucesso.');
    }

    private function ensureIncomeBelongsToFamily(Family $family, Income $income): void
    {
        if ((string) $income->family_id !== (string) $family->id) {
            abort(404);
        }
    }
}
