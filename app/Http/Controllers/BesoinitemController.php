<?php

namespace App\Http\Controllers;

use App\Http\Requests\BesoinitemStoreRequest;
use App\Http\Requests\BesoinitemUpdateRequest;
use App\Models\Besoinitem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BesoinitemController extends Controller
{
    public function index(Request $request): Response
    {
        $besoinitems = Besoinitem::all();

        return view('besoinitem.index', compact('besoinitems'));
    }

    public function create(Request $request): Response
    {
        return view('besoinitem.create');
    }

    public function store(BesoinitemStoreRequest $request): Response
    {
        $besoinitem = Besoinitem::create($request->validated());

        $request->session()->flash('besoinitem.id', $besoinitem->id);

        return redirect()->route('besoinitems.index');
    }

    public function show(Request $request, Besoinitem $besoinitem): Response
    {
        return view('besoinitem.show', compact('besoinitem'));
    }

    public function edit(Request $request, Besoinitem $besoinitem): Response
    {
        return view('besoinitem.edit', compact('besoinitem'));
    }

    public function update(BesoinitemUpdateRequest $request, Besoinitem $besoinitem): Response
    {
        $besoinitem->update($request->validated());

        $request->session()->flash('besoinitem.id', $besoinitem->id);

        return redirect()->route('besoinitems.index');
    }

    public function destroy(Request $request, Besoinitem $besoinitem): Response
    {
        $besoinitem->delete();

        return redirect()->route('besoinitems.index');
    }
}
