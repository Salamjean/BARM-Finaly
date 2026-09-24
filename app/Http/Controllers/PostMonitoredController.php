<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Candidature;
use App\Models\Cohort;
use App\Models\ReportPostMonitored;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostMonitoredController extends Controller
{
    public function cohorts()
    {
        $cohorts = Cohort::whereHas("adhrents", function ($query) {
            $query->where('post_monitored', true);
        })->get();

        foreach ($cohorts as $key => $cohort) {
            $cohort->candidature_count = count($cohort->adhrents);

            $post_monitored_count = 0;
            foreach ($cohort->adhrents as $adhrent) {
                if (can('partner-technical'))
                    $post_monitored_count += Candidature::where('id', $adhrent->id)
                        ->where('orientation', 'auto-emploi')
                        ->where('post_monitored', true)
                        ->where('partner_technical_id', auth()->user()->partenaire->id)
                        ->exists() ? 1 : 0;
                elseif (can('partner-financial'))
                    $post_monitored_count += Candidature::where('id', $adhrent->id)
                        ->where('orientation', 'auto-emploi')
                        ->where('post_monitored', true)
                        ->where('partner_financial_id', auth()->user()->partenaire->id)
                        ->exists() ? 1 : 0;
                elseif (can('point-focal'))
                    $post_monitored_count += Candidature::where('id', $adhrent->id)
                        ->where('orientation', 'auto-emploi')
                        ->where('post_monitored', true)
                        ->where('focal_point_area', Auth::user()->personnel->ville_barm)
                        ->exists() ? 1 : 0;
                else
                    $post_monitored_count += Candidature::where('id', $adhrent->id)
                        ->where('orientation', 'auto-emploi')
                        ->where('post_monitored', true)
                        ->exists() ? 1 : 0;
            }
            $cohort->candidature_post_monitored_count = $post_monitored_count;
        }

        return view('dashboard.monitored_evaluation.post_monitored.cohorts', ['cohorts' => $cohorts]);
    }

    public function cohort(int $id)
    {
        $cohort = Cohort::findOrFail($id);

        $adherents = [];

        if (
            can('chef-celulle-suivi-evaluation|responsable-suivi-evaluation|assistant-suivi-evaluation') || 
            can('partner-technical') 
            || can('point-focal
            ') || can('partner-financial') 
            || can('chef-cellule-formation-et-insertion|conseiller-auto-emploi|conseiller-fonction-public|conseiller-entreprise-prive') 
            || can('chef-barm|c2d|memdef')) 
            {

            if (can('partner-financial'))

                $adherents = Candidature::where('cohort_id', $cohort->id)
                    ->where('orientation', 'auto-emploi')
                    ->where('post_monitored', true)
                    ->where('partner_financial_id', auth()->user()->partenaire->id)
                    ->get();


            elseif (can('partner-technical'))

                $adherents = Candidature::where('cohort_id', $cohort->id)
                    ->where('orientation', 'auto-emploi')
                    ->where('post_monitored', true)
                    ->where('partner_technical_id', auth()->user()->partenaire->id)
                    ->get();
            elseif (can('point-focal'))
                $adherents = Candidature::where('cohort_id', $cohort->id)
                    ->where('orientation', 'auto-emploi')
                    ->where('post_monitored', true)
                    ->where('focal_point_area', Auth::user()->personnel->ville_barm)
                    ->get();
            else
                $adherents = Candidature::where('cohort_id', $cohort->id)
                    ->where('orientation', 'auto-emploi')
                    ->where('post_monitored', true)
                    ->get();
        }

        return view('dashboard.monitored_evaluation.post_monitored.cohort', [
            'cohort' => $cohort,
            'adherents' => $adherents,
        ]);
    }


    //  fonction public
    public function candidats_fp()
    {

        if (can('point-focal')) {
            $adherents = Candidature::orderByDESC('created_at')
                ->where('orientation', 'fonction-publique')
                ->where('post_monitored', true)
                // ->where('created_by', auth()->id())
                ->get();
        } else {
            $adherents = Candidature::orderByDESC('created_at')
                ->where('orientation', 'fonction-publique')
                ->where('post_monitored', true)
                ->get();
        }

        $title = 'Liste des candidats - BARM';

        return view('dashboard.monitored_evaluation.post_monitored.candidats', compact('adherents', 'title'));
    }

    // entrepise privée
    public function candidats_ep()
    {

        if (can('point-focal')) {
            $adherents = Candidature::orderByDESC('created_at')
                ->where('orientation', 'entreprise-privee')
                ->where('post_monitored', true)
                // ->where('created_by', auth()->id())
                ->get();
        } else {
            $adherents = Candidature::orderByDESC('created_at')
                ->where('orientation', 'entreprise-privee')
                ->where('post_monitored', true)
                ->get();
        }

        $title = 'Liste des candidats - BARM';

        return view('dashboard.monitored_evaluation.post_monitored.candidats', compact('adherents', 'title'));
    }

    public function adherent(int $id)
    {
        $adherent = Candidature::with(['user', 'cohort', 'suivi1User', 'suivi2User', 'suivi3User', 'postInsertionUser', 'candidatentreprise', 'reportsPostMonitored.createdBy'])->findOrFail($id);

        if (can('partner-financial'))
            return view('dashboard.monitored_evaluation.post_monitored.adherent_partner', compact('adherent'));
        else
            return view('dashboard.monitored_evaluation.post_monitored.adherent', compact('adherent'));
    }

    public function save_suivi(Request $request, int $id, int $step)
    {
        authPermission('partner-technical|partner-financial|chef-celulle-suivi-evaluation|responsable-suivi-evaluation|assistant-suivi-evaluation|chef-cellule-formation-et-insertion|conseiller-auto-emploi|point-focal|conseiller-fonction-public|conseiller-entreprise-prive|chef-barm');

        if (!in_array($step, [1, 2, 3])) {
            return response()->json([
                'action' => false,
                'message' => "Étape de suivi invalide.",
            ], 422);
        }

        $adherent = Candidature::findOrFail($id);

        // Sequential validation check
        if ($step === 2 && empty($adherent->suivi_1_date)) {
            return response()->json([
                'action' => false,
                'message' => "Veuillez d'abord compléter le Suivi 1 avant de passer au Suivi 2.",
            ]);
        }

        if ($step === 3 && empty($adherent->suivi_2_date)) {
            return response()->json([
                'action' => false,
                'message' => "Veuillez d'abord compléter le Suivi 2 avant de passer au Suivi 3.",
            ]);
        }

        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'commentaire' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,webp|max:10240',
        ], [
            'date.required' => 'La date de suivi est obligatoire.',
            'date.date' => 'La date de suivi doit être une date valide.',
            'file.file' => 'Le document doit être un fichier valide.',
            'file.mimes' => 'Formats acceptés : PDF, Word (DOC, DOCX), Images (JPG, PNG, WEBP).',
            'file.max' => 'La taille maximale du fichier est de 10 Mo.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'action' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');
            $fileName = time() . '_suivi_' . $step . '_' . uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
            $destinationPath = saveByEnv() . "data/docs/suivi_files/";
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $uploadedFile->move($destinationPath, $fileName);
            $adherent->{"suivi_{$step}_file"} = 'data/docs/suivi_files/' . $fileName;
        }

        $adherent->{"suivi_{$step}_date"} = $request->date;
        $adherent->{"suivi_{$step}_commentaire"} = $request->commentaire;
        $adherent->{"suivi_{$step}_by"} = auth()->id();
        $adherent->{"suivi_{$step}_at"} = now();
        $adherent->post_monitored = true;
        $adherent->save();

        return response()->json([
            'action' => true,
            'message' => "Suivi $step enregistré avec succès.",
        ]);
    }

    public function save_decision(Request $request, int $id)
    {
        authPermission('partner-technical|partner-financial|chef-celulle-suivi-evaluation|responsable-suivi-evaluation|assistant-suivi-evaluation|chef-cellule-formation-et-insertion|conseiller-auto-emploi|point-focal|conseiller-fonction-public|conseiller-entreprise-prive|chef-barm');

        $adherent = Candidature::findOrFail($id);

        if (empty($adherent->suivi_3_date)) {
            return response()->json([
                'action' => false,
                'message' => "Veuillez compléter les 3 suivis préalables avant d'enregistrer la décision finale.",
            ]);
        }

        $status = $request->status;
        if (!in_array($status, ['en_service', 'revoque', 'demission', 'indisponible'])) {
            return response()->json([
                'action' => false,
                'message' => "Veuillez sélectionner un statut valide parmi : En service, Révoqué, Démission, Indisponibilité.",
            ]);
        }

        $rules = [
            'status' => 'required|in:en_service,revoque,demission,indisponible',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,webp|max:10240',
        ];
        $messages = [
            'date.required' => 'La date est obligatoire.',
            'date.date' => 'La date doit être valide.',
            'date_fin.required' => 'La date de fin est obligatoire.',
            'date_fin.date' => 'La date de fin doit être valide.',
            'date_fin.after_or_equal' => 'La date de fin doit être postérieure ou égale à la date de début.',
            'motif.required' => 'Le motif est obligatoire.',
            'file.file' => 'Le document doit être un fichier valide.',
            'file.mimes' => 'Formats acceptés : PDF, Word (DOC, DOCX), Images (JPG, PNG, WEBP).',
            'file.max' => 'La taille maximale du fichier est de 10 Mo.',
        ];

        if ($status === 'revoque' || $status === 'demission') {
            $rules['date'] = 'required|date';
            $rules['motif'] = 'required|string';
        } elseif ($status === 'indisponible') {
            $rules['date'] = 'required|date';
            $rules['date_fin'] = 'required|date|after_or_equal:date';
            $rules['motif'] = 'required|string';
        } else {
            // en_service
            $rules['date'] = 'nullable|date';
            $rules['motif'] = 'nullable|string';
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'action' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');
            $fileName = time() . '_decision_' . uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
            $destinationPath = saveByEnv() . "data/docs/decision_files/";
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $uploadedFile->move($destinationPath, $fileName);
            $adherent->post_insertion_file = 'data/docs/decision_files/' . $fileName;
        }

        $adherent->post_insertion_status = $status;
        $adherent->post_insertion_by = auth()->id();
        $adherent->post_insertion_at = now();

        if ($status === 'en_service') {
            $adherent->post_insertion_date = $request->date ?? now()->toDateString();
            $adherent->post_insertion_date_fin = null;
            $adherent->post_insertion_motif = $request->motif ?? null;
            $adherent->en_poste = '1';
            $adherent->resignation = '0';
            $adherent->absent = '0';
        } elseif ($status === 'revoque') {
            $adherent->post_insertion_date = $request->date;
            $adherent->post_insertion_date_fin = null;
            $adherent->post_insertion_motif = $request->motif;
            $adherent->en_poste = '0';
        } elseif ($status === 'demission') {
            $adherent->post_insertion_date = $request->date;
            $adherent->post_insertion_date_fin = null;
            $adherent->post_insertion_motif = $request->motif;
            $adherent->en_poste = '0';
            $adherent->resignation = '1';
            $adherent->resignation_date = $request->date;
            $adherent->resignation_justification = $request->motif;
        } elseif ($status === 'indisponible') {
            $adherent->post_insertion_date = $request->date;
            $adherent->post_insertion_date_fin = $request->date_fin;
            $adherent->post_insertion_motif = $request->motif;
            $adherent->absent = '1';
            $adherent->absent_date = $request->date;
            $adherent->absent_justification = $request->motif;
        }

        $adherent->save();

        return response()->json([
            'action' => true,
            'message' => 'Décision finale enregistrée avec succès.',
        ]);
    }

    public function store(Request $request, int $id)
    {

        authPermission('partner-technical|partner-financial|chef-celulle-suivi-evaluation|responsable-suivi-evaluation|assistant-suivi-evaluation|chef-cellule-formation-et-insertion|conseiller-auto-emploi|point-focal|conseiller-fonction-public|conseiller-entreprise-prive');

        $adherent = Candidature::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'report_title' => 'required|string',
            'report_descrption' => 'nullable|string',
            'report_file' => "nullable|file|mimes:pdf",
            'date_visit' => 'required|date',
        ], [
            'required' => 'Veuillez remplir les champs requis',
            'report_file.file' => "Le rapport doit être un fichier",
            'report_file.mimes' => "Le rapport doit être un fichier de type pdf",
            'date_visit.date' => "Format date requis",
        ]);

        if ($validator->fails())
            return response()->json([
                'action' => false,
                'message' => $validator->errors()->first(),
            ]);

        if (!$request->report_file && !$request->report_description)
            return response()->json([
                'action' => false,
                'message' => 'Veuillez renseigner une description ou un fichier.',
            ]);

        $file = null;
        if ($request->report_file) {
            $file = time() . '.' . $request->report_file->getClientOriginalExtension();
            $request->report_file->move(saveByEnv() . "data/docs/report_file/", $file);
            $file = 'data/docs/report_file/' . $file;
        }

        $attrs = [
            'created_by' => auth()->id(),
            'candidature_id' => $adherent->id,
            'report_title' => $request->report_title,
            'report_description' => $request->report_description ?? null,
            'date_visit' => $request->date_visit,
            'file_report' => $file,
        ];

        if (can('partner-financial|partner-technical'))
            $attrs['user_type'] = 'partner';
        else
            $attrs['user_type'] = 'personal';

        ReportPostMonitored::create($attrs);

        return response()->json([
            'action' => true,
            'message' => 'Rapport ajouté avec succès.',
        ]);
    }
}
