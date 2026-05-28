<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\ChoiceFinalAdherent;
use App\Models\FormationBeneficiaires;
use Illuminate\Http\Request;

class ValidationCandidatureController extends Controller
{

    public function __construct(){
        $this->middleware('role:chef-barm');
    }

    public function pending()
    {

        $title = 'Validation en cours';
        $candidatures = Candidature::whereHas('choiceFinal')->where('status', 'pending')->get();

        return view('dashboard.adherent.validation.list', ['candidatures' => $candidatures, 'title' => $title]);
    }

    

    public function list()
    {

        $title = 'Liste';
        $candidatures = Candidature::where('status', '!=', 'pending')->get();

        return view('dashboard.adherent.validation.list', ['candidatures' => $candidatures, 'title' => $title]);
    }

    public function show(int $id)
    {

        $title = 'Validation de choix';

        $choiceFinal = ChoiceFinalAdherent::findOrFail($id);
        return view('dashboard.adherent.validation.show', ['choice' => $choiceFinal, 'title' => $title]);
    }

    public function status(int $id, string $status)
    {

        $choiceFinal = ChoiceFinalAdherent::findOrFail($id);

        $can = $choiceFinal->candidature;

        if (in_array($status, ['accepted', 'refused', 'pending']))
            $can->status = $status;

        $can->save();

        if($can->status === 'accepted' && $can->orientation === 'auto-emploi'){
            $training = FormationBeneficiaires::where('candidature_id', $can->id)->first();

            if ($training)
                $training->delete();

            FormationBeneficiaires::create([
                'reference' => 'F-' . rand(100000, 999999),
                'operateur_id' => auth()->user()->id,
                'candidature_id' => $can->id,
                'partner_id' => $choiceFinal->partner_id,
                'orientation' => $can->orientation,
                'formation' => 'Oui',
            ]);
        }

        $message = 'Candidature ';
        $message .= ($status == 'accepted') ? 'acceptée' :  'refusée' ;
        $message .= ' avec succès.';

        return back()->with('success', $message);

    }
}
