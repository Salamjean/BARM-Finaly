<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Partenaire;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class PartenaireController extends Controller
{
    public function __construct()
    {

    }

    public function authorized()
    {
        authPermission('responsable-des-systemes-de-l-information');
    }

    public function index()
    {
        $this->authorized();
        $partenaires = Partenaire::with('user')->where('status', '1')->get();
        return view('dashboard.manage_users.partenaires.index', ['partenaires' => $partenaires]);
    }
    public function create()
    {
        $roles = Role::where('name', 'like', 'partner%')->get();
        return view('dashboard.manage_users.partenaires.create', [
            'roles' => $roles,
        ]);
    }
    public function store(Request $request)
    {
        
        $this->authorized();
        $request->validate([
            'username' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:255|unique:users,phone',
            'permissions' => 'required|array',
        ]);

        try {
            $password = generateRandomString(4);

            $user = User::create([
                'username' => strtoupper($request->username),
                'lastname' => $request->lastname ?? ' ',
                'firstname' => $request->firstname ?? ' ',
                'email' => $request->email,
                'password' => Hash::make($password),
                "created_by" => auth()->id(),
            ]);
            Partenaire::create([
                'user_id' => $user->id,
                'phone_number' => $request->phone,
                'address' => $request->address,
            ]);

            $role = Role::whereName('PARTNER')->first();

            $user->roles()->sync($role->id);

            $permissions = [];

            foreach ($request->permissions as $key => $permissionName) {
                $p = Permission::whereName($permissionName)->first();
                if($p)
                    $permissions[$key] = $p->id;
            }

            $user->permissions()->sync($permissions);

            //send mail
            Mail::send('email.welcome_partner', ['user' => $user, 'password' => $password], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Code de confirmation');
            });

            return redirect()->route('partenaire.index')->with('success', 'Partenaire crée avec succès !');

        } catch (ValidationException $e) {
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde. Message d\'erreur : ' . $e->getMessage());
        }

    }

    public function show($id)
    {
        $partenaire = Partenaire::findOrFail($id);
        $user = User::findOrFail($partenaire->user_id);
        $roles = Role::where('name', 'like', 'partner%')->get();
        return view('dashboard.manage_users.partenaires.show', [
            'roles' => $roles,
            'partenaire' => $partenaire,
            'user' => $user,
        ]);
    }

    public function edit($id)
    {
        $partenaire = Partenaire::findOrFail($id);
        $user = User::findOrFail($partenaire->user_id);
        $roles = Role::where('name', 'like', 'partner%')->get();
        return view('dashboard.manage_users.partenaires.edit', [
            'roles' => $roles,
            'partenaire' => $partenaire,
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->authorized();
        $partenaire = Partenaire::findOrFail($id);
        $user = User::findOrFail($partenaire->user_id);

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:255|unique:users,phone,' . $user->id,
            'password' => 'nullable|confirmed|min:4',
            'permissions' => 'required|array',
        ]);

        $user->update([
            'lastname' => $request->lastname ?? ' ',
            'firstname' => $request->firstname ?? ' ',
            'phone' => $request->phone,
            'email' => $request->email,
            'updated_by' => auth()->id(),
        ]);

        $partenaire->update([
            'phone_number' => $request->phone,
            'address' => $request->address,
        ]);

        if ($partenaire->roles)
            $partenaire->roles()->delete();

        if ($partenaire->permissions)
            $partenaire->permissions()->delete();
        
        $role = Role::whereName('PARTNER')->first();

        $user->roles()->sync($role->id);

        $permissions = [];

        foreach ($request->permissions as $key => $permissionName) {
            $p = Permission::whereName($permissionName)->first();
            if ($p)
                $permissions[$key] = $p->id;
        }

        $user->permissions()->sync($permissions);

        return redirect()->route('partenaire.index')->with('success', 'partenaire modifié avec succès !');
    }

    public function update_password(Request $request, $id)
    {
        $this->authorized();
        $request->validate([
            'password' => 'required|confirmed|min:4',
        ]);

        $partenaire = Partenaire::findOrFail($id);
        $user = User::findOrFail($partenaire->user_id);

        if ($request->password)
            $userData = ['password' => bcrypt($request->password)];

        $user->update($userData);

        return back()->with('success', 'Mot de passe modifié avec succès.');
    }

    public function lock_unlock($id)
    {
        $this->authorized();
        $partenaire = Partenaire::findOrFail($id);
        $user = User::findOrFail($partenaire->user_id);

        $user->update(['status' => $user->status == '1' ? '0' : '1']);

        return redirect()->route('partenaire.index')->with('success', 'Partenaire ' . ($user->status == '1' ? 'débloqué' : 'bloqué') . ' avec succès!');
    }

    public function destroy($id)
    {
        $this->authorized();
        $partenaire = Partenaire::findOrFail($id);
        $user = User::findOrFail($partenaire->user_id);
        $partenaire->update(['status' => '0']);
        $user->update(['status' => '0']);

        return redirect()->route('partenaire.index')->with('success', 'Partenaire supprimé !');
    }
}
