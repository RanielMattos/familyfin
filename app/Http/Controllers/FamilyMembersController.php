<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FamilyMembersController extends Controller
{
    private function ownersCount(Family $family): int
    {
        // Conta OWNER mesmo que esteja salvo como 'owner'
        return $family->members()
            ->whereRaw("UPPER(role) = 'OWNER'")
            ->count();
    }

    private function rolesForUi(): array
    {
        return [
            FamilyMember::ROLE_OWNER  => 'Owner',
            FamilyMember::ROLE_ADMIN  => 'Admin',
            FamilyMember::ROLE_MEMBER => 'Membro',
            FamilyMember::ROLE_VIEWER => 'Visualizador',
        ];
    }

    public function index(Request $request, Family $family): View
    {
        // ✅ Qualquer membro pode ver a lista (Policy decide)
        $this->authorize('viewAny', [FamilyMember::class, $family]);

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

        // ✅ Só pra UI saber se mostra ações (sem abortar)
        $canManage = (bool) $request->user()?->can('create', [FamilyMember::class, $family]);

        return view('family.members.index', [
            'family'    => $family,
            'members'   => $members,
            'roles'     => $this->rolesForUi(),
            'canManage' => $canManage,
        ]);
    }

    public function store(Request $request, Family $family): RedirectResponse
    {
        // ✅ Só OWNER/ADMIN podem adicionar (Policy decide)
        $this->authorize('create', [FamilyMember::class, $family]);

        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', 'exists:users,email'],
            'role'  => ['required', Rule::in([
                FamilyMember::ROLE_OWNER,
                FamilyMember::ROLE_ADMIN,
                FamilyMember::ROLE_MEMBER,
                FamilyMember::ROLE_VIEWER,
            ])],
        ]);

        $userToAdd = User::query()
            ->where('email', $validated['email'])
            ->firstOrFail();

        if ($family->members()->where('user_id', $userToAdd->id)->exists()) {
            return back()
                ->withErrors(['email' => 'Esse usuário já é membro desta família.'])
                ->withInput();
        }

        DB::transaction(function () use ($family, $userToAdd, $validated) {
            $family->members()->create([
                'user_id'    => $userToAdd->id,
                'role'       => strtoupper($validated['role']),
                'is_active'  => true,
                'joined_at'  => now(),
            ]);
        });

        return redirect()
            ->route('family.members.index', ['family' => $family])
            ->with('success', 'Membro adicionado com sucesso.');
    }

    public function update(Request $request, Family $family, FamilyMember $member): RedirectResponse
    {
        // ✅ Só OWNER/ADMIN podem alterar (Policy decide)
        // ✅ scopeBindings garante que $member pertence a $family (senão vira 404 antes)
        $this->authorize('update', $member);

        $validated = $request->validate([
            'role' => ['required', Rule::in([
                FamilyMember::ROLE_OWNER,
                FamilyMember::ROLE_ADMIN,
                FamilyMember::ROLE_MEMBER,
                FamilyMember::ROLE_VIEWER,
            ])],
        ]);

        $newRole     = strtoupper($validated['role']);
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
            ->route('family.members.index', ['family' => $family])
            ->with('success', 'Permissão atualizada.');
    }

    public function destroy(Request $request, Family $family, FamilyMember $member): RedirectResponse
    {
        // ✅ Só OWNER/ADMIN podem remover (Policy decide)
        // ✅ scopeBindings garante que $member pertence a $family
        $this->authorize('delete', $member);

        $authUser = $request->user();

        // Segurança: não remover a si mesmo aqui (evita lockout acidental)
        if ($authUser && $member->user_id === $authUser->id) {
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
            ->route('family.members.index', ['family' => $family])
            ->with('success', 'Membro removido.');
    }
}
