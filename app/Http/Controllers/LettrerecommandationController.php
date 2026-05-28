<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use Illuminate\Http\Request;
use App\Models\Lettrerecommandation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LettrerecommandationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lettres = Lettrerecommandation::all();

        $title = 'Lettres de recommandation';

        return view('dashboard.lettrerecommandation.index', compact('lettres', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Faire une demande';

        $candidats = Candidature::orderByDESC('created_at')
        ->where('death', false)
            ->where('disbursement', false)
            ->where('resignation', false)
            ->where('en_poste','0')
            ->where('admissionconcours','0')
            ->get();

        return view('dashboard.lettrerecommandation.create', compact('candidats', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // dd($request);

            $validator = Validator::make($request->all(), [
                'date_demande' => 'nullable|date',
                'candidature_id' => 'required|exists:candidatures,id',
                'commentaire' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $lettre = Lettrerecommandation::create([
                'date_demande' => $request->date_demande,
                'candidature_id' => $request->candidature_id,
                'autor_id' => Auth::user()->id,
            ]);

            return redirect()->route('lettresrecommandations.index', $request->type)->with("success", 'Donnée enregistées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    public function status(Request $request)
    {
        try {

            $this->validate($request, [
                'status' => 'required|int',
                'lettre_id' => 'required|exists:lettrerecommandations,id',
                'commentaire' => 'nullable|string',
            ]);

            $lettre = Lettrerecommandation::findOrFail($request->lettre_id);

            $filePath = null;

            if ($request->hasFile('lettre')) {
                $fileName = uniqid('lettre_') . '.' . $request->file('lettre')->getClientOriginalExtension();
                $request->lettre->move('data/docs/lettre_recommandation', $fileName);
                $filePath = 'data/docs/lettre_recommandation/' . $fileName;
            }

            $lettre->update([
                'status' => $request->status,
                'commentaire' => $request->commentaire,
                'lettre' => $filePath,
            ]);

            return redirect()->route('lettresrecommandations.index')->with("success", 'Donnée modifiées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return $e->getMessage();
        }

    }
}
