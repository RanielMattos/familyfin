<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\FamilyMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
        ]);

        $user = $request->user();

        // desativa todas
        FamilyMember::where('user_id', $user->id)->update(['is_active' => 0]);

        // cria família
        $family = Family::create([
            'name' => $data['name'],
        ]);

        // vincula como owner e ativa
        $user->families()->attach($family->id, [
            'role' => 'owner',
            'is_active' => 1,
            'joined_at' => now(),
        ]);

        return redirect()->route('family.dashboard', ['family' => $family->id]);
    }

    public function activate(Request $request, Family $family): RedirectResponse
    {
        $user = $request->user();

        // desativa todas
        FamilyMember::where('user_id', $user->id)->update(['is_active' => 0]);

        // ativa a selecionada (middleware já garante acesso)
        FamilyMember::where('user_id', $user->id)
            ->where('family_id', $family->id)
            ->update(['is_active' => 1]);

        return redirect()->route('family.dashboard', ['family' => $family->id]);
    }
}
