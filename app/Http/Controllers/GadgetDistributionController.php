<?php

namespace App\Http\Controllers;

use App\Models\DistributionItem;
use App\Models\Gadget;
use App\Models\GadgetDistribution;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class GadgetDistributionController extends Controller
{
    public function user($personal = 'responsable-communication')
    {
        authPermission($personal);
        return auth()->user();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $this->user();
        $distributions = GadgetDistribution::orderByDESC('created_at')->get();

        return view('dashboard.gadget.distribution.index', [
            'title' => 'Liste des distributions',
            'distributions' => $distributions,
        ]);
    }

    public function create()
    {
        $this->user();
        $gadgets = Gadget::orderByDESC('created_at')->where('quantity', '>', 0)->get();

        return view('dashboard.gadget.distribution.create', [
            'title' => 'Ajout',
            'gadgets' => $gadgets,
        ]);
    }

    public function store(Request $request)
    {
        $this->user();
        $attrs = $request->validate([
            'title' => 'required|string',
            'title_pres' => 'nullable|string',
            'gadget' => 'required|array',
            'quantity' => 'required|array',
            'distribution_date' => 'required|date'
        ]);

        $distribution = array_diff_key($attrs, ['title_pres' => '', 'gadget' => '', 'quantity' => '', 'description' => '',]);
        $items = array_diff_key($attrs, ['title' => '', 'title_pres' => '', 'distribution_date' => '']);
        if (isset($attrs['title_pres']))
            $distribution['title'] = $attrs['title_pres'];
        $distribution['reference'] = 'GDT' . GadgetDistribution::count() + 1;

        if (count($items['gadget']) != count($items['quantity']))
            return back()->with('warning', 'Invalid');

        foreach ($items['gadget'] as $key => $item)
            $gadget = Gadget::findOrFail($item);

        $dist = GadgetDistribution::create($distribution);

        foreach ($items['gadget'] as $key => $item) {
            $gadget = Gadget::find($item);
            if (($gadget->quantity - $items['quantity'][$key]) > 0)
                $gadget->quantity = $gadget->quantity - $items['quantity'][$key];
            else
                $gadget->quantity = 0;
            $gadget->save();

            DistributionItem::create([
                'gadget_id' => $gadget->id,
                'gadget_distribution_id' => $dist->id,
                'quantity' => $items['quantity'][$key],
            ]);
        }

        return to_route('gadget.distribution.index')->with('success', 'Données enregistrées avec succès');

    }

    public function pdf_gadget($id)
    {
        $gadget = Gadget::findOrFail($id);
        $pdf = PDF::loadView('pdf.gadget', compact('gadget'));

        return $pdf->stream('gadget' . str_replace(' ', '_', $gadget->id) . '.pdf');
    }

    public function pdf_distribution($id)
    {
        $distribution = GadgetDistribution::findOrFail($id);
        $pdf = PDF::loadView('pdf.gadget_distribution', compact('distribution'));

        return $pdf->stream('distribution' . str_replace(' ', '_', $distribution->reference) . '.pdf');
    }


}
