<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): RedirectResponse|View
    {
        $user = $request->user();

        $families = $user->families()->get();

        $activeFamily = $user->families()
            ->wherePivot('is_active', 1)
            ->first();

        if ($activeFamily) {
            return redirect()->route('family.dashboard', ['family' => $activeFamily->id]);
        }

        return view('dashboard', [
            'families' => $families,
            'activeFamily' => null,
        ]);
    }
}
