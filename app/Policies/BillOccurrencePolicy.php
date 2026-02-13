<?php

namespace App\Policies;

use App\Models\BillOccurrence;
use App\Models\Family;
use App\Models\User;

class BillOccurrencePolicy
{
    public function viewAny(User $user, Family $family): bool
    {
        return $user->families()->whereKey($family->id)->exists();
    }

    public function update(User $user, BillOccurrence $occurrence): bool
    {
        $familyId = $occurrence->bill?->family_id;

        if (! $familyId) {
            $familyId = $occurrence->bill()->value('family_id');
        }

        if (! $familyId) {
            return false;
        }

        return $user->families()->whereKey($familyId)->exists();
    }
}
