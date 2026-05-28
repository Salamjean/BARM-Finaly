<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }
    public function index()
    {
        $permissions = Permission::where('status', '1')->get();
        return view('dashboard.manage_users.permissions.index', ['permissions' => $permissions]);
    }

    public function create()
    {
        $permissions = Permission::where('status', '1')->get();
        return view('dashboard.manage_users.permissions.create', ['permissions' => $permissions]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,'
        ]);
        $permission = Permission::create([
            'name' => $request->name,
        ]);
        if ($permission) {
            return redirect()->route('permissions.index')->with('success', 'Permission ajouté avec succès !');
        }
    }

    public function show($slug)
    {
        $permission = Permission::where('slug', $slug)->firstOrFail();
        return view('dashboard.manage_users.permissions.show', ['permission' => $permission]);
    }
    public function edit($slug)
    {
        $permission = Permission::where('slug', $slug)->firstOrFail();
        return view('dashboard.manage_users.permissions.edit', ['permission' => $permission]);
    }

    public function update(Request $request, $slug)
    {
        $permission = Permission::where('slug', $slug)->firstOrFail();

        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->slug,
        ]);

        $permission->update(['name' => $request->name]);

        return redirect()->route('permissions.index')->with('success', 'Permission mise à jour avec succès.');
    }

    public function destroy($slug)
    {
        $permission = Permission::where('slug', $slug)->firstOrFail();
        $permission->delete();

        return redirect()->route('permissions.index')->with('success', 'Permission supprimé avec succès.');
    }
}
