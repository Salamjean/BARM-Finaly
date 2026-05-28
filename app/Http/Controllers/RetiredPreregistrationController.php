<?php

namespace App\Http\Controllers;

use App\Models\RetiredPreregistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RetiredPreregistrationController extends Controller
{
    /**
     * Afficher la liste des demandes de préinscription
     */
    public function index(Request $request)
    {
        $query = RetiredPreregistration::with(['retired', 'processedBy'])
            ->orderBy('created_at', 'desc');

        // Filtrage par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtrage par vérification
        if ($request->filled('verified')) {
            $query->where('verified', $request->verified === '1');
        }

        $preregistrations = $query->paginate(20);

        return view('dashboard.retired_preregistrations.index', compact('preregistrations'));
    }

    /**
     * Afficher les détails d'une demande
     */
    public function show($id)
    {
        $preregistration = RetiredPreregistration::with(['retired', 'processedBy'])->findOrFail($id);
        
        return view('dashboard.retired_preregistrations.show', compact('preregistration'));
    }

    /**
     * Approuver une demande
     */
    public function approve(Request $request, $id)
    {
        $preregistration = RetiredPreregistration::findOrFail($id);
        
        $preregistration->update([
            'status' => 'approved',
            'processed_at' => now(),
            'processed_by' => Auth::id(),
            'admin_notes' => $request->admin_notes
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Demande approuvée avec succès'
        ]);
    }

    /**
     * Rejeter une demande
     */
    public function reject(Request $request, $id)
    {
        $preregistration = RetiredPreregistration::findOrFail($id);
        
        $preregistration->update([
            'status' => 'rejected',
            'processed_at' => now(),
            'processed_by' => Auth::id(),
            'admin_notes' => $request->admin_notes
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Demande rejetée avec succès'
        ]);
    }

    /**
     * API pour DataTables
     */
    public function datatables()
    {
        $preregistrations = RetiredPreregistration::with(['retired', 'processedBy'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['data' => $preregistrations]);
    }
}
