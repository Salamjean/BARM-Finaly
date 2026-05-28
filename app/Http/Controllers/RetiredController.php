<?php

namespace App\Http\Controllers;

use App\Models\Retired;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RetiredController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.retired.index');
    }

    public function datatables(Request $request)
    {
        if ($request->ajax()) {
            // Paramètres de pagination et recherche
            $draw = $request->get('draw');
            $start = $request->get('start', 0);
            $length = $request->get('length', 10);
            $search = $request->get('search')['value'] ?? '';
            $orderColumn = $request->get('order')[0]['column'] ?? 0;
            $orderDir = $request->get('order')[0]['dir'] ?? 'desc';

            // Colonnes pour le tri
            $columns = [
                'year',
                'grade',
                'mecano',
                'matricule',
                'firstname',
                'lastname',
                'birth_date',
                'gender',
                'unit',
                'army',
                'retired_date',
                'retired_type',
                'status'
            ];

            $query = Retired::query();

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('firstname', 'LIKE', "%{$search}%")
                        ->orWhere('lastname', 'LIKE', "%{$search}%")
                        ->orWhere('grade', 'LIKE', "%{$search}%")
                        ->orWhere('mecano', 'LIKE', "%{$search}%")
                        ->orWhere('matricule', 'LIKE', "%{$search}%")
                        ->orWhere('unit', 'LIKE', "%{$search}%")
                        ->orWhere('army', 'LIKE', "%{$search}%");
                });
            }

            // Tri
            if (isset($columns[$orderColumn])) {
                $query->orderBy($columns[$orderColumn], $orderDir);
            } else {
                $query->orderByDesc('created_at');
            }

            $totalRecords = Retired::count();
            $filteredRecords = $query->count();

            $retired = $query->skip($start)->take($length)->get();

            $data = [];
            foreach ($retired as $item) {
                $data[] = [
                    'year' => $item->year ?? '-',
                    'grade' => $item->grade ?? '-',
                    'mecano' => '<strong>' . ($item->mecano ?? '-') . '</strong>',
                    'matricule' => $item->matricule ?? '-',
                    'firstname' => strtoupper($item->firstname ?? '-'),
                    'lastname' => ucwords(strtolower($item->lastname ?? '-')),
                    'birth_date' => $item->birth_date ? $this->formatDateFr($item->birth_date) : '-',
                    'gender' => $this->formatGender($item->gender),
                    'unit' => $item->unit ?? '-',
                    'army' => '<span class="badge bg-secondary">' . strtoupper($item->army ?? '-') . '</span>',
                    'retired_date' => $item->retired_date ? $this->formatDateFr($item->retired_date) : '-',
                    'retired_type' => $item->retired_type ?? '-',
                    'status' => $this->formatStatus($item->used),
                    'authorization' => $this->formatAuthorization($item),
                    'actions' => $this->formatActions($item)
                ];
            }

            return response()->json([
                'draw' => intval($draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data
            ]);
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }

    private function formatDateFr($date)
    {
        // Remplacez par votre fonction dateFr() si elle existe
        return \Carbon\Carbon::parse($date)->format('d/m/Y');
    }

    private function formatGender($gender)
    {
        if ($gender == 'M') {
            return '<i class="bx bx-male text-primary"></i> Masculin';
        } elseif ($gender == 'F') {
            return '<i class="bx bx-female text-danger"></i> Féminin';
        } else {
            return '-';
        }
    }

    private function formatStatus($used)
    {
        if ($used) {
            return '<span class="status-badge status-adherent"><i class="bx bx-check-circle"></i> Adhérent</span>';
        } else {
            return '<span class="status-badge status-pas-adherent"><i class="bx bx-x-circle"></i> Pas adhérent</span>';
        }
    }

    private function formatAuthorization($retired)
    {
        if ($retired->forced_authorization && $retired->file_authorization) {
            return '<a title="Télécharger la fiche d\'autorisation" href="' . asset($retired->file_authorization) . '" class="btn btn-sm btn-outline-primary" download><i class="bx bx-cloud-download"></i></a>';
        } else {
            return '<span class="text-muted">-</span>';
        }
    }

    private function formatActions($retired)
    {
        $actions = '<div class="btn-group" role="group">';

        if (!$retired->used && $this->canUser('chef-cellule-formation-et-insertion|conseiller-auto-emploi')) {
            $actions .= '<button data-bs-toggle="modal" data-bs-target="#editModal" class="editBtn btn btn-sm btn-outline-primary" title="Modifier" data-retired="' . htmlspecialchars(json_encode($retired)) . '" data-action="' . route('retired.update', $retired->id) . '"><i class="bx bx-edit-alt"></i></button>';
        }

        if (
            !$retired->used &&
            $retired->retired_date &&
            \Carbon\Carbon::parse($retired->retired_date)->lt(\Carbon\Carbon::now()->subYears(2)) &&
            !$retired->forced_authorization &&
            $this->canUser('chef-cellule-formation-et-insertion|conseiller-auto-emploi')
        ) {
            $actions .= '<button title="Ajouter une fiche d\'autorisation" data-bs-toggle="modal" data-bs-target="#editAuthModal" class="editAuthBtn btn btn-sm btn-outline-warning" data-retired="' . htmlspecialchars(json_encode($retired)) . '" data-action="' . route('retired.update.forced', $retired->id) . '"><i class="bx bx-lock-open"></i></button>';
        }

        $actions .= '</div>';

        return $actions;
    }

    private function canUser($roles)
    {
        // Remplacez par votre logique d'autorisation
        // Par exemple : return auth()->user()->hasAnyRole($roles);
        return true; // Temporaire - à adapter selon votre système d'autorisation
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        authPermission('chef-cellule-formation-et-insertion|conseiller-auto-emploi|conseiller-entreprise-prive|conseiller-fonction-public');
        $attrs = $request->validate([
            'mecano' => 'required|unique:retireds,mecano',
            'matricule' => 'nullable|unique:retireds,matricule',
            'grade' => 'required|string',
            'gender' => 'required|string',
            'army' => 'required|string',
            'unit' => 'required|string',
            'firstname' => 'required',
            'lastname' => 'required',
            'birth_date' => 'required',
            'retired_date' => 'required',
            'retired_type' => 'required|string',
        ]);

        $attrs['year'] = date('Y');
        $attrs['personal_id'] = auth()->user()->personnel->id;

        if(!isset($attrs['matricule']))
            $attrs['matricule'] = null;

        Retired::create($attrs);

        return back()->with('success', 'Rétraité enregistré avec succès.');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $attrs = $request->validate([
            'mecano' => 'required|unique:retireds,mecano,' . $id,
            'matricule' => 'nullable|unique:retireds,matricule,' . $id,
            'grade' => 'required|string',
            'gender' => 'required|string',
            'army' => 'required|string',
            'unit' => 'required|string',
            'firstname' => 'required',
            'lastname' => 'required',
            'birth_date' => 'required',
            'retired_date' => 'required',
            'retired_type' => 'required|string',
        ]);

        $retired = Retired::findOrFail($id);
        $attrs['personal_id'] = auth()->user()->personnel->id;

        $retired->update($attrs);

        return back()->with('success', 'Données de rétraité avec succès.');
    }

    public function forced(Request $request, string $id)
    {
        $retired = Retired::findOrFail($id);

        $attrs = $request->validate([
            'file_authorization' => 'required|file|mimes:pdf',
        ]);

        $file = time() . '.' . $attrs['file_authorization']->getClientOriginalExtension();
        $attrs['file_authorization']->move(saveByEnv() . "data/docs/file_authorization/", $file);
        $attrs['file_authorization'] = 'data/docs/file_authorization/' . $file;
        $attrs['forced_authorization'] = true;

        $retired->update($attrs);
        return back()->with('success', 'Document insérer avec succès.');

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
