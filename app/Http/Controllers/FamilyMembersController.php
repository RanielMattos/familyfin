<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class FamilyMembersController extends Controller
{
    private function manageRoles(): array
    {
        // Suporta dados antigos (lowercase) e o padrão atual (uppercase)
        return [
            FamilyMember::ROLE_OWNER,
            FamilyMember::ROLE_ADMIN,
            strtolower(FamilyMember::ROLE_OWNER),
            strtolower(FamilyMember::ROLE_ADMIN),
        ];
    }

    private function canManage(Family $family): bool
    {
        $user = request()->user();
        if (!$user) return false;

        return $user->families()
            ->whereKey($family->id)
            ->wherePivotIn('role', $this->manageRoles())
            ->exists();
    }

    private function ownersCount(Family $family): int
    {
        // Conta OWNER mesmo que esteja salvo como 'owner'
        return $family->members()
            ->whereRaw("UPPER(role) = 'OWNER'")
            ->count();
    }

    public function index(Request $request, Family $family)
    {
        $members = $family->members()
            ->with('user')
            ->orderByRaw("CASE UPPER(role)
                WHEN 'OWNER' THEN 1
                WHEN 'ADMIN' THEN 2
                WHEN 'MEMBER' THEN 3
                WHEN 'VIEWER' THEN 4
                ELSE 9 END")
            ->orderBy('created_at')
            ->get();

        $roles = [
            FamilyMember::ROLE_OWNER  => 'Owner',
            FamilyMember::ROLE_ADMIN  => 'Admin',
            FamilyMember::ROLE_MEMBER => 'Membro',
            FamilyMember::ROLE_VIEWER => 'Visualizador',
        ];

        return view('family.members.index', [
            'family' => $family,
            'members' => $members,
            'roles' => $roles,
            'canManage' => $this->canManage($family),
        ]);
    }

    public function store(Request $request, Family $family)
    {
        abort_unless($this->canManage($family), 403);

        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', 'exists:users,email'],
            'role'  => ['required', Rule::in([
                FamilyMember::ROLE_OWNER,
                FamilyMember::ROLE_ADMIN,
                FamilyMember::ROLE_MEMBER,
                FamilyMember::ROLE_VIEWER,
            ])],
        ]);

        $userToAdd = User::where('email', $validated['email'])->firstOrFail();

        if ($family->members()->where('user_id', $userToAdd->id)->exists()) {
            return back()
                ->withErrors(['email' => 'Esse usuário já é membro desta família.'])
                ->withInput();
        }

        DB::transaction(function () use ($family, $userToAdd, $validated) {
            $family->members()->create([
                'user_id' => $userToAdd->id,
                'role' => strtoupper($validated['role']),
                'is_active' => true,
                'joined_at' => now(),
            ]);
        });

        return redirect()
            ->route('family.members.index', ['family' => $family->id])
            ->with('success', 'Membro adicionado com sucesso.');
    }

    public function update(Request $request, Family $family, FamilyMember $member)
    {
        abort_unless($this->canManage($family), 403);

        $validated = $request->validate([
            'role' => ['required', Rule::in([
                FamilyMember::ROLE_OWNER,
                FamilyMember::ROLE_ADMIN,
                FamilyMember::ROLE_MEMBER,
                FamilyMember::ROLE_VIEWER,
            ])],
        ]);

        $newRole = strtoupper($validated['role']);
        $currentRole = strtoupper((string) $member->role);

        // Proteção: não permitir rebaixar o último OWNER
        if ($currentRole === 'OWNER' && $newRole !== 'OWNER' && $this->ownersCount($family) <= 1) {
            return back()->withErrors([
                'role' => 'Você não pode rebaixar o último Owner da família.',
            ]);
        }

        $member->update([
            'role' => $newRole,
        ]);

        return redirect()
            ->route('family.members.index', ['family' => $family->id])
            ->with('success', 'Permissão atualizada.');
    }

    public function destroy(Request $request, Family $family, FamilyMember $member)
    {
        abort_unless($this->canManage($family), 403);

        // Segurança: não remover a si mesmo aqui (evita lockout acidental)
        if ($member->user_id === $request->user()->id) {
            return back()->withErrors([
                'delete' => 'Você não pode remover a si mesmo.',
            ]);
        }

        // Proteção: não permitir remover o último OWNER
        if (strtoupper((string) $member->role) === 'OWNER' && $this->ownersCount($family) <= 1) {
            return back()->withErrors([
                'delete' => 'Você não pode remover o último Owner da família.',
            ]);
        }

        $member->delete();

        return redirect()
            ->route('family.members.index', ['family' => $family->id])
            ->with('success', 'Membro removido.');
    }
}
