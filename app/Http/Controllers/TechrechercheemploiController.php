<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Techrechercheemploi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TechrechercheemploiController extends Controller
{
    /**
     * Liste des candidats pour les Techniques de Recherche d'Emploi (TRE)
     */
    public function candidats(Request $request)
    {
        $candidats = Candidature::where('death', '0')
            ->where('resignation', '0')
            ->where('orientation', 'entreprise-privee')
            ->whereHas('cvlms')
            ->whereHas('prepaentretiens')
            ->with([
                'user',
                'cvlms',
                'prepaentretiens',
                'techrechercheemplois' => function ($q) {
                    $q->orderByDesc('created_at');
                }
            ])
            ->get()
            ->sortBy(function ($candidat) {
                return mb_strtolower($candidat->user ? $candidat->user->fullName() : '');
            }, SORT_NATURAL | SORT_FLAG_CASE);

        $title = "Techniques de recherche d'emploi";

        return view('dashboard.techrechercheemploi.candidats', compact('candidats', 'title'));
    }

    /**
     * Enregistrer / Clôturer la Technique de Recherche d'Emploi pour un candidat
     */
    public function cloturer(Request $request)
    {
        try {
            $this->validate($request, [
                'candidature_id' => 'required|exists:candidatures,id',
                'date' => 'required|date',
                'presence' => 'required|in:0,1,2',
                'commentaire' => 'nullable|string',
            ]);

            // Enregistrer ou mettre à jour la séance de TRE
            $tre = Techrechercheemploi::create([
                'candidature_id' => $request->candidature_id,
                'date' => $request->date,
                'presence' => (int) $request->presence,
                'commentaire' => $request->commentaire,
                'autor_id' => Auth::id(),
            ]);

            $statutLibelle = match ((int) $request->presence) {
                1 => 'validée / réalisée',
                2 => 'marquée comme abandon',
                default => 'marquée comme non réalisée / absent',
            };

            return back()->with('success', "Technique de recherche d'emploi $statutLibelle avec succès.");
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput()->with('error', 'Veuillez vérifier les informations saisies.');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de l\'enregistrement : ' . $e->getMessage());
        }
    }

    /**
     * Supprimer une entrée de TRE
     */
    public function destroy(Request $request, string $id)
    {
        try {
            authPermission('chef-cellule-formation-et-insertion');

            $tre = Techrechercheemploi::findOrFail($id);
            $tre->delete();

            return back()->with('success', 'Enregistrement supprimé avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Impossible de supprimer cet enregistrement.');
        }
    }
}
