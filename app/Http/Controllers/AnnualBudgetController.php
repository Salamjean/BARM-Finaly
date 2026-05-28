<?php

namespace App\Http\Controllers;

use App\Http\Requests\Budget\AnnualBudgetRequest;
use App\Models\AnnualBudget;
use Illuminate\Http\Request;

class AnnualBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.budget.index', ['budgets' => AnnualBudget::latest()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.budget.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AnnualBudgetRequest $request)
    {
        if (AnnualBudget::where('year', date('Y'))->exists())
            return back()->with('error', 'Budget annuel déjà établit.');
        $attrs = $request->except('_token', 'http');
        $attrs += [
            'personal_id' => auth()->id(),
            'year' => date('Y'),
            'date' => date('Y-m-d'),
        ];

        AnnualBudget::create($attrs);
        return to_route('annual-budget.index')->with('success', 'Budget annuel ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AnnualBudget $annualBudget)
    {
        return view('dashboard.budget.show', ['budget' => $annualBudget]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AnnualBudget $annualBudget)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AnnualBudget $annualBudget)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnnualBudget $annualBudget)
    {
        //
    }

    public function status(int $id, string $status)
    {

        $budget = AnnualBudget::findOrFail($id);
        if ($status == 'negotiation') {
            $budget->status = 'negotiation';
            $msg = 'Droit d’écriture activé';

            $status = 'verification';
        }
        if ($status == 'finished') {
            $budget->status = 'finished';
            $msg = "Budget annuel de l’année $budget->year terminer avec succès.";

            $status = 'finished';
        }

        foreach($budget->budgetByCell as $cell)
            $cell->update(['status' => $status]);

        $budget->save();

        return back()->with('success', $msg);
    }
}
