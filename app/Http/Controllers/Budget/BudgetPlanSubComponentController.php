<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;
use App\Models\BudgetPlanComponent;
use App\Models\BudgetPlanSubComponent;
use Illuminate\Http\Request;

class BudgetPlanSubComponentController extends Controller
{
    public function store(Request $request, BudgetPlanComponent $component)
    {

        authPermission('responsable-suivi-evaluation|assistant-suivi-evaluation');

        $request->validate([
            'code' => 'nullable|string|max:10',
            'title' => 'required|string|max:255',
            'amount' => 'nullable|numeric',
        ]);

        $component->subComponents()->create($request->only('code', 'title', 'amount'));

        return response()->json([
            'message' => 'Sous-composante ajoutée avec succès.',
            'subComponent' => $component->subComponents()->latest()->first(),
        ]);

    }

    public function update(Request $request, BudgetPlanSubComponent $subComponent)
    {

        authPermission('responsable-suivi-evaluation|assistant-suivi-evaluation');

        $request->validate([
            'code' => 'nullable|string|max:10',
            'title' => 'required|string|max:255',
            'amount' => 'nullable|numeric',
        ]);

        $subComponent->update($request->only('code', 'title', 'amount'));

        return response()->json([
            'message' => 'Sous-composante mise à jour avec succès.',
        ]);

    }

    public function destroy(BudgetPlanSubComponent $subComponent)
    {
        
        authPermission('responsable-suivi-evaluation|assistant-suivi-evaluation');

        $subComponent->delete();

        return response()->json([
            'message' => 'Sous-composante supprimée avec succès.',
        ]);

    }
}
