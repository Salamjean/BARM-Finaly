<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InformationStoreRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Informations;
use Illuminate\Validation\ValidationException;
use App\Models\Role;


class InfoController extends Controller
{

    public function index()
    {
        $title = 'Historique';
        $infos = Informations::orderBy('created_at', 'desc')->get();

        return view('dashboard.informations.index', compact('title', 'infos'));
    }

    public function create()
    {
        $title = 'Ajouter une information';
        $allRoles = Role::orderBy('created_at', 'asc')->get();

        $idIndex = $allRoles->search(function ($role) {
            return $role->id == 3;
        });

        if ($idIndex!== false) {
            $rolesAfterId4 = $allRoles->slice($idIndex + 1);
        } else {
            $rolesAfterId4 = collect([]);
        }

        return view('dashboard.informations.create', compact('title', 'rolesAfterId4'));
    }

    public function store(InformationStoreRequest $request)
    {
        $ref = 'INFO-'. rand(100, 999);

        $information = Informations::create([
            'ref' => $ref,
            'title' => $request->title,
            'destinataire' => $request->destinataire,
            'contenu' => $request->contenu,
            'fileAttachment' => $request->file('fileAttachment'),
        ]);

        $name = null;
        $fileAttachment = $request->file('fileAttachment');

        if ($fileAttachment != null) {
            $name = $fileAttachment->getClientOriginalName();
            $destinationPath = saveByEnv() .  '/assets/faces/';
            $fileAttachment->move($destinationPath, $name);
        } else {
            $name = null;
        }

        return redirect()->route('info.histo')->with('success', 'La formation du bénéficiaire a bien été enregistrée avec succès!');
    }

    public function status($id)
    {
        $information = Informations::findOrFail($id);
        $information->update([
            'status' => $information->status == 0 ? 1 : 0,
        ]);

        return back()->with('success', "Statut d'information changé avec succès.");
    }

    public function editInfo($id)
    {
        $title = 'Modification d\'une information';
        $infos = Informations::where('id', $id)->first();

        $allRoles = Role::orderBy('created_at', 'asc')->get();

        $idIndex = $allRoles->search(function ($role) {
            return $role->id == 3;
        });

        if ($idIndex!== false) {
            $rolesAfterId4 = $allRoles->slice($idIndex + 1);
        } else {
            $rolesAfterId4 = collect([]);
        }


        return view('dashboard.informations.edit', compact('title', 'infos','rolesAfterId4'));
    }

    public function updateInfo(Request $request, $id)
    {
        $infos = Informations::findOrFail($id);

        $messages = [
            'title.required' => 'Le titre est obligatoire.',
            'title.min' => 'Le titre doit avoir au minimum :min caractères',
            'title.max' => 'Le titre doit avoir au maximum :max caractères',
            'contenu.required' => 'Le message est obligatoire.',
            'contenu.min' => 'Le message doit avoir au minimum :min caractères',
            'contenu.max' => 'Le message doit avoir au maximum :max caractères',
        ];

        $rules = [
            'title' => 'required|min:3|max:15',
            'contenu' => 'required|min:3|max:5000',
            'fileAttachment' => 'nullable|mimes:jpg,jpeg,png,gif|max:2048',
            'destinataire' => 'nullable',
        ];

        $validatedData = $request->validate($rules, $messages);
        $name = null;
        $fileAttachment = $request->file('fileAttachment');

        if ($fileAttachment != null) {
            $name = $fileAttachment->getClientOriginalName();
            $destinationPath = saveByEnv() .  '/assets/faces/';
            $fileAttachment->move($destinationPath, $name);
        } else {
            $name = null;
        }

        $infos->update([
            'title' => $validatedData['title'],
            'destinataire' => $validatedData['destinataire'],
            'contenu' => $validatedData['contenu'],
            'fileAttachment' => $name?? null,
        ]);

        return redirect()->route('info.histo')->with('success', 'Information modifiée avec succès!');
    }

    public function deleteInfo($id)
    {
        $infos = Informations::findOrFail($id);
        $infos->delete();

        return redirect()->route('info.histo')->with('success', 'Information supprimée avec succès !');
    }
}
