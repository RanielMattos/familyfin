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
            ->orderBy('direction')
            ->orderBy('name')
            ->get(['id', 'name', 'direction', 'slug', 'created_at']);

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

        $baseSlug = Str::slug($validated['name']);
        $slug = $baseSlug;

        // garante slug único por família
        $i = 1;
        while (
            Bill::query()
                ->where('family_id', $family->id)
                ->where('slug', $slug)
                ->exists()
        ) {
            $i++;
            $slug = "{$baseSlug}-{$i}";
        }

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
}
