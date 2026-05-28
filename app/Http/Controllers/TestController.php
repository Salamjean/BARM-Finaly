<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Candidature;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TestController extends Controller
{

    public function partenairecandidat() 
    {
        $authpermission = Auth::user()->permissions->first();

        $user = User::whereHas('permissions', function (Builder $query) {
            $query->where('slug', 'like', 'partner-technical%');
        })->get();

        $candidats = Candidature::where('step','completed')->where('orientation', 'auto-emploi')->get();

        $partenairecandidats = $candidats->filter(function ($candidat) use ($authpermission) {
            return $candidat->partenaires()->whereIn('user_id', $authpermission->pluck('id'))->exists();
        });

        $title = 'Liste des adhérents - BARM';

        return view('dashboard.candidats.partenaire_candidats', compact('partenairecandidats', 'title'));
    }

    public function candidatchoosepartenaire(Request $request, $id)
    {
        $candidat = Candidature::findOrFail($id);

        if ($candidat->orientation == 'auto-emploi') {
            $users = User::whereHas('permissions', function (Builder $query) {
                $query->where('slug', 'like', 'partner-technical%');
            })->get();
        } elseif ($candidat->orientation == 'fonction-public') {
            # code...
        } elseif($candidat->orientation == 'entreprise-privee') {
            # code...
        }

        return view('dashboard.manage_users.partenaires.candidatchoose', compact('candidat'));
    }

    public function associatpartenairecandidat(Request $request, $id)
    {

        try {
            $candidature = Candidature::findOrFail($id)->first();

            $candidature->partenaires()->sync($request->partenaires);

            return back()->with("success", 'Partenaire modifier');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    public function prisecontact(Request $request, $id)
    {
        try {
            $candidature = Candidature::findOrFail($id)->first();

            $this->validate($request, [
                'methode_prise_contact' => 'required|string',
                'commentaire' => 'nullable|string',
            ]);

            $candidature->update($request->all());

            return back()->with("success", 'Donnée enregistrée');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    public function presence(Request $request, $id)
    {
        try {
            $candidature = Candidature::findOrFail($id)->first();

            $this->validate($request, [
                'presence' => 'required|boolean',
            ]);

            $candidature->update($request->all());

            return back()->with("success", 'Donnée enregistrée');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    public function partenaire_choose_candidate(Request $request, $id)
    {

        try {
            $candidature = Candidature::findOrFail($id)->first();

            $candidature->partenaires()->sync($request->partenaires);

            return back()->with("success", 'Candidature acceptée');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }
}
