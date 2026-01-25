<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\FamilyMember;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FamilyDashboardController extends Controller
{
    public function index(Request $request, Family $family): View
    {
        $user = $request->user();

        // garante 1 ativa por usuário: ao entrar, torna esta ativa
        FamilyMember::where('user_id', $user->id)->update(['is_active' => 0]);

        FamilyMember::where('user_id', $user->id)
            ->where('family_id', $family->id)
            ->update(['is_active' => 1]);

        return view('family.dashboard', [
            'family' => $family,
        ]);
    }
}
