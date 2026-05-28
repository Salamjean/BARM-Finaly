<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;
use App\Models\BudgetPlanActivity;
use App\Models\BudgetPlanSection;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BudgetPlanActivityController extends Controller
{
    public function store(Request $request, BudgetPlanSection $section)
    {
        authPermission('responsable-suivi-evaluation|assistant-suivi-evaluation');

        $validated = $request->validate([
            'code' => 'nullable|string|max:225',
            'title' => 'required|string|max:255',
            'p_objective_q1' => 'nullable|string|max:255',
            'p_objective_q2' => 'nullable|string|max:255',
            'p_objective_q3' => 'nullable|string|max:255',
            'p_objective_q4' => 'nullable|string|max:255',
            'p_objective_annual' => 'nullable|string|max:255',
            'execution_zone' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'ca_investment' => 'nullable|numeric|min:0',
            'ca_service' => 'nullable|numeric|min:0',
            'ca_transfer' => 'nullable|numeric|min:0',
            'ca_personal' => 'nullable|numeric|min:0',
            'ca_total' => 'nullable|numeric|min:0',
            'entity' => 'nullable|string|max:255',
            'observation' => 'nullable|string',
        ]);

        try {
            // Calculer le total automatiquement si non fourni
            $caTotal = $validated['ca_total'] ?? (
                ($validated['ca_investment'] ?? 0) +
                ($validated['ca_service'] ?? 0) +
                ($validated['ca_transfer'] ?? 0) +
                ($validated['ca_personal'] ?? 0)
            );

            BudgetPlanActivity::create([
                'budget_plan_section_id' => $section->id,
                'code' => $validated['code'] ?? null,
                'title' => $validated['title'],
                'p_objective_q1' => $validated['p_objective_q1'] ?? null,
                'p_objective_q2' => $validated['p_objective_q2'] ?? null,
                'p_objective_q3' => $validated['p_objective_q3'] ?? null,
                'p_objective_q4' => $validated['p_objective_q4'] ?? null,
                'p_objective_annual' => $validated['p_objective_annual'] ?? null,
                'execution_zone' => $validated['execution_zone'] ?? null,
                'company' => $validated['company'] ?? null,
                'ca_investment' => $validated['ca_investment'] ?? 0,
                'ca_service' => $validated['ca_service'] ?? 0,
                'ca_transfer' => $validated['ca_transfer'] ?? 0,
                'ca_personal' => $validated['ca_personal'] ?? 0,
                'ca_total' => $caTotal,
                'entity' => $validated['entity'] ?? null,
                'observation' => $validated['observation'] ?? null,
            ]);

            return response()->json([
                'message' => 'Activité ajoutée avec succès.',
                'section' => $section,
            ]);
        } catch (Exception $e) {
            Log::error('Erreur lors de la création d\'une activité du budget : ' . $e->getMessage());

            return response()->json([
                'message' => 'Erreur lors de l\'ajout de l\'activité.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, BudgetPlanActivity $activity)
    {
        authPermission('responsable-suivi-evaluation|assistant-suivi-evaluation');

        $validated = $request->validate([
            'code' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'p_objective_q1' => 'nullable|string|max:255',
            'p_objective_q2' => 'nullable|string|max:255',
            'p_objective_q3' => 'nullable|string|max:255',
            'p_objective_q4' => 'nullable|string|max:255',
            'p_objective_annual' => 'nullable|string|max:255',
            'execution_zone' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'ca_investment' => 'nullable|numeric|min:0',
            'ca_service' => 'nullable|numeric|min:0',
            'ca_transfer' => 'nullable|numeric|min:0',
            'ca_personal' => 'nullable|numeric|min:0',
            'ca_total' => 'nullable|numeric|min:0',
            'entity' => 'nullable|string|max:255',
            'observation' => 'nullable|string',
        ]);

        // Calculer le total automatiquement si non fourni
        $caTotal = $validated['ca_total'] ?? (
            ($request->input('ca_investment', $activity->ca_investment) ?? 0) +
            ($request->input('ca_service', $activity->ca_service) ?? 0) +
            ($request->input('ca_transfer', $activity->ca_transfer) ?? 0) +
            ($request->input('ca_personal', $activity->ca_personal) ?? 0)
        );

        try {
            $activity->update([
                'code' => $validated['code'] ?? $activity->code,
                'title' => $validated['title'],
                'p_objective_q1' => $validated['p_objective_q1'] ?? $activity->p_objective_q1,
                'p_objective_q2' => $validated['p_objective_q2'] ?? $activity->p_objective_q2,
                'p_objective_q3' => $validated['p_objective_q3'] ?? $activity->p_objective_q3,
                'p_objective_q4' => $validated['p_objective_q4'] ?? $activity->p_objective_q4,
                'p_objective_annual' => $validated['p_objective_annual'] ?? $activity->p_objective_annual,
                'execution_zone' => $validated['execution_zone'] ?? $activity->execution_zone,
                'company' => $validated['company'] ?? $activity->company,
                'ca_investment' => $validated['ca_investment'] ?? $activity->ca_investment,
                'ca_service' => $validated['ca_service'] ?? $activity->ca_service,
                'ca_transfer' => $validated['ca_transfer'] ?? $activity->ca_transfer,
                'ca_personal' => $validated['ca_personal'] ?? $activity->ca_personal,
                'ca_total' => $caTotal,
                'entity' => $validated['entity'] ?? $activity->entity,
                'observation' => $validated['observation'] ?? $activity->observation,
            ]);

            return response()->json([
                'message' => 'Activité mise à jour avec succès.',
                'activity' => $activity,
            ]);
        } catch (Exception $e) {
            Log::error('Erreur lors de la mise à jour d\'une activité du budget : ' . $e->getMessage());

            return response()->json([
                'message' => 'Erreur lors de la mise à jour de l\'activité.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(BudgetPlanActivity $activity)
    {
        authPermission('responsable-suivi-evaluation|assistant-suivi-evaluation');

        try {

            $activity->delete();

            return response()->json([
                'message' => 'Activité supprimée avec succès.',
            ]);
        } catch (Exception $e) {
            Log::error('Erreur lors de la suppression d\'une activité du budget : ' . $e->getMessage());

            return response()->json([
                'message' => 'Erreur lors de la suppression de l\'activité.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
