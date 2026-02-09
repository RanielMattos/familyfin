<?php

namespace App\Policies;

use App\Models\Income;
use App\Models\User;

class IncomePolicy
{
    public function viewAny(User $user): bool
    {
        // Usuário precisa pertencer a pelo menos uma família
        return $user->families()->exists();
    }

    public function view(User $user, Income $income): bool
    {
        return $this->isMemberOfIncomeFamily($user, $income);
    }

    public function create(User $user): bool
    {
        // A criação real é garantida pela rota /f/{family} + EnsureFamilyAccess
        return $user->families()->exists();
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
        return $this->isMemberOfIncomeFamily($user, $income);
    }

    public function forceDelete(User $user, Income $income): bool
    {
        return $this->isMemberOfIncomeFamily($user, $income);
    }

    private function isMemberOfIncomeFamily(User $user, Income $income): bool
    {
        // Trava por tenancy: só pode mexer em receitas da família que ele participa
        return $user->families()->whereKey($income->family_id)->exists();
    }
}
