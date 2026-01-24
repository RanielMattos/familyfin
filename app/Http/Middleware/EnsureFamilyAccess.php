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
     * - exista um parâmetro de rota {family} (ULID)
     * - o usuário autenticado seja membro dessa família
     * - injeta o model Family resolvido em $request->attributes para uso posterior
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (!$user) {
            abort(401);
        }

        $familyId = $request->route('family');
        if (!$familyId) {
            abort(400, 'Missing family route parameter.');
        }

        $isMember = $user->familyMemberships()
            ->where('family_id', $familyId)
            ->where('is_active', true)
            ->exists();

        if (!$isMember) {
            abort(403);
        }

        /** @var Family|null $family */
        $family = Family::query()->find($familyId);

        if (!$family) {
            abort(404);
        }

        // Deixa a família acessível em qualquer camada sem “buscar de novo”
        $request->attributes->set('currentFamily', $family);

        return $next($request);
    }
}
