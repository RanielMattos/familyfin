<?php

namespace App\Http\Controllers;

use App\Models\BillOccurrence;
use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class FamilyPlanpagPageController extends Controller
{
    public function __invoke(Request $request, Family $family): View
    {
        $data = $request->validate([
            'from' => ['required', 'date'],
            'to'   => ['required', 'date', 'after_or_equal:from'],
        ]);

        $from = Carbon::parse($data['from'])->toDateString();
        $to   = Carbon::parse($data['to'])->toDateString();

        $occurrences = BillOccurrence::query()
            ->with('bill:id,family_id,direction,name,slug')
            ->whereHas('bill', fn ($q) => $q->where('family_id', $family->id))
            ->whereBetween('due_date', [$from, $to])
            ->orderBy('due_date')
            ->get();

        return view('family.planpag', [
            'family' => $family,
            'from' => $from,
            'to' => $to,
            'occurrences' => $occurrences,
        ]);
    }
}
