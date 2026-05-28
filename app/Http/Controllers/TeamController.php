<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TeamController extends Controller
{
    public function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = (new SettingRepository('team'))->index();
        return view('dashboard.setting.team.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.setting.team.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attrs = $request->validate([
            'name' => 'required|string',
            'job' => 'required|string',
            'image' => 'required|image',
            'link_fb' => 'nullable|string',
            'link_x' => 'nullable|string',
            'link_linkedin' => 'nullable|string',
            'link_insta' => 'nullable|string',
        ]);

        $message = (new SettingRepository('team'))->store($attrs);

        return to_route('team.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        return view('dashboard.setting.team.show', compact('team'));
    }

    public function chief(string $id)
    {
        $teamm = (new SettingRepository('team'))->find($id);
        $teams = (new SettingRepository('team'))->index();

        if ($teamm->personal == 'personal') {
            foreach ($teams as $team)
                $team->update(['personal' => 'personal']);
            $teamm->personal = 'dg';
            $teamm->save();
            return to_route('team.show', $teamm->id)->with('success', MESSAGES['team']['chief']);
        } else {
            foreach ($teams as $team)
                $team->update(['personal' => 'personal']);
            return to_route('team.show', $teamm->id)->with('success', MESSAGES['team']['personal']);
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        return view('dashboard.setting.team.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        $attrs = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
            'link_fb' => 'nullable|string',
            'link_x' => 'nullable|string',
            'link_linkedin' => 'nullable|string',
            'link_insta' => 'nullable|string',
        ]);

        $message = (new SettingRepository('team'))->update($attrs, $team->id);

        return to_route('team.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        if (File::exists($team->image))
            File::delete($team->image);
        $team->delete();
        return to_route('team.index')->with('success', MESSAGES['team']['delete']);
    }
}
