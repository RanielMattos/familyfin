<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        $families = $user->families()
            ->orderBy('name')
            ->get();

        $activeFamily = $families->firstWhere('pivot.is_active', 1);

        return view('dashboard', [
            'families' => $families,
            'activeFamily' => $activeFamily,
        ]);
    }
}
