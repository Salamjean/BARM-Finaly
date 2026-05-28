<?php

namespace App\Http\Controllers;

use App\Exports\CandidaturesExport;
use App\Http\Resources\CandidatureResource;
use App\Models\Candidature;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard.search.index');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $orientation = $request->input('orientation');
        $date_start = $request->input('date_start');
        $date_end = $request->input('date_end');
        $date_entree_debut = $request->input('date_entree_debut');
        $date_entree_fin = $request->input('date_entree_fin');
        $date_radiation_debut = $request->input('date_radiation_debut');
        $date_radiation_fin = $request->input('date_radiation_fin');
        $condition_admin = $request->input('condition_admin');
        $condition_financiere = $request->input('condition_financiere');
        $grade = $request->input('grade');
        $armee = $request->input('armee');

        $query = Candidature::query();

        $query->where(function ($q) use ($search) {
            $q->whereHas('user', function ($q2) use ($search) {
                $q2->where('firstname', 'like', '%' . $search . '%')
                    ->orWhere('lastname', 'like', '%' . $search . '%')
                    ->orWhere('mecano', 'like', '%' . $search . '%')
                    ->orWhere('matricule', 'like', '%' . $search . '%');
            })
                ->orWhereHas('diplomes', function ($q2) use ($search) {
                    $q2->where('diplome', 'like', '%' . $search . '%');
                })
                ->orWhereHas('jobs', function ($q2) use ($search) {
                    $q2->where('fonction', 'like', '%' . $search . '%');
                })
                ->orWhere(function ($q2) use ($search) {
                    $q2->where('no_card', 'like', '%' . $search . '%')
                        ->orWhere('orientation', 'like', '%' . $search . '%')
                        ->orWhere('cgrae_no', 'like', '%' . $search . '%')
                        ->orWhere('phone_number', 'like', '%' . $search . '%')
                        ->orWhere('gender', 'like', '%' . $search . '%')
                        ->orWhere('domaine_1c', 'like', '%' . $search . '%')
                        ->orWhere('domaine_2c', 'like', '%' . $search . '%')
                        ->orWhere('condition_financiere', 'like', '%' . $search . '%');
                });
        });

        if ($orientation)
            $query->where('orientation', $orientation);

        if ($armee)
            $query->where('armee', $armee);

        if ($grade)
            $query->where('grade', $grade);

        if ($condition_admin)
            $query->where('condition_admin', $condition_admin);

        if ($condition_financiere)
            $query->whereRaw('JSON_SEARCH(condition_financiere, "one", ?) IS NOT NULL', [$condition_financiere]);


        if ($date_start && $date_end)
            $query->whereBetween('date_inscription', [$date_start, $date_end]);
        elseif ($date_start)
            $query->where('date_inscription', '>=', $date_start);
        elseif ($date_end)
            $query->where('date_inscription', '<=', $date_end);

        // Période d'entrée
        if ($date_entree_debut && $date_entree_fin) {
            $query->whereHas('user', function ($q) use ($date_entree_debut, $date_entree_fin) {
                $q->whereBetween('date_entree', [$date_entree_debut, $date_entree_fin]);
            });
        } elseif ($date_entree_debut) {
            $query->whereHas('user', function ($q) use ($date_entree_debut) {
                $q->where('date_entree', '>=', $date_entree_debut);
            });
        } elseif ($date_entree_fin) {
            $query->whereHas('user', function ($q) use ($date_entree_fin) {
                $q->where('date_entree', '<=', $date_entree_fin);
            });
        }

        if ($date_radiation_debut && $date_radiation_fin) {
            $query->whereHas('user', function ($q) use ($date_radiation_debut, $date_radiation_fin) {
                $q->whereBetween('date_radiation', [$date_radiation_debut, $date_radiation_fin]);
            });
        } elseif ($date_radiation_debut) {
            $query->whereHas('user', function ($q) use ($date_radiation_debut) {
                $q->where('date_radiation', '>=', $date_radiation_debut);
            });
        } elseif ($date_radiation_fin) {
            $query->whereHas('user', function ($q) use ($date_radiation_fin) {
                $q->where('date_radiation', '<=', $date_radiation_fin);
            });
        }

        $items = $query->with(['user', 'diplomes'])->where('step', 'completed')->take(100)->get();

        return response()->json(CandidatureResource::collection($items));
    }




    public function export(Request $request)
    {

        $fields = $request->input('fields', []);
        $search = $request->input('search');
        $orientation = $request->input('orientation');
        $date_start = $request->input('date_start');
        $date_end = $request->input('date_end');
        $date_entree_debut = $request->input('date_entree_debut');
        $date_entree_fin = $request->input('date_entree_fin');
        $date_radiation_debut = $request->input('date_radiation_debut');
        $date_radiation_fin = $request->input('date_radiation_fin');
        $condition_admin = $request->input('condition_admin');
        $condition_financiere = $request->input('condition_financiere');
        $grade = $request->input('grade');
        $armee = $request->input('armee');

        $query = Candidature::query();

        $query->where(function ($q) use ($search) {
            $q->whereHas('user', function ($q2) use ($search) {
                $q2->where('firstname', 'like', '%' . $search . '%')
                    ->orWhere('lastname', 'like', '%' . $search . '%')
                    ->orWhere('mecano', 'like', '%' . $search . '%')
                    ->orWhere('matricule', 'like', '%' . $search . '%');
            })
                ->orWhereHas('diplomes', function ($q2) use ($search) {
                    $q2->where('diplome', 'like', '%' . $search . '%');
                })
                ->orWhereHas('jobs', function ($q2) use ($search) {
                    $q2->where('fonction', 'like', '%' . $search . '%');
                })
                ->orWhere(function ($q2) use ($search) {
                    $q2->where('no_card', 'like', '%' . $search . '%')
                        ->orWhere('orientation', 'like', '%' . $search . '%')
                        ->orWhere('cgrae_no', 'like', '%' . $search . '%')
                        ->orWhere('phone_number', 'like', '%' . $search . '%')
                        ->orWhere('gender', 'like', '%' . $search . '%')
                        ->orWhere('domaine_1c', 'like', '%' . $search . '%')
                        ->orWhere('domaine_2c', 'like', '%' . $search . '%')
                        ->orWhere('condition_financiere', 'like', '%' . $search . '%');
                });
        });

        if ($orientation)
            $query->where('orientation', $orientation);

        if ($condition_admin)
            $query->where('condition_admin', $condition_admin);
        
        if ($grade)
            $query->where('grade', $grade);

        if ($armee)
            $query->where('armee', $armee);

        if ($condition_financiere)
            $query->whereRaw('JSON_SEARCH(condition_financiere, "one", ?) IS NOT NULL', [$condition_financiere]);

        if ($date_start && $date_end)
            $query->whereBetween('date_inscription', [$date_start, $date_end]);
        elseif ($date_start)
            $query->where('date_inscription', '>=', $date_start);
        elseif ($date_end)
            $query->where('date_inscription', '<=', $date_end);

        if ($date_entree_debut && $date_entree_fin) {
            $query->whereHas('user', function ($q) use ($date_entree_debut, $date_entree_fin) {
                $q->whereBetween('date_entree', [$date_entree_debut, $date_entree_fin]);
            });
        } elseif ($date_entree_debut) {
            $query->whereHas('user', function ($q) use ($date_entree_debut) {
                $q->where('date_entree', '>=', $date_entree_debut);
            });
        } elseif ($date_entree_fin) {
            $query->whereHas('user', function ($q) use ($date_entree_fin) {
                $q->where('date_entree', '<=', $date_entree_fin);
            });
        }

        if ($date_radiation_debut && $date_radiation_fin) {
            $query->whereHas('user', function ($q) use ($date_radiation_debut, $date_radiation_fin) {
                $q->whereBetween('date_radiation', [$date_radiation_debut, $date_radiation_fin]);
            });
        } elseif ($date_radiation_debut) {
            $query->whereHas('user', function ($q) use ($date_radiation_debut) {
                $q->where('date_radiation', '>=', $date_radiation_debut);
            });
        } elseif ($date_radiation_fin) {
            $query->whereHas('user', function ($q) use ($date_radiation_fin) {
                $q->where('date_radiation', '<=', $date_radiation_fin);
            });
        }

        $results = $query->get();

        $exportData = $results->map(function ($item) use ($fields) {
            $row = [];

            foreach ($fields as $field) {
                switch ($field) {
                    case 'orientation':
                        $row['Orientation'] = $item->orientation ?? '';
                        break;
                    case 'mecano':
                        $row['Mecano'] = (string)$item->user->mecano ?? '';
                        break;
                    case 'cgrae_no':
                        $row['N° CGRAE'] = $item->cgrae_no ?? '';
                        break;
                    case 'type_piece':
                        $row['Type de pièce'] = $item->type_piece ?? '';
                        break;
                    case 'no_card':
                        $row['Numéro de pièce'] = $item->no_card ?? '';
                        break;
                    case 'firstname':
                        $row['Nom'] = $item->user->firstname ? strtoupper($item->user->firstname) : '';
                        break;
                    case 'lastname':
                        $row['Prénoms'] = $item->user->lastname ? ucfirst(strtolower($item->user->lastname)) : '';
                        break;
                    case 'armee':
                        $row['Armée ou Arme'] = $item->armee;
                        break;
                    case 'grade':
                        $row['Grade'] = $item->grade;
                        break;
                    case 'birth_date':
                        $row['Date de naissance'] = dateFr($item->birth_date);
                        break;
                    case 'phone_number':
                        $row['Téléphone'] = $item->phone_number ?? '';
                        break;
                    case 'condition_admin':
                        $row['Condition administrative'] = $item->condition_admin ?? '';
                        break;
                    case 'date_inscription':
                        $row['Date d\'inscription'] = $item->date_inscription ?? '';
                        break;
                }
            }

            return $row;
        });

        $fileName = 'export_adherents_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new CandidaturesExport($exportData), $fileName);
    }
}
