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
        $adherent = Candidature::findOrFail($id);

        if (can('partner-financial'))
            return view('dashboard.monitored_evaluation.post_monitored.adherent_partner', compact('adherent'));
        else
            return view('dashboard.monitored_evaluation.post_monitored.adherent', compact('adherent'));
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
