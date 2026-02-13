<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Scenario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class FamilyScenariosController extends Controller
{
    public function index(Family $family): JsonResponse
    {
        $this->authorize('viewAny', [Scenario::class, $family]);

        $scenarios = Scenario::query()
            ->where('family_id', $family->id)
            ->orderBy('start_date')
            ->get([
                'id',
                'family_id',
                'name',
                'start_date',
                'end_date',
                'status',
                'cloned_from_scenario_id',
                'created_by_user_id',
                'created_at',
            ]);

        return response()->json(['data' => $scenarios]);
    }

    public function store(Request $request, Family $family): JsonResponse
    {
        $this->authorize('create', [Scenario::class, $family]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'status' => ['sometimes', 'string', Rule::in([
                Scenario::STATUS_DRAFT,
                Scenario::STATUS_ACTIVE,
                Scenario::STATUS_ARCHIVED,
            ])],
        ]);

        $scenario = new Scenario();
        $scenario->family_id = $family->id;
        $scenario->name = $validated['name'];
        $scenario->start_date = Carbon::parse($validated['start_date'])->toDateString();
        $scenario->end_date = Carbon::parse($validated['end_date'])->toDateString();
        $scenario->status = $validated['status'] ?? Scenario::STATUS_DRAFT;
        $scenario->created_by_user_id = $request->user()?->id;
        $scenario->save();

        return response()->json([
            'data' => $scenario->only([
                'id',
                'family_id',
                'name',
                'start_date',
                'end_date',
                'status',
            ]),
        ], 201);
    }

    public function update(Request $request, Family $family, Scenario $scenario): JsonResponse
    {
        if ((string) $scenario->family_id !== (string) $family->id) {
            abort(404);
        }

        $this->authorize('update', $scenario);

        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:120'],
            'start_date' => ['sometimes', 'date'],
            'end_date' => ['sometimes', 'date'],
            'status' => ['sometimes', 'string', Rule::in([
                Scenario::STATUS_DRAFT,
                Scenario::STATUS_ACTIVE,
                Scenario::STATUS_ARCHIVED,
            ])],
        ]);

        if (array_key_exists('name', $validated)) {
            $scenario->name = $validated['name'];
        }

        if (array_key_exists('start_date', $validated)) {
            $scenario->start_date = Carbon::parse($validated['start_date'])->toDateString();
        }

        if (array_key_exists('end_date', $validated)) {
            $scenario->end_date = Carbon::parse($validated['end_date'])->toDateString();
        }

        if (array_key_exists('status', $validated)) {
            $scenario->status = $validated['status'];
        }

        // Se vierem ambos, garante coerência
        if ($scenario->start_date && $scenario->end_date) {
            if (Carbon::parse($scenario->end_date)->lt(Carbon::parse($scenario->start_date))) {
                return response()->json([
                    'message' => 'end_date deve ser >= start_date.',
                ], 422);
            }
        }

        $scenario->save();

        return response()->json([
            'data' => $scenario->fresh()->only([
                'id',
                'family_id',
                'name',
                'start_date',
                'end_date',
                'status',
            ]),
        ]);
    }

    public function destroy(Family $family, Scenario $scenario): JsonResponse
    {
        if ((string) $scenario->family_id !== (string) $family->id) {
            abort(404);
        }

        $this->authorize('delete', $scenario);

        $scenario->delete();

        return response()->json([], 204);
    }
}
