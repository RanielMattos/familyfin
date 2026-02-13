<?php

namespace App\Policies;

use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\User;

class FamilyMemberPolicy
{
    public function viewAny(User $user, Family $family): bool
    {
        // Ver a lista: qualquer membro da família
        return $user->families()->whereKey($family->id)->exists();
    }

    public function create(User $user, Family $family): bool
    {
        // Adicionar membro: OWNER ou ADMIN
        return $user->hasFamilyRole($family, [
            FamilyMember::ROLE_OWNER,
            FamilyMember::ROLE_ADMIN,
        ]);
    }

    public function update(User $user, FamilyMember $member): bool
    {
        // Editar role/status: OWNER ou ADMIN
        return $user->hasFamilyRole($member->family_id, [
            FamilyMember::ROLE_OWNER,
            FamilyMember::ROLE_ADMIN,
        ]);
    }

    public function delete(User $user, FamilyMember $member): bool
    {
        // Remover membro: OWNER ou ADMIN
        // (regra "não remover último owner" continua no controller, que dá feedback melhor)
        return $user->hasFamilyRole($member->family_id, [
            FamilyMember::ROLE_OWNER,
            FamilyMember::ROLE_ADMIN,
        ]);
    }
}
