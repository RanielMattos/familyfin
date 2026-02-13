<?php

namespace App\Policies;

use App\Models\BudgetEntry;
use App\Models\BudgetLine;
use App\Models\FamilyMember;
use App\Models\User;

class BudgetEntryPolicy
{
    private function isMember(User $user, string $familyId): bool
    {
        return FamilyMember::query()
            ->where('family_id', $familyId)
            ->where('user_id', $user->id)
            ->exists();
    }

    public function create(User $user, BudgetLine $line): bool
    {
        return $this->isMember($user, (string) $line->family_id);
    }

    public function delete(User $user, BudgetEntry $entry): bool
    {
        $entry->loadMissing('line:id,family_id');

        return $entry->line
            ? $this->isMember($user, (string) $entry->line->family_id)
            : false;
    }
}
