<?php

namespace App\Policies;

use App\Models\Income;
use App\Models\User;

class IncomePolicy
{
    /**
     * Regra base: só quem é membro da família dona da receita pode ver/editar/excluir.
     * (Compatível com tenancy via /f/{family} + EnsureFamilyAccess)
     */
    protected function isMemberOfIncomeFamily(User $user, Income $income): bool
    {
        return $user->families()
            ->whereKey($income->family_id)
            ->exists();
    }

    public function viewAny(User $user): bool
    {
        // A listagem é sempre family-scoped pela rota/middleware.
        return true;
    }

    public function view(User $user, Income $income): bool
    {
        return $this->isMemberOfIncomeFamily($user, $income);
    }

    public function create(User $user): bool
    {
        // A criação também é family-scoped pela rota/middleware.
        return true;
    }

    public function update(User $user, Income $income): bool
    {
        return $this->isMemberOfIncomeFamily($user, $income);
    }

    public function delete(User $user, Income $income): bool
    {
        return $this->isMemberOfIncomeFamily($user, $income);
    }

    public function restore(User $user, Income $income): bool
    {
        return false;
    }

    public function forceDelete(User $user, Income $income): bool
    {
        return false;
    }
}
