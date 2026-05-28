<?php

namespace App\Http\Controllers;

use App\Models\BudgetPlan;
use Illuminate\Http\Request;

class BudgetPlanMonitoringController extends Controller
{
    public function index()
    {
        authPermission('responsable-suivi-evaluation|assistant-suivi-evaluation|chef-barm|c2d');
        $budgetPlans = BudgetPlan::where('type', 'c2d')->get();
        return view('dashboard.budget-plans.monitoring.index', compact('budgetPlans'));
    }

    public function show(BudgetPlan $budgetPlan)
    {
        authPermission('responsable-suivi-evaluation|assistant-suivi-evaluation|chef-barm|c2d');

        $components = $budgetPlan->components()->with('subComponents.sections')->get();
        return view('dashboard.budget-plans.monitoring.show', compact('budgetPlan', 'components'));
    }
}
