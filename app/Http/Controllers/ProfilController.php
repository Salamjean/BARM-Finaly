<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        $user = User::all();

        return view('dashboard.profil.securite', compact('user', 'roles'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $roles = Role::all();
        // $user = User::all();
        // return view('dashboard.profil.create',compact('roles','user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $user = User::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $roles = Role::all();
        $user = Auth::user();

        return view('dashboard.profil.edit', compact('user', 'roles'));
    }


    public function update(Request $request, string $type )
    {

        $user = Auth::user();

        if ($type == 'info')

            $request->validate([
                'username' => 'nullable|max:255',
                'firstname' => 'nullable|max:255',
                'lastname' => 'nullable|max:255',
                'email' => 'nullable|email|unique:users,email,' . $user->id,
                'phone' => 'required|max:10|min:10',
            ]);

        elseif ($type == 'password')
            $request->validate([
                'password' => 'required|min:4',
            ]);

        else
            return back()->with('error', 'Code d\erreur 401');


        if ($type == 'info')
            $userData = [
                'username' => $request->username ?? $user->username,
                'firstname' => $request->firstname ?? $user->firstname,
                'lastname' => $request->lastname ?? $user->lastname,
                // 'phone' => $request->phone,
                'email' => $request->email ?? $user->email,
            ];

        elseif ($type == 'password')
            $userData = [
                'password' => bcrypt($request->password),
            ];

        $user->update($userData);

        return redirect()->route('profil.edit', Auth::user()->id)->with('success', 'Profil mis à jour avec succès.');
    }

    public function destroy(string $id)
    {
        //
    }
}
