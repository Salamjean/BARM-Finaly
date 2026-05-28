<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
        $users = User::all();
        return view('dashboard.manage_users.users.index', ['users' => $users]);
    }

    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('dashboard.manage_users.users.create', [
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'roles' => 'array',
            'permissions' => 'array',
        ]);

        $user = User::create([
            'username' => $request->username,
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }
        if ($request->has('permissions')) {
            $user->permissions()->sync($request->permissions);
        }

        return redirect()->route('users.index')->with('success', 'Utilisateur enregistré avec succès !');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('dashboard.manage_users.users.show', ['user' => $user]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $permissions = Permission::all();
        return view('dashboard.manage_users.users.edit', [
            'permissions' => $permissions,
            'roles' => $roles,
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'roles' => 'array',
            'permissions' => 'array',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => ($request->password) ? Hash::make($request->password) : $user->password,
        ]);

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }

        if ($request->has('permissions')) {
            $user->permissions()->sync($request->permissions);
        }

        return redirect()->route('users.index')->with('success', 'Utilisateur modifié avec succès !');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé !');
    }
}
