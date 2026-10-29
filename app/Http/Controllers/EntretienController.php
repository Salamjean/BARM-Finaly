<?php

namespace App\Http\Controllers;

use App\Models\Candidatentretien;
use App\Models\Candidature;
use App\Models\CandidatureControl;
use App\Models\Cohort;
use App\Models\Entretien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;

class EntretienController extends Controller
{

    public function candidats(Entretien $entretien)
    {
        $candidats = Candidatentretien::orderByDESC('created_at')
            ->where('entretien_id', $entretien->id)
            ->with(['candidature.user'])
            ->get();

        $title = 'Liste des candidats - BARM';

        return view('dashboard.entretien.candidats', compact('candidats', 'title', 'entretien'));
    }

    public function index(Request $request, String $type)
    {
        $entretiens = Entretien::orderByDESC('date')
            ->orderByDESC('created_at')
            ->where('parcours', 'entreprise_privee')
            ->where('type', $type)
            ->with(['candidatentretiens.candidature.user'])
            ->get();

        $title = 'Liste des entretiens - BARM';

        return view('dashboard.entretien.index', compact('entretiens', 'title', 'type'));
    }

    public function indexfp(Request $request, String $type)
    {
        $entretiens = Entretien::orderByDESC('date')
            ->orderByDESC('created_at')
            ->where('parcours', 'fonction_public')
            ->where('type', $type)
            ->with(['candidatentretiens.candidature.user'])
            ->get();

        $title = 'Liste des entretiens - BARM';

        return view('dashboard.entretien.indexfp', compact('entretiens', 'title', 'type'));
    }

    public function create(Request $request, String $type)
    {
        $title = 'Programmer un pré-entretien - BARM';

        $candidats = Candidature::where('death', '0')
            ->where('resignation', '0')
            ->where('orientation', 'entreprise-privee')
            ->with(['user', 'candidatentretiens'])
            ->get()
            ->sortBy(function ($candidat) {
                return mb_strtolower($candidat->user ? $candidat->user->fullName() : '');
            }, SORT_NATURAL | SORT_FLAG_CASE);

        return view('dashboard.entretien.create', compact('title', 'candidats', 'type'));
    }

    // create entretien fonction public
    public function createfp(Request $request, String $type)
    {
        $title = 'Programmer un pré-entretien - BARM';

        $candidats = Candidature::where('death', '0')
            ->where('resignation', '0')
            ->where('orientation', 'fonction-publique')
            ->with(['user', 'candidatentretiens'])
            ->get()
            ->sortBy(function ($candidat) {
                return mb_strtolower($candidat->user ? $candidat->user->fullName() : '');
            }, SORT_NATURAL | SORT_FLAG_CASE);

        return view('dashboard.entretien.createfp', compact('title', 'candidats', 'type'));
    }

    public function store(Request $request)
    {
        try {
            // dd($request);

            $this->validate($request, [
                'date' => 'required|date',
                'candidatures' => 'required|exists:candidatures,id',
                'parcours' => 'required|string',
                'type' => 'required|string',
            ]);

            $entretien = Entretien::create([
                'date' => $request->date,
                'autor_id' => Auth::user()->id,
                'parcours' => $request->parcours,
                'type' => $request->type,
            ]);

            foreach ($request->candidatures as $key => $candidature) {
                $candidatentretien = Candidatentretien::create([
                    'entretien_id' => $entretien->id,
                    'candidature_id' => $candidature,
                ]);

                // Réinitialiser le profilage pour permettre une nouvelle décision suite à ce nouvel entretien
                Candidature::where('id', $candidature)->update([
                    'profilage_decision' => false,
                ]);
            }

            return redirect()->route('entretiens.index',$request->type)->with("success", 'Donnée enregistées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }

    }

    public function storefp(Request $request)
    {
        try {

            $this->validate($request, [
                'date' => 'required|date',
                'candidatures' => 'required|exists:candidatures,id',
                'parcours' => 'required|string',
                'type' => 'required|string',
            ]);

            $entretien = Entretien::create([
                'date' => $request->date,
                'autor_id' => Auth::user()->id,
                'parcours' => $request->parcours,
                'type' => $request->type,
            ]);

            foreach ($request->candidatures as $key => $candidature) {
                $candidatentretien = Candidatentretien::create([
                    'entretien_id' => $entretien->id,
                    'candidature_id' => $candidature,
                ]);

                // Réinitialiser le profilage pour permettre une nouvelle décision suite à ce nouvel entretien
                Candidature::where('id', $candidature)->update([
                    'profilage_decision' => false,
                ]);
            }

            return  redirect()->route('entretiens.indexfp',$request->type)->with("success", 'Donnée enregistées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }

    }

    public function destroy(Request $request, string $id)
    {
        $entretien = Entretien::findOrFail($id);
        $entretien->candidatentretiens()->delete();
        $entretien->delete();

        return response()->json(['success' => true]);
    }

    public function destroy_candidatentretiens(Request $request, string $id)
    {

        authPermission('chef-cellule-formation-et-insertion');

        $candidatentretien = Candidatentretien::findOrFail($id);

        CandidatureControl::create([
            'user_id' => auth()->id(),
            'adherent_id' => $candidatentretien->candidature_id,
            'type' => 'deleted',
            'table' => 'candidatentretiens',
            'data' => json_encode($candidatentretien),
        ]);

        $candidatentretien->delete();

        return response()->json(['success' => true]);
    }

    public function presence(Request $request)
    {
        try {
            $this->validate($request, [
                'presence' => 'required|int',
                'comment' => 'nullable|string',
                'candidatentretien_id' => 'required',
            ]);

            $candidatentretien = Candidatentretien::findOrFail($request->candidatentretien_id);

            $candidatentretien->update([
                'presence' => $request->presence,
                'comment' => $request->comment,
            ]);

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Statut de l\'entretien mis à jour avec succès']);
            }

            return back()->with("success", 'Statut de l\'entretien mis à jour avec succès');
        } catch (ValidationException $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Erreur de validation des données'], 422);
            }
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return back()->with("error", 'Un problème est survenu : ' . $e->getMessage());
        }
    }

    public function show(Request $request, Entretien $entretien)
    {
        return view('dashboard.entretien.show', compact('entretien'));
    }

    public function edit(Request $request, Entretien $entretien)
    {
        return view('dashboard.entretien.edit', compact('entretien'));
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'date' => 'required|date',
            ]);

            $entretien = Entretien::findOrFail($id);
            $entretien->update([
                'date' => $request->date,
            ]);

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Date de l\'entretien mise à jour avec succès']);
            }

            return back()->with("success", 'Date de l\'entretien mise à jour avec succès');
        } catch (ValidationException $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'La date saisie n\'est pas valide'], 422);
            }
            return back()->with("error", 'La date saisie n\'est pas valide');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return back()->with("error", 'Un problème est survenu lors de la mise à jour');
        }
    }

    public function updateCandidatentretienComment(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'comment' => 'nullable|string',
            ]);

            $candidatentretien = Candidatentretien::findOrFail($id);

            $candidatentretien->update([
                'comment' => $request->comment,
            ]);

            return back()->with("success", 'Commentaire modifié avec succès');
        } catch (ValidationException $e) {
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            return back()->with("error", 'Un problème est survenu lors de la mise à jour');
        }
    }
}
