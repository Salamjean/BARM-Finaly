<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;
use App\Models\BudgetPlan;
use Illuminate\Http\Request;

class BudgetPlanController extends Controller
{
    public function index()
    {
        authPermission('responsable-suivi-evaluation|assistant-suivi-evaluation|chef-barm|c2d|memdef');
        if(can('responsable-suivi-evaluation|assistant-suivi-evaluation|chef-barm')){
            $budgetPlans = BudgetPlan::all();
        }elseif(can('c2d')){
            $budgetPlans = BudgetPlan::where('type', 'c2d')->get();
        }elseif(can('memdef')){
            $budgetPlans = BudgetPlan::where('type', 'memdef')->get();
        }
        return view('dashboard.budget-plans.index', compact('budgetPlans'));
    }

    public function create()
    {
        authPermission('responsable-suivi-evaluation|assistant-suivi-evaluation');
        return view('dashboard.budget-plans.create');
    }

    public function store(Request $request)
    {
        authPermission('responsable-suivi-evaluation|assistant-suivi-evaluation');
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:c2d,memdef',
            'year' => 'required|numeric',
            'conversion_xof' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        BudgetPlan::create($request->only('name', 'year', 'description', 'conversion_xof', 'type'));

        return redirect()->route('budget-plans.index')->with('success', 'Plan budgétaire créé avec succès.');
    }

    public function show(BudgetPlan $budgetPlan)
    {
        authPermission('responsable-suivi-evaluation|assistant-suivi-evaluation|chef-barm|c2d|memdef');

        $components = $budgetPlan->components()->with('subComponents.sections')->get();
        return view('dashboard.budget-plans.show', compact('budgetPlan', 'components'));
    }

    public function edit(BudgetPlan $budgetPlan)
    {
        authPermission('responsable-suivi-evaluation|assistant-suivi-evaluation');

        return view('dashboard.budget-plans.edit', compact('budgetPlan'));
    }

    public function update(Request $request, BudgetPlan $budgetPlan)
    {

        authPermission('responsable-suivi-evaluation|assistant-suivi-evaluation');

        $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|numeric',
            'conversion_xof' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $budgetPlan->update($request->only('name', 'year', 'description', 'conversion_xof'));

        return redirect()->route('budget-plans.index')->with('success', 'Plan budgétaire mis à jour avec succès.');
    }

    public function destroy(BudgetPlan $budgetPlan)
    {

        authPermission('responsable-suivi-evaluation|assistant-suivi-evaluation');
        
        $budgetPlan->delete();

        return redirect()->route('budget-plans.index')->with('success', 'Plan budgétaire supprimé avec succès.');
    }
}
