<?php

namespace App\Policies;

use App\Models\Family;
use App\Models\TaxonomyNode;
use App\Models\User;

class TaxonomyNodePolicy
{
    public function viewAny(User $user, ?Family $family = null): bool
    {
        // /f/{family}/taxonomia => precisa ser membro
        if ($family) {
            return $user->families()->whereKey($family->id)->exists();
        }

        // /taxonomia (global) => permitido para usuário autenticado
        return true;
    }
}
