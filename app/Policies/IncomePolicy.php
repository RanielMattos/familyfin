<?php

namespace App\Policies;

use App\Models\Family;
use App\Models\Income;
use App\Models\User;

class IncomePolicy
{
    /**
     * Membro da família (pelo pivot family_members).
     */
    protected function isMemberOfFamily(User $user, Family $family): bool
    {
        return $user->families()
            ->whereKey($family->id)
            ->exists();
    }

    /**
     * Membro da família dona da receita.
     */
    protected function isMemberOfIncomeFamily(User $user, Income $income): bool
    {
        return $user->families()
            ->whereKey($income->family_id)
            ->exists();
    }

    /**
     * IMPORTANTE:
     * - Laravel pode chamar viewAny(User $user) quando autoriza com Income::class
     * - Nós também podemos chamar viewAny(User $user, Family $family) passando a família
     */
    public function viewAny(User $user, ?Family $family = null): bool
    {
        return $family ? $this->isMemberOfFamily($user, $family) : true;
    }

    public function view(User $user, Income $income): bool
    {
        return $this->isMemberOfIncomeFamily($user, $income);
    }

    /**
     * IMPORTANTE:
     * - Laravel chama create(User $user) quando autoriza com Income::class
     * - Nós também podemos chamar create(User $user, Family $family) passando a família
     */
    public function create(User $user, ?Family $family = null): bool
    {
        return $family ? $this->isMemberOfFamily($user, $family) : true;
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
