<?php

namespace App\Http\Controllers;

use App\Repositories\SettingRepository;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        authPermission('admin');

        $settings = (new SettingRepository('setting'))->index();
        return view('dashboard.setting.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        authPermission('admin');
        $settings = (new SettingRepository('setting'))->index();
        return view('dashboard.setting.edit', compact('settings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        authPermission('admin');

        $attrs = $request->validate([
            'app_name' => 'required|string',
            'app_fullname' => 'required|string',
            'app_logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'app_url' => 'required|string',
            'app_address' => 'required|string',
            'app_map' => 'required|string',
            'app_phone' => 'required|string',
            'app_mail' => 'required|string',
            'meta_title' => 'required|string',
            'meta_description' => 'required|string',
            'meta_url' => 'required|string',
            'app_pointing_start_from' => 'required|date_format:H:i',
            'app_pointing_end_to' => 'required|date_format:H:i',
            'tawk_to' => 'nullable|string',
            'meta_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $message = (new SettingRepository('setting'))->store($attrs);

        return to_route('setting.index')->with('success', $message);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
