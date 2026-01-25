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
        $user = $request->user();

        // ao entrar, garante que esta família vira a ativa do usuário
        $this->activation->activateForUser($user, $family);

        return view('family.dashboard', [
            'family' => $family,
        ]);
    }
}
