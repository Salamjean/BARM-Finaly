<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LeaveRequest;
use App\Http\Requests\LeaveUpdateRequest;
use App\Models\Personnel;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;



class LeaveController extends Controller
{
    public function listLeave()
    {
        $title = 'Liste des demandes';
        $userId = Auth::user()->id;
        $leaves = Leave::where('user_id', $userId)
        ->orderBy('created_at', 'desc')
        ->get();

        return view('personnels.list_demande', compact('title','leaves'));
    }

    public function createLeave()
    {
        $title = 'Ajouter demande';
        return view('personnels.add_demande', compact('title'));
    }

    public function storeLeave(LeaveRequest $request)
    {
        $existing = Leave::where('user_id', Auth::user()->id)
                         ->where('leavefrom', $request->leavefrom)
                         ->where('leaveto', $request->leaveto)
                         ->exists();

        if ($existing) {
            return back()->with('error', 'Une demande de congé similaire existe déjà.');
        }

        $user = Auth::user();
        $personnel = $user->personnel;
        $personnelId = $personnel->id;
        $leave_type = mb_strtoupper($request->leave_type);
        $leavefrom = $request->leavefrom;
        $leaveto = $request->leaveto;
        $returndate = $request->returndate;
        $reason = mb_strtoupper($request->reason);
        $nbDay = $request->nb_day;

        $fileAttachment = $request->file('fileAttachment');
        $name = null;

        if ($fileAttachment != null) {
            $name = $fileAttachment->getClientOriginalName();
            $destinationPath = saveByEnv() .  '/assets/faces/';
            $fileAttachment->move($destinationPath, $name);
        } else {
            $name = null;
        }
        $leave = Leave::create([
            'user_id' => $user->id,
            'personnel_id' => $personnelId,
            'leave_type' => $leave_type,
            'leavefrom' => $leavefrom,
            'leaveto' => $leaveto,
            'returndate' => $returndate,
            'reason' => $reason,
            'nb_day' => $nbDay,
            'file' => $name,
            'status' => 'En attente',
        ]);

        return redirect()->route('leave.leavelist')->with('success', 'Votre demande a été envoyée avec succès.');
    }


    public function editLeave($id)
    {
        $title = 'Modifier une demande';
        $leaves = Leave::where('id',$id)->first();

        return view('personnels.edit_demande', compact('title','leaves'));
    }


    public function updateLeave(LeaveUpdateRequest $request, $id)
    {
        $leaves = Leave::findOrFail($id);
        if ($request->hasFile('file')) {

            if ($leaves->file) {
                Storage::delete('public/leaves/' . $leaves->file);
            }

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/leaves', $filename);


            $leaves->file = $filename;
        }

        $leaves->update([
            //'leave_type' => $request->leave_type,
            'leavefrom' => $request->leavefrom,
            'leaveto' => $request->leaveto,
            'nb_day' => $request->nb_day,
            'returndate' => $request->returndate,
            'reason' => $request->reason,
        ]);

        return redirect()->route('leave.leavelist')->with('success', 'Votre demande a été modifiée avec succès !');
    }


    public function deleteLeave($id)
    {
        $leave = Leave::where('id', $id)->firstOrFail();
        $leave->delete();

        return redirect()->route('leave.leavelist')->with('success', trans("Cette demande a bien été supprimée !"));
    }


    public function leavePdf($id)
    {
        $title = 'Demande de permission';
        $leaves = Leave::where('id',$id)->first();
        $personnels = Personnel::where('id', $leaves->id)->get();

        $pdf = PDF::loadView('dashboard.administration.pdf.permission', compact('title','leaves','personnels'));
        $pdfname = 'demande_permission_' . str_replace(' ', '_', $leaves->user->firstname) . '.pdf';

       return $pdf->download($pdfname);
    }

    public function personneleavefilter(Request $request)
    {

        $title = 'Liste des demandes';

        $messages = [
            'date_envoi.required' => 'La date est requise.',
            'date_envoi.date' => 'La date doit être une date valide.',
            'typeLeave.required' => 'Le type de demande est requis.',

        ];
        $request->validate([
            'date_envoi' => 'required|date_format:Y-m-d',
            'typeLeave' => 'required',
        ],$messages);

        $date = $request->input('date_envoi');
        $type = $request->input('typeLeave');

        $filteredData = Leave::whereDate('created_at', $date)
        ->where('leave_type', $type)
        ->get();


         return view('personnels.list_demande', ['leaves' => $filteredData, 'title' => $title]);
    }
}
