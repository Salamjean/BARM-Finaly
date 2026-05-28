<?php

namespace App\Http\Controllers;

use App\Excel\ImportAdherent;
use App\Excel\ImportVillage;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Region;
use App\Models\Retired;
use App\Models\SubPrefecture;
use App\Models\User;
use App\Models\Village;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{


    public function adherent($id)
    {
        $title = 'Fiche d"autorisation';
        $user = User::findOrFail($id);

        $pdf = PDF::loadView('pdf.file_candidature_final', compact('title', 'user'));
        $pdfname = 'fiche_' . str_replace(' ', '_', $user->fullName()) . '.pdf';

        return $pdf->stream($pdfname);
    }

    
}
