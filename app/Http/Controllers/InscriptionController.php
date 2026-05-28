<?php

namespace App\Http\Controllers;

use Throwable;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Region;
use App\Models\Retired;
use App\Models\Village;
use App\Models\Department;
use App\Models\Partenaire;
use App\Models\Candidature;
use App\Models\JobCandidate;
use Illuminate\Http\Request;
use App\Models\ChildCandidate;
use App\Models\DiplomaCandidate;
use App\Models\CandidatureControl;
use App\Models\CandidaturePartenaire;
use App\Models\ChoiceFinalAdherent;
use App\Models\PersonalBarm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class InscriptionController extends Controller
{

    public function retiredSearch()
    {
        $retired = Retired::where('mecano', $_GET['search'])->first();

        if (!$retired)
            return response()->json([
                'message' => 'Retraité non enregistré dans la base de données',
                'status' => 'error',
            ]);

        if ($retired->used === 'yes')
            return response()->json([
                'message' => 'Retraité déjà adhérent',
                'status' => 'warning',
            ]);

        $twoYearsAgo = Carbon::now()->subYears(2);
        if (Carbon::parse($retired->retired_date)->lt($twoYearsAgo) && !$retired->forced_authorization)
            return response()->json([
                'message' => "La date de retraite de M/Mme $retired->firstname $retired->lastname est dépassée de deux ans.\nDate: " . dateFr($retired->retired_date) . '.',
                'status' => 'warning',
            ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Retraité trouvé',
            'data' => $retired,
        ]);
    }

    public function list()
    {
        $title = 'Liste des adhérents';

        $city = Auth::user()->personnel->ville_barm;

        if (Auth::user()->roles->first()->name == 'POINTS FOCAUX') {
            $submissions = Candidature::whereHas('createdBy.personnel', function ($query) use ($city) {
                $query->where('ville_barm', $city);
            })->orderByDESC('created_at')->where('resignation', '0')->where('death', '0')->whereStep('completed')->get();
        } else {
            $submissions = Candidature::orderByDESC('created_at')->where('resignation', '0')->where('death', '0')->whereStep('completed')->get();
        }


        return view('dashboard.adherent.list', ['title' => $title, 'submissions' => $submissions]);
    }

    public function pending_cohort()
    {

        $title = 'Adherents en attente d\'adhesion dans une cohorte';

        if (Auth::user()->roles->first()->name == 'POINTS FOCAUX') {
            $candidatures = Candidature::whereHas('createdBy.personnel', function ($query) {
                $query->where('ville_barm', '=', Auth::user()->personnel->ville_barm);
            })->orderByDESC('created_at')->where('resignation', '0')->where('death', '0')->where('orientation', 'auto-emploi')->where('cohort_id', null)->whereStep('completed')->get();
        } else {
            $candidatures = Candidature::orderByDESC('created_at')->where(
                'cohort_id',
                null
            )->whereStep('completed')->where('resignation', '0')->where('death', '0')->where('orientation', 'auto-emploi')->get();
        }


        return view('dashboard.adherent.list', ['submissions' => $candidatures, 'title' => $title]);
    }

    public function show(int $id)
    {
        $title = 'Détail du profil';
        $user = User::findOrFail($id);

        $localisation = $user->candidate->affectation;

        $pointfocals = PersonalBarm::where('ville_barm', $localisation)->get();

        // if ($user->candidate->orientation == 'fonction-publique'){
        //     $users = User::where('ville_barm', $localisation)->get();
        //     $pointfocal = PersonalBarm::where('ville_barm', $localisation)->get();
        // } elseif($user->candidate->orientation == 'entreprise-privee') {
        //     $localisation = $user->candidate->affectation;
        // }

        // dd($user->candidate);
        //     "accident_maladie" => "Aucun"
        // "maladie_supp" => null
        // "demarche_nature" => null
        // "demarche_admin" => null
        // "etat_avancement" => null
        // "indication" => null


        return view('dashboard.adherent.show    ', ['title' => $title, 'user' => $user, 'pointfocals' => $pointfocals]);
    }

    /**
     * Get adherent data for AJAX requests (to avoid memory issues)
     */
    public function getAdherentData(int $id)
    {
        $candidature = Candidature::with(['user:id,firstname,lastname,mecano'])
            ->where('user_id', $id)
            ->first();

        if (!$candidature) {
            return response()->json(['error' => 'Adhérent non trouvé'], 404);
        }

        return response()->json($candidature);
    }

    public function edit(int $id)
    {
        authPermission('chef-cellule-formation-et-insertion|conseiller-auto-emploi|conseiller-entreprise-prive|conseiller-fonction-public');

        $title = 'Edition du profil';
        $user = User::findOrFail($id);

        return view('dashboard.adherent.edit    ', ['title' => $title, 'user' => $user]);
    }


    public function updatePasswordProfile(Request $request, $id)
    {
        $request->validate([
            'password' => 'nullable|confirmed|min:4',
            'status' => 'nullable|in:on'
        ]);

        Session::flash('step', "password");

        $user = User::findOrFail($id);
        if ($request->password)
            $userData = ['password' => bcrypt($request->password)];
        if ($request->status && $request->status == 'on')
            $userData += ['status' => '1'];
        else
            $userData += ['status' => '0'];

        $user->update($userData);

        return back()->with('success', 'Données modifiées avec succès.');
    }

    public function steps()
    {
        $title = 'Candidature en cours';
        if (Auth::user()->roles->first()->name == 'POINTS FOCAUX') {
            $submissions = Candidature::whereHas('createdBy.personnel', function ($query) {
                $query->where('ville_barm', Auth::user()->personnel->ville_barm);
            })->orderByDESC('created_at')->where('resignation', '0')->where('death', '0')->where('step', '!=', 'completed')->where('step', '!=', 'pending')->get();
        } else {
            $submissions = Candidature::orderByDESC('created_at')->where('resignation', '0')->where('death', '0')->where('step', '!=', 'completed')->where('step', '!=', 'pending')->get();
        }



        return view('dashboard.adherent.pending', ['title' => $title, 'submissions' => $submissions]);
    }

    public function pending()
    {
        $title = 'Candidature en attente d\'approbation';

        if (Auth::user()->roles->first()->name == 'POINTS FOCAUX') {
            $submissions = Candidature::whereHas('createdBy.personnel', function ($query) {
                $query->where('ville_barm', Auth::user()->personnel->ville_barm);
            })->orderByDESC('created_at')->where('resignation', '0')->where('death', '0')->where('step', 'pending')->get();
        } elseif (in_array('chef-cellule-formation-et-insertion', userPermissions())) {
            $submissions = Candidature::orderByDESC('created_at')->where('resignation', '0')->where('death', '0')->where('step', 'pending')->get();
        } else {

            $submissions = collect();

            if (in_array('conseiller-auto-emploi', userPermissions())) {
                $autoEmploiSubmissions = Candidature::orderByDESC('created_at')->where('orientation', 'auto-emploi')->where('resignation', '0')->where('death', '0')->where('step', 'pending')->get();
                $submissions = $submissions->merge($autoEmploiSubmissions);
            }

            if (in_array('conseiller-fonction-public', userPermissions())) {
                $fonctionPubliqueSubmissions = Candidature::orderByDESC('created_at')->where('orientation', 'fonction-publique')->where('resignation', '0')->where('death', '0')->where('step', 'pending')->get();
                $submissions = $submissions->merge($fonctionPubliqueSubmissions);
            }

            if (in_array('conseiller-entreprise-prive', userPermissions())) {
                $entreprisePriveeSubmissions = Candidature::orderByDESC('created_at')->where('orientation', 'entreprise-privee')->where('resignation', '0')->where('death', '0')->where('step', 'pending')->get();
                $submissions = $submissions->merge($entreprisePriveeSubmissions);
            }
        }

        return view('dashboard.adherent.pending', ['title' => $title, 'submissions' => $submissions]);
    }

    public function approved(int $id)
    {
        $user = User::findOrFail($id);
        $can = Candidature::whereUserId($user->id)->first();

        $can->completed_by = auth()->id();
        $can->completed_at = date('Y-m-d H:i:s');
        $can->step = 'completed';
        $can->save();

        if ($can->orientation == 'auto-emploi')
            return to_route('cohort.index');
        else
            return to_route('adherent.choice.final', $user->id);
    }

    public function stepPersonal(string $step, int $id)
    {
        $title = 'Formulaire de Candidature';
        $user = User::findOrFail($id);
        $submission = Candidature::whereUserId($user->id)->first();

        if ($submission->step < $step)
            return to_route('inscription.create');

        return view('dashboard.adherent.add_candidate', ['title' => $title, 'user' => $user, 'submission' => $submission, 'step' => $step]);
    }

    public function createPersonal()
    {
        $title = 'Inscription du candidat';
        $step = 1;

        return view('dashboard.adherent.add_candidate', ['title' => $title, 'step' => $step]);
    }



    public function updatePersonal(Request $request, string $step, int $id)
    {
        if ($id == 0 && $step == 1) {
            // dd($request->all());
            $attrs = $request->validate([
                'cgrae_no' => 'nullable|string|min:11|unique:candidatures,cgrae_no',
                'image' => 'nullable|mimetypes:image/png,image/jpeg,image/jpg|max:1024',
                'first_name' => 'required|string|min:2',
                'last_name' => 'required|string|min:2',
                'phone_number' => 'required|string|size:10|unique:candidatures,phone_number',
                'phone_number2' => 'nullable|string',
                'phone_number3' => 'nullable|string',
                'sos_person_fullname' => 'nullable|string',
                'sos_person_phone_number' => 'nullable|string',
                'sos_person_phone_number2' => 'nullable|string',
                'mecano' => 'required|string|unique:users,mecano',
                // 'matricule' => 'required|string|unique:users,matricule',
                'type_piece' => 'required|string',
                'no_card' => 'required|string|unique:candidatures,no_card',
                'email' => 'nullable|email|unique:users,email',
                'birth_date' => 'required|date',
                'gender' => 'required|string',
                'ethnic' => 'nullable|string',
                'religion' => 'nullable|string',
            ]);

            $password = generateRandomString(4);

            $retired = Retired::where('mecano', $attrs['mecano'])->first();

            if (!$retired)
                return back()->with('error', 'Mecano ou Matricule non existant dans la base de données.');

            if ($retired->used)
                return back()->with('warning', 'Retraité déjà adhérent.');

            $twoYearsAgo = Carbon::now()->subYears(2);
            $messageError = '';

            if (Auth::user()->roles->first()->slug == 'points-focaux')
                $messageError = "La date de retraite du retraité est depassé de deux ans.\nVeuillez contacter un conseiller à Abidjan.";

            if (Auth::user()->roles->first()->slug == 'cellule-formation-et-insertion')
                $messageError = "La date de retraite du retraité est depassé de deux ans.";

            if (Carbon::parse($retired->retired_date)->lt($twoYearsAgo) && !$retired->forced_authorization)
                return back()->with('warning', $messageError);

            //image file
            $image = null;
            if (isset($attrs['image'])) {

                $image = time() . '.' . $attrs['image']->getClientOriginalExtension();
                $attrs['image']->move(saveByEnv() . "data/docs/photo/", $image);
                $image =  'data/docs/photo/' . $image;
            }

            // Create new user
            $user = User::create([
                'mecano' => $attrs['mecano'],
                'matricule' => $retired->matricule,
                'email' => $attrs['email'] ?? null,
                'username' => strtoupper($attrs['last_name']) . " " . ucfirst(strtolower($attrs['first_name'])),
                'lastname' => strtoupper($attrs['last_name']),
                'firstname' => ucfirst(strtolower($attrs['first_name'])),
                'password' => Hash::make($password),
                'status' => '1',
                'created_by' => auth()->id(),
            ]);

            // Create new submission
            $candidature = Candidature::create([
                'date_radiation' => $retired->retired_date,
                'condition_admin' => $retired->retired_type,
                'unite_rattachement' => $retired->unit,
                'armee' => $retired->army,
                'grade' => $retired->grade,

                'user_id' => $user->id,
                'created_by' => auth()->id(),

                'phone_number' => $attrs['phone_number'],
                'cgrae_no' => $request->cgrae_no,
                'image' => $image,
                'type_piece' => $attrs['type_piece'],
                'no_card' => $attrs['no_card'],
                'birth_date' => $attrs['birth_date'],
                'gender' => $attrs['gender'],
                'ethnic' => $attrs['ethnic'],
                'religion' => $attrs['religion'],

                'phone_number2' => $request->phone_number2,
                'phone_number3' => $request->phone_number3,
                'sos_person_fullname' => $request->sos_person_fullname,
                'sos_person_phone_number' => $request->sos_person_phone_number,
                'sos_person_phone_number2' => $request->sos_person_phone_number2,

                'step' => '2',
            ]);

            //control
            CandidatureControl::create([
                'user_id' => auth()->id(),
                'adherent_id' => $candidature->id,
                'type' => 'created',
                'table' => 'candidatures'
            ]);

            //update retired
            $retired->used = true;
            $retired->save();

            //role assignment
            $role = Role::whereName('CANDIDAT')->first();
            $user->roles()->sync([$role->id]);

            $permissions = [];
            foreach ($role->permissions as $key => $can)
                $permissions[$key] = $can->id;

            foreach ($permissions as $perm)
                $user->permissions()->sync([$perm]);

            //send mail
            // if (isset($attrs['email']))
            //     Mail::send('email.welcome_adherent', ['user' => $user, 'submission' => $submission, 'password' => $password], function ($message) use ($attrs) {
            //         $message->to($attrs['email']);
            //         $message->subject('Code de confirmation');
            //     });

            //SMS
            $message = "Bienvenue chez BARM. Votre inscription a été validée.";
            // (new SmsRepository($submission->phone_number, $message))->send();

            return to_route('adherent.step', [2, $user->id])->with('success', MESSAGES['client']['store']);
        }

        $user = User::find($id);

        $can = Candidature::whereUserId($user->id)->first();

        if (!$can || $can->step < $step)
            return to_route('adherent.create')->with('error', 'Error 403');

        if ($step == 1) {

            $attrs = $request->validate([
                'cgrae_no' => 'nullable|string|min:11',
                'image' => 'nullable|mimetypes:image/png,image/jpeg,image/jpg|max:1024',
                'first_name' => 'required|string|min:2',
                'last_name' => 'required|string|min:2',
                'phone_number' => 'required|string|size:10',
                'type_piece' => 'required|string',
                'no_card' => 'required|string',
                'email' => 'nullable|email|unique:users,email,' . $id,
                'birth_date' => 'required|date',
                'gender' => 'required|string',
                'ethnic' => 'nullable|string',
                'religion' => 'nullable|string',
            ]);

            $image = $can->image;
            if (isset($attrs['image'])) {
                if (File::exists($can->image))
                    File::delete($can->image);

                $image = time() . '.' . $attrs['image']->getClientOriginalExtension();
                $attrs['image']->move(saveByEnv() . "data/docs/photo/", $image);
                $image = 'data/docs/photo/' . $image;
            }

            // Update new user
            $user->update([
                'email' => $attrs['email'] ?? null,
                'username' => strtoupper($attrs['last_name']) . " " . ucfirst(strtolower($attrs['first_name'])),
                'lastname' => strtoupper($attrs['last_name']),
                'firstname' => ucfirst(strtolower($attrs['first_name'])),
                'updated_by' => auth()->id(),

            ]);

            // Create new submission
            $can->update([
                'cgrae_no' => $request->cgrae_no,
                'image' => $image,
                'phone_number' => $attrs['phone_number'],
                'type_piece' => mb_strtoupper($attrs['type_piece']),
                'no_card' => $attrs['no_card'],
                'birth_date' => $attrs['birth_date'],
                'gender' => $attrs['gender'],
                'ethnic' => isset($attrs['ethnic']) ? $attrs['ethnic'] : '',
                'religion' => isset($attrs['religion']) ? $attrs['religion'] : '',

                'phone_number2' => $request->phone_number2,
                'phone_number3' => $request->phone_number3,
                'sos_person_fullname' => $request->sos_person_fullname,
                'sos_person_phone_number' => $request->sos_person_phone_number,
            ]);

            //control
            CandidatureControl::create([
                'user_id' => auth()->id(),
                'adherent_id' => $can->id,
                'type' => 'updated',
                'table' => 'candidatures',
                'reason' => 'users and step1 form candidatures',
            ]);

            if ($can->step != 'pending' && $can->step != 'completed' && $can->step < 2)
                $can->step = 2;
            $can->save();

            return to_route('adherent.step', [2, $user->id])->with('success', 'Données enregistrées avec succès.');
        }

        if ($step ==  2) {

            $attrs = $request->validate([

                'situation_matrimoniale' => 'required|string',
                'email' => "nullable|string",
                'residence' => 'required|string',
                'address' => 'nullable|string',

            ]);


            $can->situation_matrimoniale = $attrs['situation_matrimoniale'];
            // $can->email = isset($attrs['email']) ? $attrs['email'] : null;
            $can->address = isset($attrs['address']) ? $attrs['address'] : null;
            $can->residence = $attrs['residence'];

            if (($attrs['situation_matrimoniale']) == 'marié(e)' || $attrs['situation_matrimoniale'] == 'concubin(e)') {

                $attrs += $request->validate([
                    'partner_fullname' => 'required|string',
                    'partner_job' => 'nullable|string',
                    'partner_phone_number' => 'required|string',
                    'partner_phone_numbe2' => 'nullable|string',
                ]);

                if (($attrs['situation_matrimoniale'] == 'marié(e)') && !$can->partner_card)
                    $attrs += $request->validate([
                        'partner_card' => 'nullable|file|mimes:pdf',
                    ]);

                $can->partner_fullname = $attrs['partner_fullname'];
                $can->partner_job = $attrs['partner_job'] ?? null;
                $can->partner_phone_number = $attrs['partner_phone_number'];
                $can->partner_phone_number2 = $request->partner_phone_number2 ?? null;

                if (isset($attrs['partner_card'])) {
                    if (File::exists($can->partner_card))
                        File::delete($can->partner_card);

                    $partner_card = time() . '.' . $attrs['partner_card']->getClientOriginalExtension();
                    $attrs['partner_card']->move(saveByEnv() . "data/docs/cards/", $partner_card);
                    $can->partner_card = 'data/docs/cards/' . $partner_card;
                }

                if ($attrs['situation_matrimoniale'] == 'marié(e)') {
                    if (!$can->marriage_certificate)
                        $attrs += $request->validate([
                            'marriage_certificate' => 'nullable|file|mimes:pdf'
                        ]);

                    if (isset($attrs['marriage_certificate'])) {

                        if (File::exists($can->marriage_certificate))
                            File::delete($can->marriage_certificate);

                        $marriage_certificate = time() . '.' . $attrs['marriage_certificate']->getClientOriginalExtension();
                        $attrs['marriage_certificate']->move(saveByEnv() . "data/docs/marriages/", $marriage_certificate);
                        $can->marriage_certificate = 'data/docs/marriages/' . $marriage_certificate;
                    }
                }
            }

            if ($childs = ChildCandidate::whereCandidatureId($can->id)->get()) {
                foreach ($childs as $child) {

                    if (File::exists($child->file))
                        File::delete($child->file);

                    $child->delete();
                }
            }

            if (isset($request->child_name) && is_array($request->child_name)) {

                $attrs += $request->validate([

                    'child_name' => 'nullable|array',
                    'child_birthdate' => 'nullable|array',
                    'child_niveau' => 'nullable|array',
                    'child_file' => 'nullable|array',
                    'child_job' => 'nullable|array',

                ]);

                $childs = [];
                foreach ($attrs['child_name'] as $key => $child) {

                    $childs[$key]['candidature_id'] = $can->id;
                    $childs[$key]['fullname'] = $request->child_name[$key];
                    $childs[$key]['birth_date'] = isset($request->child_birthdate[$key]) ? $request->child_birthdate[$key] : null;
                    $childs[$key]['level'] = isset($request->child_niveau[$key]) ? $request->child_niveau[$key] : null;
                    $childs[$key]['job'] = isset($request->child_job[$key]) ? $request->child_job[$key] : null;

                    if (isset($request->child_file[$key])) {
                        $child_fil = time() . '.' . $request->child_file[$key]->getClientOriginalExtension();
                        $request->child_file[$key]->move(saveByEnv() . "data/docs/childs/", $child_fil);
                        $childs[$key]['file'] = 'data/docs/childs/' . $child_fil;
                    } else
                        $childs[$key]['file'] = null;

                    if (!isset($childs[$key]['fullname']))
                        return back()->with('error', 'Renseignez correctement les données des enfants.');
                }

                foreach ($childs as $key => $child) {
                    ChildCandidate::create($child);
                }
            }

            //control
            CandidatureControl::create([
                'user_id' => auth()->id(),
                'adherent_id' => $can->id,
                'type' => 'updated',
                'table' => 'candidatures',
                'reason' => 'step2 form candidatures',
            ]);

            if ($can->step != 'pending' && $can->step != 'completed' && $can->step < 3)
                $can->step = 3;
            $can->save();
            return to_route('adherent.step', [3, $user->id])->with('success', 'Données enregistrées avec succès.');
        }

        if ($step ==  3) {

            $attrs = $request->validate([

                'armee' => 'required|string',
                'unite_rattachement' => 'required|string',
                'statut_prof' => 'required|string',
                'grade' => 'required|string',
                'date_entree' => 'required|date',
                'date_radiation' => 'required|date',

                'periode' => 'nullable|array',
                'organism' => 'nullable|array',
                'fonction' => 'nullable|array',

                'diplome_militaire' => 'nullable|array',
                'annees_dm' => 'nullable|array',
                'diplome_civil' => 'nullable|array',
                'annees_dc' => 'nullable|array',

            ]);

            $can->armee = $attrs['armee'];
            $can->unite_rattachement = $attrs['unite_rattachement'];
            $can->statut_prof = $attrs['statut_prof'];
            $can->grade = $attrs['grade'];
            $can->date_entree = $attrs['date_entree'];
            $can->date_radiation = $attrs['date_radiation'];

            if (JobCandidate::whereCandidatureId($can->id)->get())
                $can->jobs()->delete();
            if (DiplomaCandidate::whereCandidatureId($can->id)->get())
                $can->diplomes()->delete();

            if (isset($attrs['periode'])) {

                $jobs = [];

                foreach ($attrs['periode'] as $key => $value) {
                    $jobs[$key]['periode'] = $value;
                    $jobs[$key]['organism'] = $request->organism[$key];
                    $jobs[$key]['fonction'] = $request->fonction[$key];

                    if (!(isset($jobs[$key]['periode']) && isset($jobs[$key]['organism']) && isset($jobs[$key]['fonction'])))
                        return back()->with('error', 'Veuillez renseignez correctement les données concernants vos emploies.');
                }

                foreach ($jobs as $key => $value) {
                    $jo = new JobCandidate();
                    $jo->candidature_id = $can->id;
                    $jo->periode = $value['periode'];
                    $jo->organism = $value['organism'];
                    $jo->fonction = $value['fonction'];
                    $jo->save();
                }
            }

            // dd($attrs['diplome_militaire'], $attrs['diplome_civil']);
            if (isset($attrs['diplome_militaire'])) {

                $diplomas = [];

                foreach ($attrs['diplome_militaire'] as $key => $value) {
                    $diplomas[$key]['diplome_militaire'] = $value;
                    $diplomas[$key]['annees_dm'] = $request->annees_dm[$key];

                    if (!(isset($diplomas[$key]['diplome_militaire']) && isset($diplomas[$key]['annees_dm'])))
                        return back()->with('error', 'Veuillez renseignez correctement les données concernants vos diplômes.');
                }

                foreach ($diplomas as $key => $value) {
                    $dip = new DiplomaCandidate();
                    $dip->candidature_id = $can->id;
                    $dip->type = 'militaire';
                    $dip->diplome = $value['diplome_militaire'];
                    $dip->annees = $value['annees_dm'];
                    $dip->save();
                }
            }

            if (isset($attrs['diplome_civil'])) {

                $diplomas = [];

                foreach ($attrs['diplome_civil'] as $key => $value) {
                    $diplomas[$key]['diplome_civil'] = $request->diplome_civil[$key];
                    $diplomas[$key]['annees_dc'] = $request->annees_dc[$key];

                    if (!(isset($diplomas[$key]['diplome_civil']) && isset($diplomas[$key]['annees_dc'])))
                        return back()->with('error', 'Veuillez renseignez correctement les données concernants vos diplômes.');
                }

                foreach ($diplomas as $key => $value) {
                    $dip = new DiplomaCandidate();
                    $dip->candidature_id = $can->id;
                    $dip->type = 'civil';
                    $dip->diplome = $value['diplome_civil'];
                    $dip->annees = $value['annees_dc'];
                    $dip->save();
                }
            }

            //control
            CandidatureControl::create([
                'user_id' => auth()->id(),
                'adherent_id' => $can->id,
                'type' => 'updated',
                'table' => 'candidatures',
                'reason' => 'step3 form candidatures',
            ]);

            if ($can->step != 'pending' && $can->step != 'completed' && $can->step < 4)
                $can->step = 4;
            $can->save();

            return to_route('adherent.step', [4, $user->id])->with('success', 'Données enregistrées avec succès.');
        }

        if ($step ==  4) {

            $attrs = $request->validate([

                'orientation' => 'required|in:auto-emploi,fonction-publique,entreprise-privee',

                'domaine_1c' => 'required_if:orientation,auto-emploi|string',
                'specialisation_1c' => 'required|string',
                'region_retraite_1c' => 'required|string',
                'department_1c' => 'required|string',
                'locality_1c' => 'required|string',
                'adress_geo_1c' => 'required|string',
                'formation_1c' => 'nullable|string',
                'autres_form_1c' => 'nullable|string',

                'domaine_2c' => 'nullable|string',
                'specialisation_2c' => 'nullable|string',
                'region_retraite_2c' => 'nullable|string',
                'department_2c' => 'nullable|string',
                'locality_2c' => 'nullable|string',
                'adress_geo_2c' => 'nullable|string',
                'formation_2c' => 'nullable|string',
                'autres_form_2c' => 'nullable|string',

            ]);

            $can->orientation = $attrs['orientation'];

            $can->domaine_1c = $attrs['orientation'] == 'auto-emploi' ? $request->domaine_1c : null;
            $can->specialisation_1c = $attrs['specialisation_1c'];
            $can->region_retraite_1c = $attrs['region_retraite_1c'];
            $can->department_1c = $attrs['department_1c'];
            $can->locality_1c = $attrs['locality_1c'];
            $can->adress_geo_1c = $attrs['adress_geo_1c'];
            $can->formation_1c = $request->formation_1c ?? null;
            $can->autres_form_1c = $attrs['autres_form_1c'] ?? null;

            if ($request->specialisation_2c) {

                $attrs = $request->validate([

                    'orientation' => 'required|in:auto-emploi,fonction-publique,entreprise-privee',

                    'domaine_2c' => 'required_if:orientation,auto-emploi|string',
                    'specialisation_2c' => 'required|string',
                    'region_retraite_2c' => 'required|string',
                    'department_2c' => 'required|string',
                    'locality_2c' => 'required|string',
                    'adress_geo_2c' => 'required|string',
                    'formation_2c' => 'nullable|string',
                    'autres_form_2c' => 'nullable|string',

                ]);

                $can->domaine_2c =  $attrs['orientation'] == 'auto-emploi' ? $request->domaine_2c : null;
                $can->specialisation_2c =  $request->specialisation_2c;
                $can->region_retraite_2c =  $request->region_retraite_2c;
                $can->department_2c =  $request->department_2c;
                $can->locality_2c =  $request->locality_2c;
                $can->adress_geo_2c =  $request->adress_geo_2c;
                $can->formation_2c =  $request->formation_2c;
                $can->autres_form_2c =  $request->autres_form_2c ?? null;
            }

            //control
            CandidatureControl::create([
                'user_id' => auth()->id(),
                'adherent_id' => $can->id,
                'type' => 'updated',
                'table' => 'candidatures',
                'reason' => 'step4 form candidatures',
            ]);


            if ($can->step != 'pending' && $can->step != 'completed' && $can->step < 5)
                $can->step = 5;
            $can->save();

            return to_route('adherent.step', [5, $user->id])->with('success', 'Données enregistrées avec succès.');
        }

        if ($step == 5) {

            $attrs = $request->validate([
                'condition_admin' => 'required|string',
                'condition_financiere' => 'required|array',
                'condition_disciplinaire' => 'nullable|array',
            ]);

            if ($request->condition_admin == 'radiation')
                return to_route('adherent.step', [5, $user->id])->with('error', ' Si vous avez été radié vous ne pouvez poursuivre l’enregistrement de votre candidature. Prière de bien vouloir consulter les conditions d’éligibilité à la reconversion des militaires.');

            $can->condition_admin = $request->condition_admin;
            $can->condition_financiere = json_encode($request->condition_financiere);
            // dd($request->condition_disciplinaire);

            if ($attrs['condition_disciplinaire'][0]['title_decoration'])
                $can->condition_disciplinaire = $request->condition_disciplinaire ? json_encode($request->condition_disciplinaire) : null;
            else
                $can->condition_disciplinaire = null;


            if ($can->step != 'pending' && $can->step != 'completed' && $can->step < 6)
                $can->step = 6;
            $can->save();

            //control
            CandidatureControl::create([
                'user_id' => auth()->id(),
                'adherent_id' => $can->id,
                'type' => 'updated',
                'table' => 'candidatures',
                'reason' => 'step5 form candidatures',
            ]);

            return to_route('adherent.step', [6, $user->id])->with('success', 'Données enregistrées avec succès.');
        }

        if ($step == 6) {

            $attrs = $request->validate([
                'orientation' => 'required|in:oui,non',
                'accident_maladie' => 'required|string',
            ]);

            $can->accident_maladie = $request->accident_maladie;
            $can->maladie_supp = $request->input('maladie_supp', null);

            if ($request->orientation == 'oui') {

                $attrs += $request->validate([
                    'demarche_nature' => 'required|string',
                    'demarche_admin' => 'required|string',
                    'etat_avancement' => 'required|string',
                    'indication' => 'nullable|string',
                ]);

                $can->demarche_nature = $request->demarche_nature;
                $can->demarche_admin = $request->demarche_admin;
                $can->etat_avancement = $request->etat_avancement;
                $can->indication = $request->indication ?? null;
            } else {

                $can->demarche_nature = null;
                $can->demarche_admin = null;
                $can->etat_avancement = null;
                $can->indication = null;
            }

            //control
            CandidatureControl::create([
                'user_id' => auth()->id(),
                'adherent_id' => $can->id,
                'type' => 'updated',
                'table' => 'candidatures',
                'reason' => 'step6 form candidatures',
            ]);

            if ($can->step != 'pending' && $can->step != 'completed' && $can->step < 7)
                $can->step = 7;
            $can->save();

            return to_route('adherent.step', [7, $user->id])->with('success', 'Données enregistrées avec succès.');
        }

        if ($step == 7) {

            $attrs = [];

            $request->validate([
                'date_inscription' => 'required|date',
            ]);

            if (!$can->demande_manuscrite)
                $attrs += $request->validate([
                    'demande_manuscrite' => 'required|file|mimes:pdf',
                ]);
            if (!$can->cv)
                $attrs += $request->validate([
                    'cv' => 'nullable|file|mimes:pdf',
                ]);
            if (!$can->id_card)
                $attrs += $request->validate([
                    'id_card' => 'required|file|mimes:pdf',
                ]);
            if (!$can->carte_pro)
                $attrs += $request->validate([
                    'carte_pro' => 'nullable|file|mimes:pdf',
                ]);
            if (!$can->fiche_engagement)
                $attrs += $request->validate([
                    'fiche_engagement' => 'required|file|mimes:pdf',
                ]);
            if (!$can->fiche_individuelle)
                $attrs += $request->validate([
                    'fiche_individuelle' => 'nullable|file|mimes:pdf',
                ]);
            if (!$can->fiche_inscription)
                $attrs += $request->validate([
                    'fiche_inscription' => 'nullable|file|mimes:pdf',
                ]);
            if (!$can->arrete_radiation)
                $attrs += $request->validate([
                    'arrete_radiation' => 'required|file|mimes:pdf',
                ]);
            if (!$can->certificat)
                $attrs += $request->validate([
                    'certificat' => 'nullable|file|mimes:pdf',
                ]);

            $attrs += $request->validate([
                'demande_manuscrite' => 'nullable|file|mimes:pdf',
                'cv' => 'nullable|file|mimes:pdf',
                'id_card' => 'nullable|file|mimes:pdf',
                'carte_pro' => 'nullable|file|mimes:pdf',
                'fiche_engagement' => 'nullable|file|mimes:pdf',
                'fiche_individuelle' => 'nullable|file|mimes:pdf',
                'arrete_radiation' => 'nullable|file|mimes:pdf',
                'certificat' => 'nullable|file|mimes:pdf',
                'fiche_inscription' => 'nullable|file|mimes:pdf',
            ]);

            foreach ($attrs as $key => $val) {

                if ($can[$key]) {
                    if (File::exists($can[$key]))
                        File::delete($can[$key]);
                }

                $file = time() . '_' . $key . '.' . $val->getClientOriginalExtension();
                $path = public_path(saveByEnv() . "data/docs/$key") . "/" . $file;

                if ($val->getClientOriginalExtension() != 'pdf')
                    \Image::make($val->getRealPath())->save($path);
                else
                    $val->move(saveByEnv() . "data/docs/$key/", $file);

                $can[$key] = "data/docs/$key/" . $file;
            }

            //control
            CandidatureControl::create([
                'user_id' => auth()->id(),
                'adherent_id' => $can->id,
                'type' => 'updated',
                'table' => 'candidatures',
                'reason' => 'step7 form candidatures',
            ]);

            if (can('point-focal') || (can('conseiller-en-reconversion'))) {
                $can->date_inscription = $request->date_inscription;
                $can->submitted_by = auth()->id();
                $can->submitted_at = date('Y-m-d H:i:s');
                $can->step = 'pending';
                $can->save();
                return to_route('adherent.pending')->with('success', 'Candidature en attente d\'aprobation.');
            } else {
                $can->date_inscription = $request->date_inscription;
                $can->completed_by = auth()->id();
                $can->completed_at = date('Y-m-d H:i:s');
                $can->step = 'completed';
                $can->save();
                if ($can->orientation == 'auto-emploi')
                    return to_route('cohort.index')->with('success', 'Candidature approuvé avec succès');
                else
                    return to_route('adherent.list')->with('success', 'Candidature approuvé avec succès');
            }
        }
    }

    public function choicePartnerTechnicial(int $id)
    {
        $user = User::findOrFail($id);
        $candidat = Candidature::whereUserId($user->id)->first();
        $partners = Partenaire::all();
        $partner_technicials = [];
        foreach ($partners as $key => $partner) {
            if (in_array('partner-technical', userPermissions($partner->user)))
                (array)$partner_technicials[] = $partner;
        }

        return view('dashboard.inscription.choice_partner', compact('id', 'candidat', 'user', 'partner_technicials'));
    }

    public function choice_partner(Request $request, $id)
    {

        $request->validate(['partners' => 'required|array']);

        try {

            $count = count($request->partners);

            Partenaire::findOrFail($request->partners[0]);
            if ($count > 1)
                Partenaire::findOrFail($request->partners[1]);

            $candidature = Candidature::findOrFail($id);
            $candidature->choice_1_partner_id = $request->partners[0];
            if ($count > 1 && $candidature->domaine_2c)
                $candidature->choice_2_partner_id = $request->partners[1];

            $candidature->save();

            $candidature->partenaires()->sync($request->partners);

            return to_route('adherent.list')->with('success', 'Données enregistrées avec succès.');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    public function choiceFinal(Candidature $candidature)
    {
        $title = 'Choix final de M/Mme';
        $user_id = $candidature->user_id;
        $user = User::findOrFail($user_id);
        $title .= ' ' . $user->fullName();

        if ($user->candidate->choiceFinal)
            return back()->with('success',  'Choix final déjà pris.');

        $partners = Partenaire::all();
        $partner_technicials = [];
        foreach ($partners as $key => $partner) {
            if (in_array('partner-technical', userPermissions($partner->user)))
                (array)$partner_technicials[] = $partner;
        }

        $partner_financials = [];
        foreach ($partners as $key => $partner_fin) {
            if (in_array('partner-financial', userPermissions($partner_fin->user)))
                (array)$partner_financials[] = $partner_fin;
        }

        $user_id = Auth::user()->id;
        $partenaire = Partenaire::where('user_id', $user_id)->first();

        return view('dashboard.adherent.choice_final', compact('user', 'partner_technicials', 'partner_financials', 'title', 'candidature', 'partenaire'));
    }


    public function choiceFinalStore(Request $request, string $id)
    {

        try {

            // dd()
            $request->validate([
                'choice' => 'required|in:choice_one,choice_two,other',
                'date_profilage' => 'required|date',
            ]);
            $user = User::findOrFail($id);

            if ($user->candidate->choiceFinal)
                return back()->with('success',  'Choix final déjà pris.');

            $attrs = [];

            $attrs['candidature_id'] = $user->candidate->id;
            $attrs['profilage_date'] = $request->date_profilage ?? date('Y-m-d');


            $auth_id = Auth::user()->id;

            $candidature = Candidature::find($request->candidature_id);

            $partenaire = Partenaire::where('user_id', $auth_id)->first();

            $pivotData = CandidaturePartenaire::where('candidature_id', $candidature->id)
            ->where('partenaire_id', $partenaire->id)
            ->orderBy('id', 'desc')
            ->whereNull('status')
            ->first();

            if(!$pivotData)
                return back()->with("error", 'Un problème est survenu lors de la validation');

            if ($request->partner_financial === 'other') {
                $pivotData->update([
                    'status' => 'accepted',
                    'other_partner_financial' => $request->other_partner_financial,
                ]);

                $candidature->update([
                    'partner_technical_id' => $partenaire->id,
                    'other_partner_financial' => $request->other_partner_financial,
                ]);
            } else {
                $pivotData->update([
                    'status' => 'accepted',
                    'partner_financial_id' => $request->partner_financial,
                ]);

                $candidature->update([
                    'partner_technical_id' => $partenaire->id,
                    'partner_financial_id' => $request->partner_financial,
                ]);
            }



            if ($request->choice === 'other') {

                if ($user->candidate->orientation == 'auto-emploi')
                    $attrs['partner_id'] = $partenaire->id;

                $attrs['choice_number'] = 'other';
                $attrs += $request->validate([
                    'domaine' => 'required|string',
                    'specialisation' => 'required|string',
                    'region_retraite' => 'required|string',
                    'department' => 'required|string',
                    'locality' => 'required|string',
                    'adress_geo' => 'required|string',
                    'formation' => 'nullable|string',
                    'autres_form' => 'nullable|string',
                ]);
            }


            if ($request->choice === 'choice_one') {

                if ($user->candidate->orientation == 'auto-emploi')
                    $attrs['partner_id'] = $partenaire->id;

                $attrs['choice_number'] = 'one';
                $attrs['domaine'] = $user->candidate->domaine_1c ?? null;
                $attrs['specialisation'] = $user->candidate->specialisation_1c ?? null;
                $attrs['region_retraite'] = $user->candidate->region_retraite_1c ?? null;
                $attrs['department'] = $user->candidate->department_1c ?? null;
                $attrs['locality'] = $user->candidate->locality_1c ?? null;
                $attrs['adress_geo'] = $user->candidate->adress_geo_1c ?? null;
                $attrs['formation'] = $user->candidate->formation_1c ?? null;
                $attrs['autres_form'] = $user->candidate->autres_form_1c ?? null;
            }

            if ($request->choice === 'choice_two') {

                if ($user->candidate->orientation == 'auto-emploi')
                    $attrs['partner_id'] = $partenaire->id;

                $attrs['choice_number'] = 'two';
                $attrs['domaine'] = $user->candidate->domaine_2c ?? null;
                $attrs['specialisation'] = $user->candidate->specialisation_2c ?? null;
                $attrs['region_retraite'] = $user->candidate->region_retraite_2c ?? null;
                $attrs['department'] = $user->candidate->department_2c ?? null;
                $attrs['locality'] = $user->candidate->locality_2c ?? null;
                $attrs['adress_geo'] = $user->candidate->adress_geo_2c ?? null;
                $attrs['formation'] = $user->candidate->formation_2c ?? null;
                $attrs['autres_form'] = $user->candidate->autres_form_2c ?? null;
            }



            //control
            CandidatureControl::create([
                'user_id' => auth()->id(),
                'adherent_id' => $user->candidate->id,
                'type' => 'created',
                'table' => 'choice_final_adherents',
            ]);

            ChoiceFinalAdherent::create($attrs);

            return to_route('profilage.partenaire_candidat_profilage', $candidature->cohort_id)->with('success', 'Candidat profilé.');
        } catch (Throwable $e) {
            dd($e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }

    public function deaths()
    {
        $adherents = Candidature::where('death', '1')->orderByDesc('created_at')->get();

        return view('dashboard.adherent.deaths', [
            'title' => 'Liste de décès',
            'adherents' => $adherents
        ]);
    }
    public function death(Request $request, int $id)
    {

        $adherent = Candidature::findOrFail($id);
        $user = User::findOrFail($adherent->user_id);
        $attrs = $request->validate([
            'death_date' => 'required|date_format:Y-m-d',
            'death_no_act' => 'nullable',
            'death_city' => 'nullable|string',
            'death_justification' => 'required|string',
        ]);

        $attrs['death'] = '1';
        $user->status = '0';
        $user->save();

        $adherent->update($attrs);

        //control
        CandidatureControl::create([
            'user_id' => auth()->id(),
            'adherent_id' => $adherent->id,
            'type' => 'updated',
            'table' => 'candidatures',
            'reason' => 'register death candidate',
        ]);

        return back()->with('success', 'Statut du compte de l\'adherent modifié avec succès.');
    }


    public function resignations()
    {
        $adherents = Candidature::where('resignation', '1')->orderByDesc('created_at')->get();

        return view('dashboard.adherent.resignations', [
            'title' => 'Liste des abandons',
            'adherents' => $adherents
        ]);
    }
    public function resignation(Request $request, int $id)
    {

        $adherent = Candidature::findOrFail($id);
        $user = User::findOrFail($adherent->user_id);
        $attrs = $request->validate([
            'resignation_date' => 'required|date_format:Y-m-d',
            'resignation_justification' => 'required|string',
        ]);

        $attrs['resignation'] = '1';
        $user->status = '0';
        $user->save();

        $adherent->update($attrs);

        //control
        CandidatureControl::create([
            'user_id' => auth()->id(),
            'adherent_id' => $adherent->id,
            'type' => 'updated',
            'table' => 'candidatures',
            'reason' => 'register resignation candidate',
        ]);

        return back()->with('success', 'Statut du compte de l\'adherent modifié avec succès.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $id,

            'birth_date' => 'required|date',
            'date_inscription' => 'required|date',
            'gender' => 'required|string',
            'religion' => 'nullable|string',
            'ethnic' => 'nullable|string',
            'phone_number' => 'required|string|max:20|unique:users,phone,' . $id,
            'phone_number2' => 'nullable|string|max:20',
            'phone_number3' => 'nullable|string|max:20',
            'residence' => 'required|string|max:255',

            'type_piece' => 'required|string',
            'no_card' => 'nullable|string|max:255',

            'cgrae_no' => 'nullable|string|unique:candidatures,cgrae_no,' . $user->candidate->id,

            'situation_matrimoniale' => 'required|string',
            'partner_fullname' => 'nullable|string|max:255',
            'partner_job' => 'nullable|string|max:255',
            'partner_phone_number' => 'nullable|string|max:20',
            'partner_phone_number2' => 'nullable|string|max:20',
            'partner_card' => 'nullable|file|mimes:pdf',
            'marriage_certificate' => 'nullable|file|mimes:pdf',

            'sos_person_fullname' => 'nullable|string',
            'sos_person_phone_number' => 'nullable|string',
            'sos_person_phone_number2' => 'nullable|string',

            'armee' => 'required|string',
            'unite_rattachement' => 'required|string',
            'statut_prof' => 'required|string',
            'grade' => 'required|string',
            'date_entree' => 'required|date',
            'date_radiation' => 'required|date|after_or_equal:date_entree',

            'condition_admin' => 'required|string|max:255',
            'condition_financiere' => 'nullable|array',
            'condition_financiere.*' => 'string|max:255',
            'condition_disciplinaire' => 'nullable|array',
            'condition_disciplinaire.*.title_decoration' => 'nullable|string|max:255',
            'condition_disciplinaire.*.date_decoration' => 'nullable|date',

            // Validation pour accident/maladie
            'accident_maladie' => 'required|string',
            'maladie_supp' => 'nullable|string',
            'demarche_entreprise' => 'required|in:oui,non',
            'demarche_nature' => 'required_if:demarche_entreprise,oui|nullable|string|max:255',
            'demarche_admin' => 'required_if:demarche_entreprise,oui|nullable|string|max:255',
            'etat_avancement' => 'required_if:demarche_entreprise,oui|nullable|string|max:255',
            'indication' => 'nullable|string',

        ]);

        $user = User::findOrFail($id);
        $user->phone = $request->phone_number;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email ?? $user->email;
        $user->save();

        $candidate = $user->candidate;

        if (!$candidate->choiceFinal) {
            $request->validate([
                'orientation' => 'required|string',
                'domaine_1c' => 'required_if:orientation,auto-emploi|string|max:255',
                'specialisation_1c' => 'required|string|max:255',
                'region_retraite_1c' => 'required|string',
                'department_1c' => 'required|string',
                'locality_1c' => 'required|string',
                'adress_geo_1c' => 'nullable|string',
                'formation_1c' => 'nullable|string|max:255',
                'autres_form_1c' => 'nullable|string|max:255',
            ]);

            if ($request->specialisation_2c)
                $request->validate([
                    'domaine_2c' => 'required_if:orientation,auto-emploi|string|max:255',
                    'specialisation_2c' => 'required|string|max:255',
                    'region_retraite_2c' => 'required|string',
                    'department_2c' => 'required|string',
                    'locality_2c' => 'required|string',
                    'adress_geo_2c' => 'nullable|string',
                    'formation_2c' => 'nullable|string|max:255',
                    'autres_form_2c' => 'nullable|string|max:255',
                ]);

            $candidate->fill($request->only([
                'birth_date',
                'date_inscription',
                'gender',
                'religion',
                'ethnic',
                'phone_number',
                'phone_number2',
                'phone_number3',
                'residence',
                'cgrae_no',
                'type_piece',
                'no_card',
                'situation_matrimoniale',
                'partner_fullname',
                'partner_job',
                'partner_phone_number',
                'partner_phone_number2',
                'sos_person_fullname',
                'sos_person_phone_number',
                'sos_person_phone_number2',
                'armee',
                'unite_rattachement',
                'statut_prof',
                'grade',
                'date_entree',
                'date_radiation',
                'orientation',
                'domaine_1c',
                'specialisation_1c',
                'region_retraite_1c',
                'department_1c',
                'locality_1c',
                'adress_geo_1c',
                'formation_1c',
                'autres_form_1c',
                'domaine_2c',
                'specialisation_2c',
                'region_retraite_2c',
                'department_2c',
                'locality_2c',
                'adress_geo_2c',
                'formation_2c',
                'autres_form_2c',
                'accident_maladie',
                'maladie_supp',
                'indication'
            ]));

            if ($request->demarche_entreprise === 'oui') {
                $candidate->demarche_nature = $request->demarche_nature;
                $candidate->demarche_admin = $request->demarche_admin;
                $candidate->etat_avancement = $request->etat_avancement;
            } else {
                $candidate->demarche_nature = null;
                $candidate->demarche_admin = null;
                $candidate->etat_avancement = null;
            }
        } else {
            $candidate->fill($request->only([
                'birth_date',
                'date_inscription',
                'gender',
                'religion',
                'ethnic',
                'phone_number',
                'phone_number2',
                'phone_number3',
                'residence',
                'cgrae_no',

                'type_piece',
                'no_card',
                'situation_matrimoniale',
                'partner_fullname',
                'partner_job',
                'partner_phone_number',
                'partner_phone_number2',
                'sos_person_fullname',
                'sos_person_phone_number',
                'sos_person_phone_number2',
                'armee',
                'unite_rattachement',
                'statut_prof',
                'grade',
                'date_entree',
                'date_radiation',
                'accident_maladie',
                'maladie_supp',
                'indication'
            ]));

            if ($request->demarche_entreprise === 'oui') {
                $candidate->demarche_nature = $request->demarche_nature;
                $candidate->demarche_admin = $request->demarche_admin;
                $candidate->etat_avancement = $request->etat_avancement;
            } else {
                $candidate->demarche_nature = null;
                $candidate->demarche_admin = null;
                $candidate->etat_avancement = null;
            }
        }

        $this->handleFileUploads($request, $candidate, [
            'partner_card',
            'marriage_certificate',
            'fiche_inscription',
            'demande_manuscrite',
            'cv',
            'id_card',
            'carte_pro',
            'fiche_engagement',
            'fiche_individuelle',
            'arrete_radiation',
            'certificat'
        ]);

        $candidate->save();

        $this->updatePhotoIdentite($request, $candidate);

        $this->updateChildren($request, $candidate);

        $this->updateJobs($request, $candidate);

        $this->updateDiplomas($request, $candidate);

        $this->updateCondition($request, $candidate);

        return redirect()->back()->with('success', 'Les informations ont été mises à jour avec succès.');
    }

    private function updatePhotoIdentite(Request $request, $candidate)
    {
        if ($request->hasFile('image')) {
            if ($candidate->image && file_exists(public_path($candidate->image))) {
                unlink(public_path($candidate->image));
            }

            $image = null;

            $image = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(saveByEnv() . "data/docs/photo/", $image);
            $image =  'data/docs/photo/' . $image;

            $candidate->image = $image;
            $candidate->save();
        }
    }


    private function handleFileUploads(Request $request, Candidature $candidate, array $fields)
    {
        foreach ($fields as $field) {
            if ($request->hasFile($field)) {
                if ($candidate->$field && File::exists($candidate->$field)) {
                    File::delete($candidate->$field);
                }
                $fileName = time() . '_' . $field . '.' . $request->file($field)->getClientOriginalExtension();
                $request->file($field)->move(saveByEnv() . "data/docs/$field/", $fileName);
                $candidate->$field = "data/docs/$field/" . $fileName;
            }
        }
    }

    private function updateChildren(Request $request, Candidature $candidate)
    {
        $candidate->childs()->delete();
        if ($request->has('child_name')) {
            foreach ($request->child_name as $index => $childName) {

                $candidate->childs()->create([
                    'fullname' => $childName,
                    'birth_date' => $request->child_birthdate[$index] ?? null,
                    'level' => $request->child_niveau[$index],
                ]);
            }
        }
    }

    private function updateJobs(Request $request, Candidature $candidate)
    {
        $candidate->jobs()->delete();
        if ($request->has('periode')) {
            foreach ($request->periode as $index => $periode) {
                $candidate->jobs()->create([
                    'periode' => $periode,
                    'organism' => $request->organism[$index],
                    'fonction' => $request->fonction[$index],
                ]);
            }
        }
    }

    private function updateDiplomas(Request $request, Candidature $candidate)
    {
        $candidate->diplomes()->delete();

        if ($request->has('diplome_militaire')) {
            foreach ($request->diplome_militaire as $index => $diploma) {
                $candidate->diplomes()->create([
                    'diplome' => $diploma,
                    'annees' => $request->annees_militaire[$index],
                    'type' => 'militaire',
                ]);
            }
        }
        if ($request->has('diplome_civil')) {
            foreach ($request->diplome_civil as $index => $diploma) {
                $candidate->diplomes()->create([
                    'diplome' => $diploma,
                    'annees' => $request->annees_civil[$index],
                    'type' => 'civil',
                ]);
            }
        }
    }

    private function updateCondition(Request $request, $candidate)
    {

        // dd($request->all());

        // $candidate->condition_admin = $request->condition_admin;
        // $candidate->condition_financiere = json_encode($request->condition_financiere);
        // if ($request->condition_disciplinaire)
        //     $candidate->condition_disciplinaire = $request->condition_disciplinaire ? json_encode($request->condition_disciplinaire) : null;
        // else
        //     $candidate->condition_disciplinaire = null;


        $candidate->condition_admin = $request->input('condition_admin');

        $candidate->condition_financiere = $request->has('condition_financiere')
            ? json_encode($request->input('condition_financiere'))
            : json_encode([]);

        if ($request->has('condition_disciplinaire')) {
            $disciplinary = array_filter($request->input('condition_disciplinaire'), function ($item) {
                return !empty($item['title_decoration']) || !empty($item['date_decoration']);
            });

            $candidate->condition_disciplinaire = json_encode(array_values($disciplinary));
        } else {
            $candidate->condition_disciplinaire = json_encode([]);
        }

        $candidate->save();
    }
}
