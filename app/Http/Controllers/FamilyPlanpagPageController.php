<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Services\PlanpagService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FamilyPlanpagPageController extends Controller
{
    public function __construct(
        private readonly PlanpagService $planpag
    ) {}

    public function __invoke(Request $request, Family $family): View
    {
        $validated = $request->validate([
            'from' => ['required', 'date'],
            'to'   => ['required', 'date', 'after_or_equal:from'],
        ]);

        $from = $validated['from'];
        $to   = $validated['to'];

        $occurrences = $this->planpag->listByDueDateRange($from, $to, $family);

        return view('family.planpag', [
            'family'      => $family,
            'from'        => $from,
            'to'          => $to,
            'occurrences' => $occurrences,
        ]);
    }
}
