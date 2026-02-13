<?php

namespace App\Policies;

use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\Scenario;
use App\Models\User;

class ScenarioPolicy
{
    private function isMember(User $user, string $familyId): bool
    {
        return FamilyMember::query()
            ->where('family_id', $familyId)
            ->where('user_id', $user->id)
            ->exists();
    }

    public function viewAny(User $user, Family $family): bool
    {
        return $this->isMember($user, (string) $family->id);
    }

    public function create(User $user, Family $family): bool
    {
        return $this->isMember($user, (string) $family->id);
    }

    public function view(User $user, Scenario $scenario): bool
    {
        return $this->isMember($user, (string) $scenario->family_id);
    }

    public function update(User $user, Scenario $scenario): bool
    {
        return $this->isMember($user, (string) $scenario->family_id);
    }

    public function delete(User $user, Scenario $scenario): bool
    {
        return $this->isMember($user, (string) $scenario->family_id);
    }
}
