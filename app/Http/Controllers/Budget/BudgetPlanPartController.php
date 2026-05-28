<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;
use App\Models\BudgetPlanPart;
use App\Models\BudgetPlanSection;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BudgetPlanPartController extends Controller
{
    public function store(Request $request, BudgetPlanSection $section)
    {
        authPermission('responsable-suivi-evaluation|assistant-suivi-evaluation');

        // dd($request->all(), $section);
        $validated = $request->validate([
            'code' => 'required|string|max:10',
            'title' => 'required|string|max:255',
            'cost_total_project' => 'nullable|numeric|min:0',
            'commitments' => 'nullable|numeric|min:0',
            'details' => 'nullable|string',
            'cost_q1' => 'nullable|numeric|min:0',
            'cost_q2' => 'nullable|numeric|min:0',
            'cost_q3' => 'nullable|numeric|min:0',
            'cost_q4' => 'nullable|numeric|min:0',
            'chronogram_q1' => 'nullable|string|max:255',
            'chronogram_q2' => 'nullable|string|max:255',
            'chronogram_q3' => 'nullable|string|max:255',
            'chronogram_q4' => 'nullable|string|max:255',
            'comments' => 'nullable|string',
        ]);

        try {
            $total =
                ($request->input('cost_q1', 0) ?? 0) +
                ($request->input('cost_q2', 0) ?? 0) +
                ($request->input('cost_q3', 0) ?? 0) +
                ($request->input('cost_q4', 0) ?? 0);

            BudgetPlanPart::create([
                'budget_plan_section_id' => $section->id,
                'code' => $validated['code'],
                'title' => $validated['title'],
                'details' => $validated['details'] ?? null,
                'cost_total_project' => $validated['cost_total_project'] ?? 0,
                'commitments' => $validated['commitments'] ?? 0,
                'percent_commitments' => (
                    ((isset($validated['commitments']) && $validated['commitments'] != 0) && (isset($validated['cost_total_project']) && $validated['cost_total_project']))
                    ? (($validated['commitments'] ?? 0) / ($validated['cost_total_project'] ?? 1))
                    : 0
                ),
                'cost_q1' => $validated['cost_q1'] ?? 0,
                'cost_q2' => $validated['cost_q2'] ?? 0,
                'cost_q3' => $validated['cost_q3'] ?? 0,
                'cost_q4' => $validated['cost_q4'] ?? 0,
                'cost_total_year' => $total,
                'chronogram_q1' => $validated['chronogram_q1'] ?? null,
                'chronogram_q2' => $validated['chronogram_q2'] ?? null,
                'chronogram_q3' => $validated['chronogram_q3'] ?? null,
                'chronogram_q4' => $validated['chronogram_q4'] ?? null,
                'comments' => $validated['comments'] ?? null,
            ]);

            return response()->json([
                'message' => 'Volet ajouté avec succès.',
                'section' => $section,
            ]);
        } catch (Exception $e) {
            Log::error('Erreur lors de la création d\'une partie du budget : ' . $e->getMessage());

            return response()->json([
                'message' => 'Erreur lors de l\'ajout de la section.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function update(Request $request, BudgetPlanPart $part)
    {

        authPermission('responsable-suivi-evaluation|assistant-suivi-evaluation');

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'cost_total_project' => 'nullable|numeric',
            'commitments' => 'nullable|numeric',
            'details' => 'nullable|string',
            'cost_q1' => 'nullable|numeric',
            'cost_q2' => 'nullable|numeric',
            'cost_q3' => 'nullable|numeric',
            'cost_q4' => 'nullable|numeric',
            'cost_total_year' => 'nullable|numeric',
            'chronogram_q1' => 'nullable|string|max:255',
            'chronogram_q2' => 'nullable|string|max:255',
            'chronogram_q3' => 'nullable|string|max:255',
            'chronogram_q4' => 'nullable|string|max:255',
            'comments' => 'nullable|string',
        ]);

        $total =
            $request->input('cost_q1', $part->cost_q1) +
            $request->input('cost_q2', $part->cost_q2) +
            $request->input('cost_q3', $part->cost_q3) +
            $request->input('cost_q4', $part->cost_q4);

        $part->update([
            'cost_total_year' => $total,
            'title' => $validated['title'],
            'details' => $validated['details'] ?? $part->details,
            'cost_total_project' => $validated['cost_total_project'] ?? 0,
            'commitments' => $validated['commitments'] ?? 0,
            'percent_commitments' => (
                ((isset($validated['commitments']) && $validated['commitments'] != 0) && (isset($validated['cost_total_project']) && $validated['cost_total_project']))
                ? intval(($validated['commitments'] ?? 0) / ($validated['cost_total_project'] ?? 1) * 100)
                : 0
            ),
            'cost_q1' => $validated['cost_q1'] ?? $part->cost_q1,
            'cost_q2' => $validated['cost_q2'] ?? $part->cost_q2,
            'cost_q3' => $validated['cost_q3'] ?? $part->cost_q3,
            'cost_q4' => $validated['cost_q4'] ?? $part->cost_q4,
            'chronogram_q1' => $validated['chronogram_q1'] ?? $part->chronogram_q1,
            'chronogram_q2' => $validated['chronogram_q2'] ?? $part->chronogram_q2,
            'chronogram_q3' => $validated['chronogram_q3'] ?? $part->chronogram_q3,
            'chronogram_q4' => $validated['chronogram_q4'] ?? $part->chronogram_q4,
            'comments' => $validated['comments'] ?? $part->comments,
        ]);

        return response()->json([
            'message' => 'Volet mise à jour avec succès.',
            'part' => $part,
        ]);
    }

    public function update_total_execution(Request $request, BudgetPlanPart $part)
    {

        authPermission('responsable-suivi-evaluation|assistant-suivi-evaluation');

        $validated = $request->validate([
            'total_execution' => 'required|numeric',
        ]);

       
        $part->update([
           
            'total_execution' => $validated['total_execution'] ?? $part->total_execution,
        ]);

        return response()->json([
            'message' => 'Volet mise à jour avec succès.',
            'part' => $part,
        ]);
    }

    public function destroy(BudgetPlanPart $part)
    {

        authPermission('responsable-suivi-evaluation|assistant-suivi-evaluation');

        $part->delete();

        return response()->json([
            'message' => 'Volet supprimé avec succès.',
        ]);
    }
}
