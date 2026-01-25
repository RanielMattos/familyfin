<?php

namespace App\Http\Middleware;

use App\Models\Family;
use App\Services\FamilyActivationService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AutoActivateFamily
{
    public function __construct(
        private readonly FamilyActivationService $activation
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Se não tiver user, o auth vai cuidar (não é função daqui)
        if (! $user) {
            return $next($request);
        }

        // Preferimos a Family já resolvida pelo EnsureFamilyAccess (sem query extra)
        $family = $request->attributes->get('currentFamily');

        // Fallback: se por algum motivo não veio no attributes, tenta pelo parâmetro de rota
        if (! $family) {
            $familyParam = $request->route('family');
            $family = $familyParam instanceof Family ? $familyParam : null;
        }

        if ($family) {
            // Garante que esta family vira ativa ao acessar qualquer /f/{family}/*
            $this->activation->activateForUser($user, $family);
        }

        return $next($request);
    }
}
