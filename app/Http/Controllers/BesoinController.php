<?php

namespace App\Http\Controllers;

use App\Models\Besoin;
use Illuminate\View\View;
use App\Models\Besoinitem;
use App\Models\Consommable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\BesoinStoreRequest;
use App\Http\Requests\BesoinUpdateRequest;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Barryvdh\DomPDF\Facade\Pdf;

class BesoinController extends Controller
{
    public function index(Request $request)
    {

        $besoins = Besoin::where('user_id', Auth::user()->id)->get();

        $allbesoins = Besoin::all();

      

        return view('dashboard.besoin.index', compact('besoins','allbesoins'));
    }

    public function create(Request $request)
    {
        $consommables = Consommable::where('is_visible','1')->get();
        return view('dashboard.besoin.create', compact('consommables'));
    }

    public function store(Request $request)
    {
        
        try {
            $this->validate($request, [
                'libelle' => 'required|string',
                'user_id' => 'nullable|exists:users,id',
                'date' => 'nullable|string',
                'besoinitems' => 'array',
            ]);

            $besoin = Besoin::create($request->all());
            $besoinitemsData = $request->besoinitems;


            foreach ($besoinitemsData as $besoinitemData) {
                $besoinitem = Besoinitem::create([
                    'consommable_id' => $besoinitemData['consommable_id'],
                    'qte_demande' => $besoinitemData['qte_demande'],
                    'besoin_id' => $besoin->id,
                ]);
            }

            return redirect()->route('besoins.index')->with("success", 'Données enregistré');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    public function show(Request $request, Besoin $besoin)
    {
        return view('dashboard.besoin.show', compact('besoin'));
    }

    public function edit(Request $request, Besoin $besoin)
    {
        $consommables = Consommable::where('is_visible','1')->get();

        return view('dashboard.besoin.edit', compact('besoin','consommables'));
    }

    public function update(Request $request, Besoin $besoin)
    {

        try {
            $this->validate($request, [
                'libelle' => 'required|string',
                'user_id' => 'nullable|exists:users,id',
                'date' => 'nullable|string',
                'besoinitems' => 'array',
            ]);

            $besoin->update($request->all());
            $besoinitemsData = $request->besoinitems;

            foreach ($besoin->besoinitems as $besoinitem) {
                $besoinitem->delete();
            }

            foreach ($besoinitemsData as $besoinitemData) {
                $besoinitem = Besoinitem::create([
                    'consommable_id' => $besoinitemData['consommable_id'],
                    'qte_demande' => $besoinitemData['qte_demande'],
                    'besoin_id' => $besoin->id,
                ]);
            }

            return redirect()->route('besoins.index')->with("success", 'Données modifiées');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return $e->getMessage();
        }
    }

    public function destroy(Request $request, Besoin $besoin)
    {

        try {
            foreach ($besoin->besoinitems as $besoinitem) {
                $besoinitem->delete();
            }

            $besoin->delete();

            return redirect()->route("besoins.index")->with("success", 'Demande supprimé');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return back()->with("error", 'Un problème est survenu lors de la sauvegarde');
        }
    }

    public function validated(Request $request,$id)
    {
        $besoin = Besoin::find($id);

        try {
            $this->validate($request, [
                'besoinitems' => 'array',
            ]);

            if ($besoin->status == 'pending') {

                foreach (Auth::user()->permissions as $permission) {
                    if ($permission->slug == 'responsable-gestionnaire-des-ressources-humaines') {
                        $besoin->update([
                            'status'=>'validated',
                            'rh_id'=>Auth::user()->id,
                            'commentaire'=>$request->commentaire,
                        ]);
                    } elseif ($permission->slug == 'chef-barm') {
                        $besoin->update([
                            'status'=>'validated',
                            'chef_barm_id'=>Auth::user()->id,
                            'commentaire'=>$request->commentaire,
                        ]);
                    }
                }

                $besoinitemsData = $request->besoinitems;

                foreach ($besoin->besoinitems as $besoinitem) {
                    $besoinitem->delete();
                }

                foreach ($besoinitemsData as $besoinitemData) {
                    $besoinitem = Besoinitem::create([
                        'consommable_id' => $besoinitemData['consommable_id'],
                        'qte_demande' => $besoinitemData['qte_demande'],
                        'qte_recue' => $besoinitemData['qte_recue'],
                        'qte_manquante' => $besoinitemData['qte_demande']-$besoinitemData['qte_recue'],
                        'disponible' => $besoinitemData['disponible'],
                        'besoin_id' => $besoin->id,
                    ]);

                    if ($besoinitemData['disponible'] == '1') {
                        $consommable = Consommable::findOrFail($besoinitemData['consommable_id']);
                        $qte_disponibleold = $consommable->qte_disponible;

                        $consommable->update([
                            'qte_disponible' => $qte_disponibleold-$besoinitemData['qte_recue'],
                        ]);
                    } 
                    
                }
            } else{
                foreach (Auth::user()->permissions as $permission) {
                    if ($permission->slug == 'responsable-gestionnaire-des-ressources-humaines') {
                        $besoin->update([
                            'rh_id'=>Auth::user()->id,
                            
                        ]);
                    } elseif ($permission->slug == 'chef-barm') {
                        $besoin->update([
                            'chef_barm_id'=>Auth::user()->id,
                        ]);
                    }
                }
            }

            return redirect()->route('besoins.index')->with("success", 'Demande validée');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return $e->getMessage();
        }
    }

    public function refused(Request $request, $id)
    {
        
         $besoin = Besoin::find($id);
        try {

            if ($besoin->status == 'pending') {
                foreach (Auth::user()->permissions as $permission) {
                    if ($permission->slug == 'responsable-gestionnaire-des-ressources-humaines') {
                        $besoin->update([
                            'status'=>'refused',
                            'rh_id'=>Auth::user()->id,
                            
                        ]);
                    } elseif ($permission->slug == 'chef-barm') {
                        $besoin->update([
                            'status'=>'refused',
                            'chef_barm_id'=>Auth::user()->id,
                        ]);
                    }
                }
            } else{
                foreach (Auth::user()->permissions as $permission) {
                    if ($permission->slug == 'responsable-gestionnaire-des-ressources-humaines') {
                        $besoin->update([
                            'rh_id'=>Auth::user()->id,
                            
                        ]);
                    } elseif ($permission->slug == 'chef-barm') {
                        $besoin->update([
                            'chef_barm_id'=>Auth::user()->id,
                        ]);
                    }
                }
            }

            return redirect()->route('besoins.index')->with("success", 'Demande refusée');
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return back()->with("error", 'Un problème est survenu lors de la validation');
        } catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return $e->getMessage();
        }
    }

    public function pdf($id)
    {
        $chef_barm = Permission::where('slug','chef-barm')->first()->users()->first();
        $title = 'BON POUR';
        $besoin = Besoin::findOrFail($id);
        
        $pdf = PDF::loadView('dashboard.besoin.pdf', compact('title', 'besoin', 'chef_barm'));

        return $pdf->download('besoin_pdf_' . str_replace(' ', '_', $besoin->user->firstname) . '.pdf');
    }
}
