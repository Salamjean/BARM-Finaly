<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;
use App\Models\BudgetPlanSection;
use App\Models\BudgetPlanSubComponent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BudgetPlanSectionController extends Controller
{
    public function store(Request $request, BudgetPlanSubComponent $subComponent)
    {

        authPermission('responsable-suivi-evaluation|assistant-suivi-evaluation');

        $validated = $request->validate([
            'code' => 'nullable|string|max:10',
            'title' => 'required|string|max:255',
        ]);

        try {
            $section = $subComponent->sections()->create($validated);

            return response()->json([
                'message' => 'Section ajoutée avec succès.',
                'section' => $subComponent->sections()->latest()->first(),
            ]);

        } catch (Exception $e) {

            Log::info($e->getMessage());

            return response()->json([
                'message' => 'Erreur lors de l\'ajout de la section.',
                'error' => $e->getMessage(),
            ], 500);

        }
    }

    public function update(Request $request, BudgetPlanSection $section)
    {

        authPermission('responsable-suivi-evaluation|assistant-suivi-evaluation');

        $validated = $request->validate([
            'code' => 'nullable|string|max:10',
            'title' => 'required|string|max:255',
        ]);

        $section->update($validated);

        return response()->json([
            'message' => 'Section mise à jour avec succès.',
            'section' => $section,
        ]);
    }

    public function destroy(BudgetPlanSection $section)
    {

        authPermission('responsable-suivi-evaluation|assistant-suivi-evaluation');

        $section->delete();

        return response()->json([
            'message' => 'Section supprimée avec succès.',
        ]);
    }
}
