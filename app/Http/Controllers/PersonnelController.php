<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Personnel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class PersonnelController extends Controller
{
    public function __construct()
    {
        // $this->middleware('role:chef-barm|cellule-administration-finance-logistique');
    }

    public function authorized()
    {
        authPermission('responsable-des-systemes-de-l-information');
    }

    public function index()
    {
        $this->authorized();
        $personnels = Personnel::with('user')->where('status', '1')->get();
        return view('dashboard.manage_users.personnels.index', ['personnels' => $personnels]);
    }

    public function create()
    {
        $roles = Role::get();
        return view('dashboard.manage_users.personnels.create', [
            'roles' => $roles,
        ]);
    }

    public function store(Request $request)
    {

        $this->authorized();
        $messages = [
            'phone.required' => 'Le numéro de téléphone est obligatoire.',
            'firstname.required' => 'Le prénom est obligatoire.',
            'lastname.required' => 'Le nom est obligatoire.',
        ];

        $data = $request->validate([
            'phone' => 'required|unique:users,phone',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email',
            'type'  => ['required', 'in:civil,militaire'],
            'ville_barm' => 'nullable',
            'roles' => 'required|string',
            'permissions' => 'required|array',

        ], $messages);

        try {

            $password = generateRandomString(4);
            $username = strtoupper($data['firstname']) . " " . ucfirst(strtolower($data['lastname']));
            $user = User::create([
                'phone' => $data['phone'],
                'username' => $username,
                'lastname' => $data['lastname'],
                "firstname" => $data['firstname'],
                'email' => $data['email'],
                'password' => Hash::make($password),
                "created_by" => auth()->id(),
                'status' => '1',
            ]);
            Personnel::create([
                'user_id' => $user->id,
                "type" => $request->type,
                "ville_barm" => $data['ville_barm'] ?? null,
            ]);

            $role = Role::whereName($request->roles)->first();
            if ($role) {

                $user->roles()->sync($role->id);

                $permissions = [];

                foreach ($request->permissions as $key => $permissionName) {
                    $p = Permission::whereName($permissionName)->first();
                    if ($p)
                        $permissions[$key] = $p->id;
                }

                $user->permissions()->sync($permissions);
            }

            //send mail
            Mail::send('email.welcome_personal', ['user' => $user, 'password' => $password], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Code de confirmation');
            });

            return redirect()->route('personnel.index')->with('success', 'Personnel crée avec succès !');
        } catch (ValidationException $e) {
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde. Message d\'erreur : ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $personnel = Personnel::findOrFail($id);
        $user = User::findOrFail($personnel->user_id);
        $roles = Role::where('name', 'like', 'personnel%')->get();
        return view('dashboard.manage_users.personnels.show', [
            'roles' => $roles,
            'personnel' => $personnel,
            'user' => $user,
        ]);
    }

    public function edit($id)
    {
        $personnel = Personnel::findOrFail($id);

        return view('dashboard.manage_users.personnels.edit', [
            'personal' => $personnel,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->authorized();
        $personnel = Personnel::findOrFail($id);
        $user = User::findOrFail($personnel->user_id);
        $messages = [
            'phone.required' => 'Le numéro de téléphone est obligatoire.',
            'firstname.required' => 'Le prénom est obligatoire.',
            'lastname.required' => 'Le nom est obligatoire.',
        ];

        $data = $request->validate([
            'phone' => 'required|unique:users,phone,' . $user->id,
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'type'  => ['required', 'in:civil,militaire'],
            'ville_barm' => 'nullable',
            'roles' => 'required|string',
            'permissions' => 'required|array',

        ], $messages);

        try {

            $user->update([
                'phone' => $data['phone'],
                'lastname' => $data['lastname'],
                "firstname" => $data['firstname'],
                'email' => $data['email'],
                'updated_by' => auth()->id(),
            ]);

            $personnel->update([
                "type" => $request->type,
                "ville_barm" => $data['ville_barm'] ?? null,
            ]);

            if ($personnel->roles)
                $personnel->roles()->delete();

            if ($personnel->permissions)
                $personnel->permissions()->delete();

            $role = Role::whereName($request->roles)->first();
            if ($role) {

                $user->roles()->sync($role->id);

                $permissions = [];

                foreach ($request->permissions as $key => $permissionName) {
                    $p = Permission::whereName($permissionName)->first();
                    if ($p)
                        $permissions[$key] = $p->id;
                }

                $user->permissions()->sync($permissions);
            }
        } catch (ValidationException $e) {
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde. Message d\'erreur : ' . $e->getMessage());
        }

        return redirect()->route('personnel.index')->with('success', 'Personnel modifié avec succès !');
    }

    public function update_password(Request $request, $id)
    {
        $this->authorized();
        $request->validate([
            'password' => 'required|confirmed|min:4',
        ]);

        $personal = Personnel::findOrFail($id);
        $user = User::findOrFail($personal->user_id);

        $userData = ['password' => bcrypt($request->password)];

        $user->update($userData);

        return back()->with('success', 'Mot de passe modifié avec succès.');
    }

    public function lock_unlock($id)
    {
        $this->authorized();
        $personnel = Personnel::findOrFail($id);
        $user = User::findOrFail($personnel->user_id);
        $user->update(['status' => $user->status == '1' ? '0' : '1']);

        return redirect()->route('personnel.index')->with('success', 'Personnel ' . ($personnel->status == '1' ? 'débloqué' : 'bloqué') . ' avec succès!');
    }

    public function destroy($id)
    {
        $this->authorized();
        $personnel = Personnel::findOrFail($id);
        $user = User::findOrFail($personnel->user_id);
        $personnel->update(['status' => '0']);
        $user->update(['status' => '0']);

        return redirect()->route('personnel.index')->with('success', 'Personnel supprimé !');
    }

    public function PersonelLeaveList()
    {
        $title = 'Liste des demandes';
        $leaves = Leave::orderBy('created_at', 'desc')->get();

        return view('rh.demande.list_demande', compact('leaves', 'title'));
    }

    public function editPersonnelLeave($id)
    {
        $title = 'Edition des demandes';
        $leaves = Leave::where('id', $id)->first();

        return view('rh.demande.request_demande', compact('leaves', 'title'));
    }

    public function updatePersonnelLeave(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'id' => 'required|max:200',
            'status' => 'required|max:100',
            'comment' => 'max:255',
        ]);


        $id = $request->id;
        $status = $request->status;
        $comment = mb_strtoupper($request->comment);


        $leaves = Leave::where('id', $id)->update([
            'status' => $status,
            'comment' => $comment
        ]);

        return redirect()->route('demande.PersonelLeave')->with('success', 'Ces informations ont été enregistré avec succès !');
    }

    public function Personelindex()
    {
        $title = 'Liste du personnel';
        $pers = Personnel::orderBy('created_at', 'desc')->get();

        return view('rh.attestation.list', compact('pers', 'title'));
    }

    public function attestationPdf($id)
    {
        $title = 'Attestation de travail';
        $personnels = Personnel::findOrFail($id);
        $pdf = PDF::loadView('dashboard.administration.pdf.travail', compact('title', 'personnels'));

        return $pdf->download('attestation_travail_' . str_replace(' ', '_', $personnels->user->firstname) . '.pdf');
    }
    public function postPdf($id)
    {
        $title = 'Attestation de présence';
        $personnels = Personnel::findOrFail($id);
        $pdf = PDF::loadView('dashboard.administration.pdf.poste', compact('title', 'personnels'));

        return $pdf->download('attestation_presence_' . str_replace(' ', '_', $personnels->user->firstname) . '.pdf');
    }

    public function attestationCongePdf($id)
    {
        $title = 'Attestation de congé';
        $personnels = Personnel::findOrFail($id);
        $pdf = PDF::loadView('dashboard.administration.pdf.attestation_conge', compact('title', 'personnels'));

        $filename == 'attestation_conge_' . str_replace(' ', '_', $personnels->user->fullaName()) . '.pdf';
        return $pdf->download($filename);
    }

    public function demandeCongePdf($id)
    {
        $title = 'Demande de permission';
        $leaves = Leave::where('id', $id)->first();
        $personnels = Personnel::where('id', $leaves->id)->get();
        $pdf = PDF::loadView('dashboard.administration.pdf.conge', compact('title', 'leaves', 'personnels'));

        $PDFname = 'demande_conge_' . str_replace(' ', '_', $leaves->user->firstname) . '.pdf';

        return $pdf->download($PDFname);
    }


    public function leavefilter(Request $request)
    {

        $title = 'Liste des demandes';
        $request->validate([
            'sendDate' => 'required|date_format:Y-m-d',
            'leaveType' => 'required',
        ]);

        $date = $request->input('sendDate');
        $type = $request->input('leaveType');
        $filteredData = Leave::whereDate('created_at', $date)
            ->where('leave_type', $type)
            ->get();

        return view('rh.demande.list_demande', ['leaves' => $filteredData, 'title' => $title]);
    }

    public function delete($id)
    {
        // Suppression douce de l'utilisateur
        $personnel = Personnel::findOrFail($id);
        $user = User::findOrFail($personnel->user_id);
        $user->update(['status' => '0']);

        $user->delete();
        $personnel->delete();

        $message = 'Personnel supprimé!';

        return redirect()->route('personnel.index')->with('success', $message);
    }

    public function createDeath()
    {
        $personals = Personnel::orderByDESC('created_at')->get();

        return view('dashboard.manage_users.personnels.death', ['personals' => $personals]);
    }

    public function death(Request $request)
    {
        $personal = Personnel::findOrFail($request->personal_id);
        $attrs = $request->validate([
            'death_date' => 'required|date_format:Y-m-d',
            'death_no_act' => 'required',
            'death_city' => 'required',
            'death_justification' => 'required|string',
        ]);

        $attrs['death'] = '1';

        $personal->update($attrs);

        $this->delete($personal->id);

        return redirect()->route('personnel.index')->with('success', 'Statut modifié avec succès.');
    }
}
