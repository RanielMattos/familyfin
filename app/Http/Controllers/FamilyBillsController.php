<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBillRequest;
use App\Models\Bill;
use App\Models\Family;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class FamilyBillsController extends Controller
{
    public function index(Family $family): View
    {
        $bills = Bill::query()
            ->where('family_id', $family->id)
            ->withCount('occurrences')
            ->orderBy('direction')
            ->orderBy('name')
            ->get(['id', 'name', 'direction', 'slug', 'created_at', 'family_id', 'is_active']);

        return view('family.bills.index', [
            'family' => $family,
            'bills' => $bills,
        ]);
    }

    public function create(Family $family): View
    {
        return view('family.bills.create', [
            'family' => $family,
        ]);
    }

    public function store(StoreBillRequest $request, Family $family): RedirectResponse
    {
        $validated = $request->validated();

        $slug = $this->uniqueSlugForFamily(
            familyId: $family->id,
            name: $validated['name'],
        );

        $bill = new Bill();
        $bill->family_id = $family->id;
        $bill->created_by_user_id = $request->user()->id;
        $bill->direction = $validated['direction'];
        $bill->name = $validated['name'];
        $bill->slug = $slug;
        $bill->save();

        return redirect()
            ->route('family.bills.index', $family)
            ->with('success', 'Conta criada com sucesso.');
    }

    public function edit(Family $family, Bill $bill): View
    {
        $this->ensureBillBelongsToFamily($family, $bill);

        return view('family.bills.edit', [
            'family' => $family,
            'bill' => $bill,
        ]);
    }

    public function update(StoreBillRequest $request, Family $family, Bill $bill): RedirectResponse
    {
        $this->ensureBillBelongsToFamily($family, $bill);

        $validated = $request->validated();

        $slug = $this->uniqueSlugForFamily(
            familyId: $family->id,
            name: $validated['name'],
            ignoreBillId: $bill->id,
        );

        $bill->direction = $validated['direction'];
        $bill->name = $validated['name'];
        $bill->slug = $slug;
        $bill->save();

        return redirect()
            ->route('family.bills.index', $family)
            ->with('success', 'Conta atualizada com sucesso.');
    }

    public function destroy(Family $family, Bill $bill): RedirectResponse
    {
        $this->ensureBillBelongsToFamily($family, $bill);

        // Segurança: evitar apagar ocorrências via cascade sem querer
        if ($bill->occurrences()->exists()) {
            return redirect()
                ->route('family.bills.index', $family)
                ->with('error', 'Não é possível remover esta conta porque ela possui ocorrências (lançamentos) vinculadas.');
        }

        $bill->delete();

        return redirect()
            ->route('family.bills.index', $family)
            ->with('success', 'Conta removida com sucesso.');
    }

    public function toggleActive(Family $family, Bill $bill): RedirectResponse
    {
        $this->ensureBillBelongsToFamily($family, $bill);

        $bill->is_active = ! (bool) $bill->is_active;
        $bill->save();

        $message = $bill->is_active
            ? 'Conta ativada com sucesso.'
            : 'Conta inativada com sucesso.';

        return redirect()
            ->route('family.bills.index', $family)
            ->with('success', $message);
    }

    private function ensureBillBelongsToFamily(Family $family, Bill $bill): void
    {
        if ((string) $bill->family_id !== (string) $family->id) {
            abort(404);
        }
    }

    private function uniqueSlugForFamily(string $familyId, string $name, ?string $ignoreBillId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;

        $i = 1;

        while (
            Bill::query()
                ->where('family_id', $familyId)
                ->when($ignoreBillId, fn ($q) => $q->where('id', '!=', $ignoreBillId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $i++;
            $slug = "{$baseSlug}-{$i}";
        }

        return $slug;
    }
}
