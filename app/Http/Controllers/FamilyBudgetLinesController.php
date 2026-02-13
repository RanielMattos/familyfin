<?php

namespace App\Http\Controllers;

use App\Models\BudgetLine;
use App\Models\Family;
use App\Models\Scenario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class FamilyBudgetLinesController extends Controller
{
    public function index(Family $family, Scenario $scenario): JsonResponse
    {
        if ((string) $scenario->family_id !== (string) $family->id) {
            abort(404);
        }

        $this->authorize('viewAny', [BudgetLine::class, $scenario]);

        $lines = BudgetLine::query()
            ->where('scenario_id', $scenario->id)
            ->orderBy('direction')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get([
                'id',
                'family_id',
                'scenario_id',
                'direction',
                'group_node_id',
                'category_node_id',
                'subcategory_node_id',
                'name',
                'nature',
                'visibility',
                'is_active',
                'slug',
                'sort_order',
            ]);

        return response()->json(['data' => $lines]);
    }

    public function store(Request $request, Family $family, Scenario $scenario): JsonResponse
    {
        if ((string) $scenario->family_id !== (string) $family->id) {
            abort(404);
        }

        $this->authorize('create', [BudgetLine::class, $scenario]);

        $validated = $request->validate([
            'direction' => ['required', 'string', Rule::in([BudgetLine::DIR_INCOME, BudgetLine::DIR_EXPENSE])],
            'name' => ['required', 'string', 'max:140'],
            'nature' => ['sometimes', 'string', Rule::in([BudgetLine::NATURE_FIXED, BudgetLine::NATURE_VARIABLE, BudgetLine::NATURE_ONE_OFF])],
            'visibility' => ['sometimes', 'string', Rule::in([BudgetLine::VIS_FAMILY, BudgetLine::VIS_ADULTS, BudgetLine::VIS_OWNER])],
            'group_node_id' => ['nullable', 'string'],
            'category_node_id' => ['nullable', 'string'],
            'subcategory_node_id' => ['nullable', 'string'],
            'sort_order' => ['sometimes', 'integer', 'min:0'],
        ]);

        $baseSlug = Str::slug($validated['name']);
        $slug = $this->uniqueSlugForScenarioDirection(
            scenarioId: (string) $scenario->id,
            direction: $validated['direction'],
            baseSlug: $baseSlug
        );

        $line = new BudgetLine();
        $line->family_id = $family->id;
        $line->scenario_id = $scenario->id;
        $line->direction = $validated['direction'];
        $line->name = $validated['name'];
        $line->nature = $validated['nature'] ?? BudgetLine::NATURE_FIXED;
        $line->visibility = $validated['visibility'] ?? BudgetLine::VIS_FAMILY;
        $line->group_node_id = $validated['group_node_id'] ?? null;
        $line->category_node_id = $validated['category_node_id'] ?? null;
        $line->subcategory_node_id = $validated['subcategory_node_id'] ?? null;
        $line->sort_order = $validated['sort_order'] ?? 0;
        $line->slug = $slug;
        $line->is_active = true;
        $line->save();

        return response()->json([
            'data' => $line->only([
                'id',
                'family_id',
                'scenario_id',
                'direction',
                'name',
                'nature',
                'visibility',
                'is_active',
                'slug',
                'sort_order',
            ]),
        ], 201);
    }

    public function update(Request $request, Family $family, Scenario $scenario, BudgetLine $line): JsonResponse
    {
        if ((string) $scenario->family_id !== (string) $family->id) {
            abort(404);
        }

        if ((string) $line->scenario_id !== (string) $scenario->id || (string) $line->family_id !== (string) $family->id) {
            abort(404);
        }

        $this->authorize('update', $line);

        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:140'],
            'nature' => ['sometimes', 'string', Rule::in([BudgetLine::NATURE_FIXED, BudgetLine::NATURE_VARIABLE, BudgetLine::NATURE_ONE_OFF])],
            'visibility' => ['sometimes', 'string', Rule::in([BudgetLine::VIS_FAMILY, BudgetLine::VIS_ADULTS, BudgetLine::VIS_OWNER])],
            'group_node_id' => ['nullable', 'string'],
            'category_node_id' => ['nullable', 'string'],
            'subcategory_node_id' => ['nullable', 'string'],
            'sort_order' => ['sometimes', 'integer', 'min:0'],
        ]);

        if (array_key_exists('name', $validated)) {
            $baseSlug = Str::slug($validated['name']);
            $slug = $this->uniqueSlugForScenarioDirection(
                scenarioId: (string) $scenario->id,
                direction: (string) $line->direction,
                baseSlug: $baseSlug,
                ignoreLineId: (string) $line->id
            );

            $line->name = $validated['name'];
            $line->slug = $slug;
        }

        if (array_key_exists('nature', $validated)) {
            $line->nature = $validated['nature'];
        }

        if (array_key_exists('visibility', $validated)) {
            $line->visibility = $validated['visibility'];
        }

        if (array_key_exists('group_node_id', $validated)) {
            $line->group_node_id = $validated['group_node_id'];
        }

        if (array_key_exists('category_node_id', $validated)) {
            $line->category_node_id = $validated['category_node_id'];
        }

        if (array_key_exists('subcategory_node_id', $validated)) {
            $line->subcategory_node_id = $validated['subcategory_node_id'];
        }

        if (array_key_exists('sort_order', $validated)) {
            $line->sort_order = (int) $validated['sort_order'];
        }

        $line->save();

        return response()->json([
            'data' => $line->fresh()->only([
                'id',
                'family_id',
                'scenario_id',
                'direction',
                'name',
                'nature',
                'visibility',
                'is_active',
                'slug',
                'sort_order',
            ]),
        ]);
    }

    public function destroy(Family $family, Scenario $scenario, BudgetLine $line): JsonResponse
    {
        if ((string) $scenario->family_id !== (string) $family->id) {
            abort(404);
        }

        if ((string) $line->scenario_id !== (string) $scenario->id || (string) $line->family_id !== (string) $family->id) {
            abort(404);
        }

        $this->authorize('delete', $line);

        if ($line->entries()->exists()) {
            return response()->json([
                'message' => 'Não é possível remover esta linha porque ela possui lançamentos (entries) vinculados.',
            ], 422);
        }

        $line->delete();

        return response()->json([], 204);
    }

    public function toggleActive(Family $family, Scenario $scenario, BudgetLine $line): JsonResponse
    {
        if ((string) $scenario->family_id !== (string) $family->id) {
            abort(404);
        }

        if ((string) $line->scenario_id !== (string) $scenario->id || (string) $line->family_id !== (string) $family->id) {
            abort(404);
        }

        $this->authorize('update', $line);

        $line->is_active = ! (bool) $line->is_active;
        $line->save();

        return response()->json([
            'data' => $line->fresh()->only([
                'id',
                'is_active',
            ]),
        ]);
    }

    private function uniqueSlugForScenarioDirection(string $scenarioId, string $direction, string $baseSlug, ?string $ignoreLineId = null): string
    {
        $slug = $baseSlug;
        $i = 1;

        while (
            BudgetLine::query()
                ->where('scenario_id', $scenarioId)
                ->where('direction', $direction)
                ->when($ignoreLineId, fn ($q) => $q->where('id', '!=', $ignoreLineId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $i++;
            $slug = "{$baseSlug}-{$i}";
        }

        return $slug;
    }
}
