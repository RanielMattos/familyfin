<?php

namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\View\View;

class FamilyDashboardController extends Controller
{
    public function index(Family $family): View
    {
        return view('family.dashboard', [
            'family' => $family,
        ]);
    }
}
