<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\PersonalBarm;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PersonalBarmController extends Controller
{
    public function __construct()
    {
        // $this->middleware('role:chef-barm|cellule-administration-finance-logistique');
    }

    public function index()
    {
        $personals = PersonalBarm::all();
        return view('dashboard.personalbarm.index', ['personals' => $personals]);
    }

    public function createPersonnelMilitaire()
    {
        return view('dashboard.personalbarm.create.militaire', [
        ]);
    }
    public function createPersonnelCivil()
    {
        return view('dashboard.personalbarm.create.civil', [
        ]);
    }

    public function store(Request $request)
    {

        $messages = [
            'mecano.required_if' => 'Le numéro mecano est obligatoire pour le personnel militaire.',
            'mecano.unique' => 'Ce numéro mecano est déjà utilisé.',
            'phone.required' => 'Le numéro de téléphone est obligatoire.',
            'firstname.required' => 'Le prénom est obligatoire.',
            'lastname.required' => 'Le nom est obligatoire.',
        ];


        $data = $request->validate([
            'phone' => 'required|unique:personal_barms,phone',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:personal_barms,email',
            'birth_date' => 'required|date',
            'lieu_naissance' => 'required',
            'grade' => 'required',
            'type'  => ['required', 'in:civil,militaire'],
            'matricule_barm' => 'nullable|unique:personal_barms,matricule_barm',
            'matricule_fae' => 'nullable|unique:personal_barms,matricule_fae',
            'mecano' => ['required_if:type,militaire', 'unique:personal_barms,mecano'],
            'ville_barm' => 'nullable',
            'nbre_enfant' => 'required',
            'date_etabli' => 'required',
            'lieu_etabli' => 'required',
            'date_validate' => 'required',
            'nationalite' => 'required',
            'no_card' => 'required',
            'no_cim' => 'required',
            'group_sanguin' => 'required',
            'lieu_residence' => 'required',
            'date_prise_service' => 'required',
            'diplome_militaire' => 'required_if:type,militaire',
            'diplome_eleve' => 'required',
            'derniere_formation' => 'nullable',
            'lieu_formation' => 'nullable',
            'annee_formation' => 'nullable',
            'statut_personnel' => 'required',
            'nom_cas_urgence' => 'required',
            'telephone_cas_urgence' => 'required',
            'roles' => 'required|string',
            'permissions' => 'required|array',

        ], $messages);


        try {

            $username = strtoupper($data['firstname']) . " " . ucfirst(strtolower($data['lastname']));

            $personnel = PersonalBarm::create([
                "type" => $request->type,
                'mecano' => $request->mecano ?? null,
                'phone' => $data['phone'],
                'username' => $username,
                'lastname' => $data['lastname'],
                "firstname" => $data['firstname'],
                'email' => $data['email'],
                "birth_date" => $data['birth_date'],
                "lieu_naissance" => $data['lieu_naissance'],
                "nationalite" => $data['nationalite'],
                "no_card" => $data['no_card'],
                "date_etabli" => $data['date_etabli'],
                "lieu_etabli" => $data['lieu_etabli'],
                "date_validate" => $data['date_validate'],
                "no_cim" => $data['no_cim'],
                "grade" => $request->grade ??  null,
                "matricule_barm" => $request->matricule_barm ?? null,
                "ville_barm" => $data['ville_barm'] ?? null,
                "matricule_fae" => $request->matricule_fae ?? null,
                "date_prise_service_barm" => $data['date_prise_service'],
                "diplome_militaire" => $request->diplome_militaire ?? null,
                "diplome_civil_eleve" => $data['diplome_eleve'],
                "lieu_formation" => $request->lieu_formation ?? null,
                "derniere_formation" => $request->derniere_formation ?? null,
                "annee_de_formation" => $request->annee_formation ?? null,
                "nbre_enfant" => $data['nbre_enfant'],
                "groupe_sanguin" => $data['group_sanguin'],
                "lieu_residence" => $data['lieu_residence'],
                "statut_personnel" => $data['statut_personnel'],
                "nom_cas_urgence" => $data['nom_cas_urgence'],
                "telephone_cas_urgence" => $data['telephone_cas_urgence'],
                "decorations" => $request->decoration ? json_encode($request->decoration) : null,
                "cell" => $request->roles,
                "posts" => json_encode($request->permissions),

            ]);

            return redirect()->route('personalbarm.index')->with('success', 'Personnel crée avec succès !');
        } catch (\Throwable $e) {
            dd($e);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function show($id)
    {
        $personal = PersonalBarm::findOrFail($id);
        return view('dashboard.personalbarm.show', [
            'personal' => $personal,
        ]);
    }

    public function edit($id)
    {
        $personal = PersonalBarm::findOrFail($id);

        if ($personal->type == 'civil')
            return view('dashboard.personalbarm.edit.civil', [
                'personal' => $personal,
            ]);
        else
            return view('dashboard.personalbarm.edit.militaire', [
                'personal' => $personal,
            ]);
    }

    public function update(Request $request, $id)
    {
        $personal = PersonalBarm::findOrFail($id);
        $messages = [
            'mecano.required_if' => 'Le numéro mecano est obligatoire pour le personnel militaire.',
            'mecano.unique' => 'Ce numéro mecano est déjà utilisé.',
            'phone.required' => 'Le numéro de téléphone est obligatoire.',
            'firstname.required' => 'Le prénom est obligatoire.',
            'lastname.required' => 'Le nom est obligatoire.',
        ];
        $data = $request->validate([
            'phone' => 'required|unique:personal_barms,phone,' . $personal->id,
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => "required|email|unique:personal_barms,email," . $personal->id,
            'birth_date' => 'required|date',
            'lieu_naissance' => 'required',
            'grade' => 'required_if:type,militaire',
            'type'  => ['required', 'in:civil,militaire'],
            'matricule_barm' => 'required|unique:personal_barms,matricule_barm,' . $personal->id,
            'matricule_fae' => ['required_if:type,civil'],
            'matricule' => ['nullable:type,militaire'],
            'mecano' => ['required_if:type,militaire', 'unique:personal_barms,mecano,' . $personal->id],
            'nbre_enfant' => 'required',
            'date_etabli' => 'required',
            'lieu_etabli' => 'required',
            'date_validate' => 'required',
            'nationalite' => 'required',
            'no_card' => 'required',
            'no_cim' => 'required',
            'group_sanguin' => 'required',
            'lieu_residence' => 'required',
            'date_prise_service' => 'required',
            'diplome_militaire' => 'required_if:type,militaire',
            'diplome_eleve' => 'required',
            'derniere_formation' => 'nullable',
            'lieu_formation' => 'nullable',
            'annee_formation' => 'nullable',
            'statut_personnel' => 'required',
            'nom_cas_urgence' => 'required',
            'telephone_cas_urgence' => 'required',
            'roles' => 'required|string',
            'permissions' => 'required|array',
            'status' => 'nullable|in:on'
        ], $messages);


        try {

            $personal->update([
                'mecano' => $request->mecano,
                'phone' => $data['phone'],
                'lastname' => $data['lastname'],
                "firstname" => $data['firstname'],
                'email' => $data['email'],
                "birth_date" => $data['birth_date'],
                "lieu_naissance" => $data['lieu_naissance'],
                "nationalite" => $data['nationalite'],
                "no_card" => $data['no_card'],
                "date_etabli" => $data['date_etabli'],
                "lieu_etabli" => $data['lieu_etabli'],
                "date_validate" => $data['date_validate'],
                "no_cim" => $data['no_cim'],
                "grade" => $request->grade ?? null,
                "matricule" => $request->matricule ?? null,
                "matricule_fae" => $request->matricule_fae ?? null,
                "date_prise_service_barm" => $data['date_prise_service'],
                "diplome_militaire" => $request->diplome_militaire ?? null,
                "diplome_civil_eleve" => $data['diplome_eleve'],
                "lieu_formation" => $request->lieu_formation ?? null,
                "derniere_formation" => $request->derniere_formation ?? null,
                "annee_de_formation" => $request->annee_formation ?? null,
                "nbre_enfant" => $data['nbre_enfant'],
                "groupe_sanguin" => $data['group_sanguin'],
                "lieu_residence" => $data['lieu_residence'],
                "statut_personnel" => $data['statut_personnel'],
                "nom_cas_urgence" => $data['nom_cas_urgence'],
                "telephone_cas_urgence" => $data['telephone_cas_urgence'],
                "decorations" => $request->decoration ? json_encode($request->decoration) : null,
                "cell" => $request->roles,
                "posts" => json_encode($request->permissions),
            ]);


        } catch (\Throwable $e) {
            dd($e);
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            dd($e);
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde. Message d\'erreur : ' . $e->getMessage());
        }

        return redirect()->route('personalbarm.index')->with('success', 'Personnel modifié avec succès !');
    }

    public function destroy($id)
    {
        $personnel = PersonalBarm::findOrFail($id);
        $personnel->delete();

        return redirect()->route('personalbarm.index')->with('success', 'Personnel supprimé !');
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
        $pers = PersonalBarm::orderBy('created_at', 'desc')->get();

        return view('rh.attestation.list', compact('pers', 'title'));
    }

    public function attestationPdf($id)
    {
        $title = 'Attestation de travail';
        $personnels = PersonalBarm::findOrFail($id);
        $pdf = PDF::loadView('dashboard.administration.pdf.travail', compact('title', 'personnels'));

        return $pdf->download('attestation_travail_' . str_replace(' ', '_', $personnels->firstname) . '.pdf');
    }
    public function postPdf($id)
    {
        $title = 'Attestation de présence';
        $personnels = PersonalBarm::findOrFail($id);
        $pdf = PDF::loadView('dashboard.administration.pdf.poste', compact('title', 'personnels'));

        return $pdf->download('attestation_presence_' . str_replace(' ', '_', $personnels->firstname) . '.pdf');
    }

    public function attestationCongePdf($id)
    {
        $title = 'Attestation de congé';
        $personnels = PersonalBarm::findOrFail($id);
        $pdf = PDF::loadView('dashboard.administration.pdf.attestation_conge', compact('title', 'personnels'));

        $filename = 'attestation_conge_' . str_replace(' ', '_', $personnels->fullaName()) . '.pdf';
        return $pdf->download($filename);
    }

    public function demandeCongePdf($id)
    {
        $title = 'Demande de permission';
        $leaves = Leave::where('id', $id)->first();
        $personnels = PersonalBarm::where('id', $leaves->id)->get();
        $pdf = PDF::loadView('dashboard.administration.pdf.conge', compact('title', 'leaves', 'personnels'));

        $PDFname = 'demande_conge_' . str_replace(' ', '_', $leaves->firstname) . '.pdf';

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
        $personnel = PersonalBarm::findOrFail($id);

        $personnel->delete();

        $message = 'Personnel supprimé!';

        return redirect()->route('personalbarm.index')->with('success', $message);
    }

    public function createDeath()
    {
        $personals = PersonalBarm::orderByDESC('created_at')->get();

        return view('dashboard.personalbarm.death', ['personals' => $personals]);
    }

    public function death(Request $request)
    {
        $personal = PersonalBarm::findOrFail($request->personal_id);
        $attrs = $request->validate([
            'death_date' => 'required|date_format:Y-m-d',
            'death_no_act' => 'required',
            'death_city' => 'required',
            'death_justification' => 'required|string',
        ]);

        $attrs['death'] = '1';

        $personal->update($attrs);

        $this->delete($personal->id);

        return redirect()->route('personalbarm.index')->with('success', 'Statut modifié avec succès.');
    }
}
