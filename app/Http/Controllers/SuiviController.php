<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuiviStoreRequest;
use App\Http\Requests\SuiviUpdateRequest;
use App\Models\Suivi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuiviController extends Controller
{
    public function index(Request $request): Response
    {
        $suivis = Suivi::all();

        return view('suivi.index', compact('suivis'));
    }

    public function create(Request $request): Response
    {
        return view('suivi.create');
    }

    public function store(SuiviStoreRequest $request): Response
    {
        $suivi = Suivi::create($request->validated());

        $request->session()->flash('suivi.id', $suivi->id);

        return redirect()->route('suivis.index');
    }

    public function show(Request $request, Suivi $suivi): Response
    {
        return view('suivi.show', compact('suivi'));
    }

    public function edit(Request $request, Suivi $suivi): Response
    {
        return view('suivi.edit', compact('suivi'));
    }

    public function update(SuiviUpdateRequest $request, Suivi $suivi): Response
    {
        $suivi->update($request->validated());

        $request->session()->flash('suivi.id', $suivi->id);

        return redirect()->route('suivis.index');
    }

    public function destroy(Request $request, Suivi $suivi): Response
    {
        $suivi->delete();

        return redirect()->route('suivis.index');
    }
}
