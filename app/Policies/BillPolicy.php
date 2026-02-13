<?php

namespace App\Policies;

use App\Models\Bill;
use App\Models\Family;
use App\Models\User;

class BillPolicy
{
    public function viewAny(User $user, Family $family): bool
    {
        return $user->families()->whereKey($family->id)->exists();
    }

    public function create(User $user, Family $family): bool
    {
        return $user->families()->whereKey($family->id)->exists();
    }

    public function update(User $user, Bill $bill): bool
    {
        return $user->families()->whereKey($bill->family_id)->exists();
    }

    public function delete(User $user, Bill $bill): bool
    {
        return $user->families()->whereKey($bill->family_id)->exists();
    }

    public function toggleActive(User $user, Bill $bill): bool
    {
        return $user->families()->whereKey($bill->family_id)->exists();
    }
}
