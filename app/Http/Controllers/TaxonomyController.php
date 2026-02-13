<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\TaxonomyNode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaxonomyController extends Controller
{
    /**
     * Retorna taxonomia GLOBAL em formato de árvore:
     * [
     *   { id, type, direction, name, slug, description, children: [ ... ] }
     * ]
     */
    public function index(Request $request, ?Family $family = null): JsonResponse
    {
        // Se a rota for /f/{family}/taxonomia, exige membership (Policy)
        if ($family) {
            $this->authorize('viewAny', [TaxonomyNode::class, $family]);
        } else {
            // Mantém /taxonomia funcionando como antes (se houver user, checa policy; se não, não bloqueia)
            if ($request->user()) {
                $this->authorize('viewAny', [TaxonomyNode::class, null]);
            }
        }

        $groups = TaxonomyNode::query()
            ->whereNull('family_id')
            ->where('type', TaxonomyNode::TYPE_GROUP)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        // Pré-carrega categorias de uma vez (evita N+1)
        $categoriesByParent = TaxonomyNode::query()
            ->whereNull('family_id')
            ->where('type', TaxonomyNode::TYPE_CATEGORY)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->groupBy('parent_id');

        $payload = $groups->map(function (TaxonomyNode $g) use ($categoriesByParent) {
            $children = ($categoriesByParent[$g->id] ?? collect())->values()->map(function (TaxonomyNode $c) {
                return $this->nodeDto($c, []);
            });

            return $this->nodeDto($g, $children);
        })->values();

        return response()->json([
            'data' => $payload,
        ]);
    }

    private function nodeDto(TaxonomyNode $node, $children): array
    {
        return [
            'id' => $node->id,
            'type' => $node->type,
            'direction' => $node->direction,
            'name' => $node->name,
            'slug' => $node->slug,
            'description' => $node->description,
            'children' => $children,
        ];
    }
}
