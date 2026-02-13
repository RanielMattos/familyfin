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
        $this->authorize('viewAny', [Income::class, $family]);

        $incomes = $family->incomes()
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
        $this->authorize('create', [Income::class, $family]);

        $data = $request->validate([
            'description' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'received_at' => ['required', 'date'],
        ]);

        $family->incomes()->create($data);

        return redirect()
            ->route('incomes.index', ['family' => $family])
            ->with('success', 'Receita adicionada com sucesso.');
    }

    public function update(Request $request, Family $family, Income $income): RedirectResponse
    {
        // Com Route::scopeBindings() um income fora da família vira 404 antes de chegar aqui.
        $this->authorize('update', $income);

        $data = $request->validate([
            'description' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'received_at' => ['required', 'date'],
        ]);

        $income->update($data);

        return redirect()
            ->route('incomes.index', ['family' => $family])
            ->with('success', 'Receita atualizada com sucesso.');
    }

    public function destroy(Family $family, Income $income): RedirectResponse
    {
        $this->authorize('delete', $income);

        $income->delete();

        return redirect()
            ->route('incomes.index', ['family' => $family])
            ->with('success', 'Receita removida com sucesso.');
    }
}
