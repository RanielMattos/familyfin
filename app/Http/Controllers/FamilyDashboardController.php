<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Services\FamilyActivationService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FamilyDashboardController extends Controller
{
    public function __construct(
        private readonly FamilyActivationService $activation
    ) {}

    public function index(Request $request, Family $family): View
    {
        return view('family.dashboard', [
            'family' => $family,
        ]);
    }
}
