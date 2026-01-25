<?php

namespace App\Http\Middleware;

use App\Models\Family;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureFamilyAccess
{
    /**
     * Exige que:
     * - exista um parâmetro de rota {family}
     * - o usuário autenticado seja membro dessa família (independente de is_active)
     * - injeta o model Family resolvido em $request->attributes
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (! $user) {
            abort(401);
        }

        $familyParam = $request->route('family');
        if (! $familyParam) {
            abort(400, 'Missing family route parameter.');
        }

        // Suporta tanto ID quanto Route Model Binding (Family $family)
        $family = $familyParam instanceof Family
            ? $familyParam
            : Family::query()->find($familyParam);

        if (! $family) {
            abort(404);
        }

        $isMember = $user->familyMemberships()
            ->where('family_id', $family->id)
            ->exists();

        if (! $isMember) {
            abort(403);
        }

        $request->attributes->set('currentFamily', $family);

        return $next($request);
    }
}
