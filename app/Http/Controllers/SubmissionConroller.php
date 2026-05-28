<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use App\Models\Submission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Repositories\SmsRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SubmissionConroller extends Controller
{

    public function liste_attente()
    {
        $liste_attentes = Submission::where('status', 'pending')->get();

        return view('dashboard.candidats.liste_attente', compact('liste_attentes'));
    }

    public function liste_admis()
    {
        $liste_admis = Submission::where('status', 'accepted')->get();

        return view('dashboard.candidats.liste_admis', compact('liste_admis'));
    }

    public function liste_refus()
    {
        $liste_refus = Submission::where('status', 'refused')->get();

        return view('dashboard.candidats.liste_refus', compact('liste_refus'));
    }

    public function accepte_candidature(Submission $submission)
    {
        try {
            $motDePasse = Str::random(8);

            $submission->status = 'accepted';
            $submission->save();

            $user = User::findOrFail($submission->user_id);
            $user->status = '1';
            $user->password = Hash::make($motDePasse);
            $user->save();

            $message = "Votre candidature a été acceptée. Voici votre mot de passe : $motDePasse";

            $res = (new SmsRepository($submission->phone_number, $message))->send();

            return redirect()->route('candidature.liste_attente')->with("success", 'Candidature acceptée');
        } catch (ValidationException $e) {
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde. Message d\'erreur : ' . $e->getMessage());
        }
    }

    public function refuse_candidature(Submission $submission)
    {
        try {
            $submission->status = 'refused';
            $submission->save();

            $message = "Votre candidature à été refusée.";

            $res = (new SmsRepository($submission->phone_number, $message))->send();

            return redirect()->route('candidature.liste_attente')->with("success", 'Candidature refusée');
        } catch (ValidationException $e) {
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }
}
