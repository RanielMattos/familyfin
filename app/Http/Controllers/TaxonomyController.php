<?php

namespace App\Http\Controllers;

use App\Models\TaxonomyNode;
use Illuminate\Http\JsonResponse;

class TaxonomyController extends Controller
{
    /**
     * Retorna taxonomia GLOBAL em formato de árvore:
     * [
     *   { id, type, direction, name, slug, description, children: [ ... ] }
     * ]
     */
    public function index(): JsonResponse
    {
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
