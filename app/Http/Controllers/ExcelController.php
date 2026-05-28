<?php

namespace App\Http\Controllers;

use App\Excel\ImportAdherent;
use App\Excel\ImportVillage;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Region;
use App\Models\Retired;
use App\Models\SubPrefecture;
use App\Models\Village;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExcelController extends Controller
{


    public function upload_adherent_list()
    {
        return view('dashboard.excel.upload_adherent_list', [
            'step' => 'import_file',
        ]);
    }

    public function import_adherent_list(Request $request)
    {

        if ($request->step && $request->step != 'import_file') {
            $request->validate([
                'retireds' => 'required',
            ]);
            foreach (json_decode($request->retireds) as $key => $retired) {
                if (!(Retired::where(function ($query) use ($retired) {
                    $query->where('mecano', $retired[2])->orWhere('matricule', $retired[3]);
                })->exists()))
                    Retired::create([
                        'personal_id' => auth()->user()->personnel->id,
                        'year' => $retired[0] ?? date('Y'),
                        'grade' => $retired[1],
                        'mecano' => $retired[2] ?? $retired[3],
                        'matricule' => $retired[3] ?? $retired[2],
                        'firstname' => $retired[4],
                        'lastname' => $retired[5],
                        'birth_date' => $retired[6] ?? date('Y-m-d'),
                        'gender' => $retired[7] == 'Feminin' ? 'F' : 'M',
                        'unit' => $retired[8],
                        'army' => $retired[9],
                        'retired_date' => $retired[10],
                        'retired_type' => $retired[11],
                    ]);
            }

            return to_route('retired.index')->with('success', 'Rétraité(s) ajouté(s) avec succès');
        }

        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $array = Excel::toArray(new ImportAdherent, $request->file('file'));

        $convertedArray = $this->convertNumericDates($array);

        foreach ($convertedArray as $key => $value)
            if (!in_array(count($value[0]),  [11, 12, 13]))
                return back()->with('error', 'Fichier incorrect');

        return view('dashboard.excel.upload_adherent_list', [
            'step' => 'import_data',
            'retireds_list' => $convertedArray,
        ]);
    }

    private function convertNumericDates(array $data)
    {
        foreach ($data as &$sheet) {
            foreach ($sheet as &$row) {
                $dateColumns = [6, 10];
                foreach ($dateColumns as $column) {
                    if (isset($row[$column]) && is_numeric($row[$column])) {
                        $row[$column] = Date::excelToDateTimeObject($row[$column])->format('Y-m-d');
                    }
                }
            }
        }
        return $data;
    }

    public function import_vilage(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $array = Excel::toArray(new ImportVillage, $request->file('file'));
        // dd($array[0]);

        foreach ($array[0] as $key => $data) {
            $region = Region::where(['name' => $data[0]])->first();
            if (!$region)
                $region = Region::create(['name' => $data[0]]);

            $department = Department::where(['name' => $data[1]])->first();
            if (!$department)
                $department = Department::create(['name' => $data[1], 'region_id' => $region->id]);

            $sub_prefecture = SubPrefecture::where(['name' => $data[2]])->first();
            if (!$sub_prefecture)
                $sub_prefecture = SubPrefecture::create(['name' => $data[2], 'department_id' => $department->id]);

            $village = Village::where(['name' => $data[3]])->first();
            if (!$village)
                $village = Village::create(['name' => $data[3], 'sub_prefecture_id' => $sub_prefecture->id]);
        }

        $convertedArray = $this->convertNumericDates($array);


        foreach ($convertedArray as $key => $value)
            if (count($value[0]) != 11)
                return back()->with('error', 'Fichier incorrect');

        return view('dashboard.excel.upload_adherent_list', [
            'step' => 'import_data',
            'retireds_list' => $convertedArray,
        ]);
    }
}
