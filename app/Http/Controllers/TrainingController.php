<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Cohort;
use App\Models\Training;
use App\Models\TrainingParticipation;
use Illuminate\Http\Request;

class TrainingController extends Controller
{

    public function partner()
    {
        authPermission('partner-technical');
        return auth()->user()->partenaire;
    }
    public function index(int $id)
    {

        $partner = $this->partner();
        $cohort = Cohort::findOrFail($id);
        $trainings = Training::where('cohort_id', $cohort->id)->where('partner_technicial_id', $partner->id)->get();

        return view('dashboard.cohort.partner.training.index', [
            'cohort' => $cohort,
            'trainings' => $trainings,
        ]);
    }

    public function create(int $id)
    {

        $partner = $this->partner();
        $cohort = Cohort::findOrFail($id);
        $adherents = Candidature::where('cohort_id', $cohort->id)->where('partner_technical_id', $partner->id)->where('resignation', '0')->get();
        return view('dashboard.cohort.partner.training.create', [
            'cohort' => $cohort,
            'adherents' => $adherents,
        ]);
    }

    public function store(Request $request, int $id)
    {
        $partner = $this->partner();
        $cohort = Cohort::findOrFail($id);

        $attrs = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'beging_date' => 'required|date',
            'participation' => 'required|in:all,selected',
            'adherents_id' => 'nullable|array',
        ]);

        if ($request->participation != 'all' && !isset($attrs['adherents_id']))
            return back()->with('warning', 'Veuillez renseigner les personnes concernées.');
        else
            unset($attrs['adherents_id']);
        unset($attrs['participation']);

        $attrs['cohort_id'] = $cohort->id;
        $attrs['partner_technicial_id'] = $partner->id;

        
        if ($request->participation != 'all')
            foreach ($request->adherents_id as $idA)
                $adherents[] = Candidature::findOrFail($idA);
        else
            $adherents = Candidature::where('cohort_id', $cohort->id)->where('partner_technical_id', $partner->id)->where('resignation', '0')->get();
        if (count($adherents) == 0)
            return back()->with('warning', 'Plus de participant disponible');
        $training = Training::create($attrs);

        foreach ($adherents as $adherent)
            TrainingParticipation::create([
                'training_id' => $training->id,
                'candidature_id' => $adherent->id,
                'moment' => $adherent->data_collect ? 'post' : 'pre',
            ]);

        return to_route('cohort.training.index', $cohort->id)->with('success', 'Formation ajoutée avec succès.');
    }

    public function show(int $id)
    {

        $partner = $this->partner();
        $training = Training::findOrFail($id);
        $adherents = Candidature::where('cohort_id', $training->cohort->id)
            ->where('resignation', '0')
            ->where('partner_technical_id', $partner->id)
            ->where('data_collect', false)
            ->get();
        return view('dashboard.cohort.partner.training.edit', [
            'training' => $training,
            'adherents' => $adherents,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $partner = $this->partner();
        $training = Training::findOrFail($id);
        $request->validate([
            'update' => 'in:update,finished'
        ]);

        if ($training->status == 'finished' || $partner->id != $training->partner_technicial_id)
            return back()->with('warning', 'Formation déja terminée.');

        if ($request->update === 'update') {
            $attrs = $request->validate([
                'title' => 'required|string',
                'description' => 'nullable|string',
                'beging_date' => 'required|date',
                'participation' => 'required|in:all,selected',
                'adherents_id' => 'nullable|array'
            ]);

            if ($request->participation != 'all' && !isset($attrs['adherents_id']))
                return back()->with('warning', 'Veuillez renseigner les personnes concernées.');
            else
                unset($attrs['adherents_id']);
            unset($attrs['participation']);

            if ($request->participation != 'all')
                foreach ($request->adherents_id as $idA)
                    $adherents[] = Candidature::findOrFail($idA);
            else
                $adherents = Candidature::where('cohort_id', $training->cohort_id)->where('partner_technical_id', $partner->id)->where('data_collect', false)->where('resignation', '0')->get();

            $training->participations()->delete();

            foreach ($adherents as $adherent)
                TrainingParticipation::create([
                    'training_id' => $training->id,
                    'candidature_id' => $adherent->id,
                ]);
        } else {
            $attrs = $request->validate([
                'observation' => 'nullable|string',
                'end_date' => 'required|date',
                'adherents_id' => 'nullable|array',
                'file_presence' => 'required|mimes:pdf'
            ]);
            $attrs['status'] = 'finished';

            $fileName = uniqid() . '.pdf';

            $request->file_presence->move(saveByEnv() .  'data/docs/formation', $fileName);
            $filePath = 'data/docs/formation/' . $fileName;

            $attrs['file_presence'] = $filePath;

            foreach ($training->participations as $participation) {

                if (isset($attrs['adherents_id'])) {
                    if (in_array($participation->candidature_id, $attrs['adherents_id'])) {
                        $participation->participation = false;
                        $participation->save();
                    } else {
                        $can = Candidature::findOrFail($participation->candidature_id);
                        $can->training = true;
                        $can->save();
                    }
                } else {
                    $can = Candidature::findOrFail($participation->candidature_id);
                    $can->training = true;
                    $can->save();
                }
            }
        }

        $training->update($attrs);

        return to_route('cohort.training.index', $training->cohort_id)->with('success', 'Formation ' . $request->update === 'update' ? 'modifiée' : 'terminée' . ' avec succès.');
    }

    public function cohortPersonal()
    {

        authPermission('chef-cellule-formation-et-insertion|conseiller-auto-emploi|conseiller-fonction-public|conseiller-entreprise-prive|responsable-suivi-evaluation|assistant-suivi-evaluation|point-focal|chef-barm|c2d|memdef');

        $cohorts = Cohort::whereHas('adhrents')->get();

        return view('dashboard.cohort.cohort_personal', ['cohorts' => $cohorts]);
    }

    public function cohortPersonalTraining(int $id)
    {
        authPermission('chef-cellule-formation-et-insertion|conseiller-auto-emploi|conseiller-fonction-public|conseiller-entreprise-prive|responsable-suivi-evaluation|assistant-suivi-evaluation|point-focal|chef-barm|c2d|memdef');

        $cohort = Cohort::findOrFail($id);
        $trainings = Training::where('cohort_id', $cohort->id)->get();

        return view('dashboard.cohort.personal.training.index', [
            'cohort' => $cohort,
            'trainings' => $trainings,
        ]);
    }

    public function cohortPersonalTrainingShow(int $id)
    {

        // authPermission('partner-technical');

        $training = Training::findOrFail($id);
        $adherents = Candidature::where('cohort_id', $training->cohort->id)
            ->where('resignation', '0')
            ->where('data_collect', false)
            ->get();
        return view('dashboard.cohort.personal.training.show', [
            'training' => $training,
            'adherents' => $adherents,
        ]);
    }
}
