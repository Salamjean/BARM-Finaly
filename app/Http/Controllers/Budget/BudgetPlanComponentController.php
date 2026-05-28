<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;
use App\Models\BudgetPlan;
use App\Models\BudgetPlanComponent;
use Illuminate\Http\Request;

class BudgetPlanComponentController extends Controller
{
    public function store(Request $request, BudgetPlan $budgetPlan)
    {

        authPermission('responsable-suivi-evaluation|assistant-suivi-evaluation');

        $request->validate([
            'code' => 'nullable|string|max:10',
            'title' => 'required|string|max:255',
            'amount' => 'nullable|numeric',
        ]);

        $budgetPlan->components()->create($request->only('code', 'title', 'amount'));

        return response()->json([
            'message' => 'Composante ajoutée avec succès.',
            'component' => $budgetPlan->components()->latest()->first(),
        ]);
    }

    public function update(Request $request, BudgetPlanComponent $component)
    {

        // dd($request->all());

        authPermission('responsable-suivi-evaluation|assistant-suivi-evaluation');

        $request->validate([
            'code' => 'nullable|string|max:10',
            'title' => 'required|string|max:255',
            'amount' => 'nullable|numeric',
        ]);

        $component->update($request->only('code', 'title', 'amount'));

        return response()->json([
            'message' => 'Composante mise à jour avec succès.',
        ]);
    }

    public function destroy(BudgetPlanComponent $component)
    {

        authPermission('responsable-suivi-evaluation|assistant-suivi-evaluation');

        $component->delete();

        return response()->json([
            'message' => 'Composante supprimée avec succès.',
        ]);
    }
}
