<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Services\FamilyActivationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    public function __construct(
        private readonly FamilyActivationService $activation
    ) {}

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
        ]);

        $user = $request->user();

        $family = Family::create([
            'name' => $data['name'],
        ]);

        // cria o vínculo como owner (começa inativa; o service garante "1 ativa por vez")
        $user->families()->attach($family->id, [
            'role'      => 'owner',
            'is_active' => 0,
            'joined_at' => now(),
        ]);

        $this->activation->activateForUser($user, $family);

        return redirect()->route('family.dashboard', ['family' => $family->id]);
    }

    public function activate(Request $request, Family $family): RedirectResponse
    {
        $user = $request->user();

        $this->activation->activateForUser($user, $family);

        return redirect()->route('family.dashboard', ['family' => $family->id]);
    }
}
