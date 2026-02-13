<?php

namespace App\Policies;

use App\Models\BudgetLine;
use App\Models\FamilyMember;
use App\Models\Scenario;
use App\Models\User;

class BudgetLinePolicy
{
    private function isMember(User $user, string $familyId): bool
    {
        return FamilyMember::query()
            ->where('family_id', $familyId)
            ->where('user_id', $user->id)
            ->exists();
    }

    public function viewAny(User $user, Scenario $scenario): bool
    {
        return $this->isMember($user, (string) $scenario->family_id);
    }

    public function create(User $user, Scenario $scenario): bool
    {
        return $this->isMember($user, (string) $scenario->family_id);
    }

    public function view(User $user, BudgetLine $line): bool
    {
        return $this->isMember($user, (string) $line->family_id);
    }

    public function update(User $user, BudgetLine $line): bool
    {
        return $this->isMember($user, (string) $line->family_id);
    }

    public function delete(User $user, BudgetLine $line): bool
    {
        return $this->isMember($user, (string) $line->family_id);
    }
}
