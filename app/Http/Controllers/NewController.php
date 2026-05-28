<?php

namespace App\Http\Controllers;

use App\Models\NewsCast;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class NewController extends Controller
{
    public function __construct()
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = (new SettingRepository('new'))->index();
        return view('dashboard.setting.new.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.setting.new.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attrs = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'required|image',
        ]);

        $message = (new SettingRepository('new'))->store($attrs);

        return to_route('new.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(NewsCast $new)
    {
        return view('dashboard.setting.new.show', compact('new'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NewsCast $new)
    {
        return view('dashboard.setting.new.edit', compact('new'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NewsCast $new)
    {
        $attrs = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
        ]);

        $message = (new SettingRepository('new'))->update($attrs, $new->id);

        return to_route('new.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsCast $new)
    {
        if (File::exists($new->image))
            File::delete($new->image);
        $new->delete();
        return to_route('new.index')->with('success', MESSAGES['new']['delete']);
    }
}
