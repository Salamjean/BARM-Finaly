<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdController extends Controller
{
    public function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $ads = (new SettingRepository('ad'))->index();
        return view('dashboard.setting.ad.index', compact('ads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.setting.ad.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attrs = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'images' => 'required|array',
        ]);

        $message = (new SettingRepository('ad'))->store($attrs);

        return to_route('ad.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ad $ad)
    {
        return view('dashboard.setting.ad.show', compact('ad'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ad $ad)
    {
        return view('dashboard.setting.ad.edit', compact('ad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ad $ad)
    {
        $attrs = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'images' => 'nullable|array',
        ]);

        $message = (new SettingRepository('ad'))->update($attrs, $ad->id);

        return to_route('ad.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ad $ad)
    {
        foreach ($ad->images as $key => $image) {
            if (File::exists($image->image))
                File::delete($image->image);
            $image->delete();
        }
        $ad->delete();
        return to_route('ad.index')->with('success', MESSAGES['ad']['delete']);
    }
}
