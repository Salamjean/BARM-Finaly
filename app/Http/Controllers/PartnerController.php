<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PartnerController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partners = (new SettingRepository('partner'))->index();
        return view('dashboard.setting.partner.index', compact('partners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.setting.partner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attrs = $request->validate([
            'name' => 'required|string',
            'image' => 'required|image',
        ]);

        $message = (new SettingRepository('partner'))->store($attrs);

        return to_route('partner.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Partner $partner)
    {
        return view('dashboard.setting.partner.show', compact('partner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Partner $partner)
    {
        return view('dashboard.setting.partner.edit', compact('partner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partner $partner)
    {
        $attrs = $request->validate([
            'name' => 'required|string',
            'image' => 'nullable|image',
        ]);

        $message = (new SettingRepository('partner'))->update($attrs, $partner->id);

        return to_route('partner.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partner $partner)
    {
        if (File::exists($partner->image))
            File::delete($partner->image);
        $partner->delete();
        return to_route('partner.index')->with('success', MESSAGES['partner']['delete']);
    }
}
