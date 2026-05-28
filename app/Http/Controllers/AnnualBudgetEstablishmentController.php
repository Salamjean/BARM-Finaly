<?php

namespace App\Http\Controllers;

use App\Http\Requests\Budget\AnnualBudgetEstablishmentRequest;
use App\Models\AnnualBudget;
use App\Models\AnnualBudgetEstablishment;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\Request;

class AnnualBudgetEstablishmentController extends Controller
{

    public function budget()
    {
        $budget = AnnualBudget::where('year', date('Y'))->first();
        if (!$budget)
            abort(404);
        return $budget;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $budget = $this->budget();
        $rolePermission = controllerPersonal();

        $step = '';
        $establishment = AnnualBudgetEstablishment::where('annual_budget_id', $budget->id)
            ->where('cell_id', $rolePermission->role->id)
            ->first();
        if (!$establishment)
            $step = 'create';
        else {
            if ($establishment->status == 'new')
                $step = 'new';
            if ($establishment->status == 'verification')
                $step = 'verification';
            if ($establishment->status == 'finished')
                $step = 'finished';
        }

        return view('dashboard.budget.establishment.index', compact('budget', 'establishment', 'step'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $budget = $this->budget();

        $rolePermission = controllerPersonal();

        $establishment = AnnualBudgetEstablishment::where('annual_budget_id', $budget->id)
            ->where('cell_id', $rolePermission->role->id)
            ->first();

        if ($establishment)
            return back()->with('error', 'Procédure de l\'etablissement du budget annuel en cours.');

        return view('dashboard.budget.establishment.create', compact('budget'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AnnualBudgetEstablishmentRequest $request)
    {

        $budget = $this->budget();

        // JOB PERSONAL (if chief)
        $rolePermission = controllerPersonal();

        $attrs = $request->except('_token', 'http');
        $attrs['elements'] = json_encode($attrs['elements']);
        $attrs += [
            'chief_id' => auth()->id(),
            'annual_budget_id' => $budget->id,
            'cell_id' => $rolePermission->role->id,
            'date' => date('Y-m-d'),
        ];

        if (AnnualBudgetEstablishment::where('annual_budget_id', $budget->id)
            ->where('cell_id', $rolePermission->role->id)
            ->exists()
        )
            return back()->with('error', 'Procédure de l\'etablissement du budget annuel en cours.');

        AnnualBudgetEstablishment::create($attrs);
        return to_route('annual-budget.establishment.index')->with('success', 'Le budget annuel de votre cellule a été transmis avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AnnualBudgetEstablishment $annualBudgetEstablishment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $this->budget();
        $annualBudgetEstablishment = AnnualBudgetEstablishment::findOrFail($id);
        if ($annualBudgetEstablishment->status != 'new')
            abort(404);

        return view('dashboard.budget.establishment.edit', ['establishment' => $annualBudgetEstablishment]);
    }

    public function edit2(int $id)
    {
        $this->budget();
        $annualBudgetEstablishment = AnnualBudgetEstablishment::findOrFail($id);
        if ($annualBudgetEstablishment->status != 'verification')
            abort(404);

        return view('dashboard.budget.establishment.edit2', ['establishment' => $annualBudgetEstablishment]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $this->budget();
        $attrs = $request->except('_token', 'http');
        $attrs['elements'] = json_encode($attrs['elements']);

        $annualBudgetEstablishment = AnnualBudgetEstablishment::findOrFail($id);
        if ($annualBudgetEstablishment->status != 'new')
            abort(404);

        $annualBudgetEstablishment->update($attrs);
        return back()->with('success', 'Le budget annuel de votre cellule a été modifié avec succès.');
    }

    /**
     * Update2 the specified resource in storage.
     */
    public function update2(Request $request, int $id)
    {
        $this->budget();
        $attrs = $request->except('_token', 'http');
        $attrs['elements'] = json_encode($attrs['elements']);

        $annualBudgetEstablishment = AnnualBudgetEstablishment::findOrFail($id);
        if ($annualBudgetEstablishment->status != 'verification')
            abort(404);

        $annualBudgetEstablishment->update($attrs);
        return to_route('annual-budget.show', AnnualBudget::where('year', date('Y'))->first())->with('success', 'Le budget annuel de la cellule a été modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnnualBudgetEstablishment $annualBudgetEstablishment)
    {
        //
    }


    public function status(int $id, string $status)
    {
        $this->budget();
        if ($status == 'verification') {
            $annualBudgetEstablishment = AnnualBudgetEstablishment::findOrFail($id);
            if ($annualBudgetEstablishment->status != 'new')
                abort(404);
            $annualBudgetEstablishment->status = $status;
            $annualBudgetEstablishment->save();
            return back()->with('success', 'Statut actualisé avec succès.');
        }


        if ($status == 'finished') {
            $annualBudgetEstablishment = AnnualBudgetEstablishment::findOrFail($id);
            if ($annualBudgetEstablishment->status != 'verification')
                abort(404);
            $annualBudgetEstablishment->status = $status;
            $annualBudgetEstablishment->save();
            return back()->with('success', 'Statut actualisé avec succès.');
        }

        abort(404);
    }
}
