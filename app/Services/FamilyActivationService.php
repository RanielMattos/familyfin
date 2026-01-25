<?php

namespace App\Services;

use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;

class FamilyActivationService
{
    /**
     * Garante 1 família ativa por usuário.
     * - Desativa todas do usuário
     * - Ativa a família informada (se houver vínculo)
     */
    public function activateForUser(User $user, Family $family): void
    {
        DB::transaction(function () use ($user, $family) {
            // Confirma vínculo (segurança + evita update silencioso)
            $hasMembership = FamilyMember::query()
                ->where('user_id', $user->id)
                ->where('family_id', $family->id)
                ->exists();

            if (! $hasMembership) {
                throw new AuthorizationException('User is not a member of this family.');
            }

            // Desativa todas as famílias do usuário
            FamilyMember::query()
                ->where('user_id', $user->id)
                ->update(['is_active' => 0]);

            // Ativa a família alvo
            FamilyMember::query()
                ->where('user_id', $user->id)
                ->where('family_id', $family->id)
                ->update(['is_active' => 1]);
        });
    }
}
