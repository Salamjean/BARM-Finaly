<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Permission;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function listRole()
    {
        $roles = Role::where('status', '1')->get();
        return view('dashboard.manage_users.roles.list', ['roles' => $roles]);
    }

    public function createRole()
    {
        $permissions = Permission::where('status', '1')->get();
        return view('dashboard.manage_users.roles.create', ['permissions' => $permissions]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);
        $role = Role::create([
            'name' => $request->name,
        ]);
        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }
        if ($role) {
            return redirect()->route('role.index')->with('success', 'Role ajouté avec succès !');
        }
    }

    public function show($slug)
    {
        $role = Role::where('slug', $slug)->firstOrFail();
        return view('dashboard.manage_users.roles.show', ['role' => $role]);
    }
    public function edit($slug)
    {
        $role = Role::where('slug', $slug)->firstOrFail();
        $permissions = Permission::where('status', '1')->get();
        return view('dashboard.manage_users.roles.edit', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    public function update(Request $request, $slug)
    {
        $role = Role::where('slug', $slug)->firstOrFail();

        $request->validate([
            'name' => 'required|unique:roles,name,' .$role->id,
        ]);

        $role->update(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }
        return redirect()->route('role.index')->with('success', 'Role mise à jour avec succès.');
    }

    public function destroy($slug)
    {
        $role = Role::where('slug', $slug)->firstOrFail();
        $role->delete();
        $role->permissions()->delete();

        return redirect()->route('role.index')->with('success', 'Role supprimé avec succès.');
    }
}
