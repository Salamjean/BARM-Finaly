<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\FormationBeneficiaires;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Throwable;

class ChoiceFinalController extends Controller
{
    public function news(): View
    {
        $title = "Liste des choix approuvés";
        $candidatures = Candidature::whereDoesntHave('formationBeneficiaire')->where('status', 'accepted')->get();

        return view('dashboard.beneficiaires.list', compact('title', 'candidatures'));
    }

    public function refused(): View
    {
        $title = "Choix réfusés par le chef BARM ";
        $candidatures = Candidature::whereStatus('refused')->get();

        return view('dashboard.beneficiaires.list', compact('title', 'candidatures'));
    }

    public function show(int $id)
    {
        $title = "Détail sur le choix du candidat";
        $candidature = Candidature::findOrFail($id);
        return view('dashboard.beneficiaires.formations.create', compact('title', 'candidature'));
    }

    public function remake(int $id): View
    {
        $title = "Stabilisation du choix";
        $candidature = Candidature::findOrFail($id);

        return view('dashboard.adherent.remake_choice_final', compact('title', 'candidature'));
    }
}
