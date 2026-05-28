<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CandidaturesExport implements FromCollection, WithHeadings, WithStyles
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return $this->data->first() ? array_keys(array: $this->data->first()) : [];
    }

    public function styles(Worksheet $sheet)
    {
        // Appliquer un peu de style sympa
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFB0C4DE']
            ],
            'alignment' => ['horizontal' => 'center']
        ]);

        $sheet->getDefaultRowDimension()->setRowHeight(20);
        $sheet->getDefaultColumnDimension()->setWidth(20);
        $sheet->getStyle($sheet->calculateWorksheetDimension())->getBorders()->getAllBorders()->setBorderStyle(
            \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
        );

        return [];
    }
}
