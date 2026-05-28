<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class BudgetPlanExport implements FromArray, WithHeadings, WithStyles
{
    protected $budgetPlan;

    public function __construct($budgetPlan)
    {
        $this->budgetPlan = $budgetPlan;
    }

    /**
     * Données à exporter.
     */
    public function array(): array
    {
        $index_c = 0;
        $pivot_c = 0;
        $componentTotals = [];
        $data = [];
        $componentIndex = 1;

        
        $totalGeneral = [
            'cost_total_project' => 0,
            'commitments' => 0,
            'cost_q1' => 0,
            'cost_q2' => 0,
            'cost_q3' => 0,
            'cost_q4' => 0,
            'cost_total_year' => 0,
        ];

        foreach ($this->budgetPlan->components as $component) {
            $pivot_c++;
            $amount_c = [
                'cost_total_project' => 0,
                'commitments' => 0,
                'cost_q1' => 0,
                'cost_q2' => 0,
                'cost_q3' => 0,
                'cost_q4' => 0,
                'cost_total_year' => 0,
            ];

            $data[] = [
                "$componentIndex",
                'Composante ' . $componentIndex . ' : ' . $component->title,
                '',
                $component->code,
                '',
                '',
                // number_format($component->amount, 0, '', ' '),
                // number_format($component->amount / $this->budgetPlan->conversion_xof, 2),
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
            ];

            $index_sc = $pivot_c;
            $subComponentIndex = 1;

            foreach ($component->subComponents as $subComponent) {
                $pivot_c++;
                $amount_cc = [
                    'cost_total_project' => 0,
                    'commitments' => 0,
                    'cost_q1' => 0,
                    'cost_q2' => 0,
                    'cost_q3' => 0,
                    'cost_q4' => 0,
                    'cost_total_year' => 0,
                ];

                $data[] = [
                    "$componentIndex.$subComponentIndex",
                    'Sous-composante ' . $componentIndex . '.' . $subComponentIndex . ' : ' . $subComponent->title,
                    '',
                    $subComponent->code,
                    '',
                    '',
                    // $subComponent->amount ? number_format($subComponent->amount, 0, '', ' ') : 0,
                    // number_format($subComponent->amount / $this->budgetPlan->conversion_xof, 2),
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                ];

                $index_s = $pivot_c;
                $sectionIndex = 1;

                foreach ($subComponent->sections as $section) {
                    $pivot_c++;
                    $amount_ccc = [
                        'cost_total_project' => 0,
                        'commitments' => 0,
                        'cost_q1' => 0,
                        'cost_q2' => 0,
                        'cost_q3' => 0,
                        'cost_q4' => 0,
                        'cost_total_year' => 0,
                    ];

                    $data[] = [
                        "$componentIndex.$subComponentIndex.$sectionIndex",
                        'Volet ' . $componentIndex . '.' . $subComponentIndex . '.' . $sectionIndex . ' : ' . $section->title,
                        '',
                        $section->code,
                        0,
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                    ];

                    $activityIndex = 1;

                    foreach ($section->parts as $part) {
                        $pivot_c++;
                        $data[] = [
                            "$componentIndex.$subComponentIndex.$sectionIndex.$activityIndex",
                            $part->title,
                            $part->details,
                            (string)$part->code,
                            $part->cost_total_project ? number_format($part->cost_total_project, 0, '', ' ') : '',
                            ($part->cost_total_project / $this->budgetPlan->conversion_xof) == 0 ? '' : number_format($part->cost_total_project / $this->budgetPlan->conversion_xof, 2),
                            $part->commitments ? number_format($part->commitments, 0, '', ' ') : '',
                            ($part->commitments / $this->budgetPlan->conversion_xof) == 0 ? '' : number_format($part->commitments / $this->budgetPlan->conversion_xof, 2),
                            ($part->commitments && $part->commitments > 0 && $part->cost_total_project && $part->cost_total_project > 0) ? (number_format(($part->commitments/ $part->cost_total_project) * 100 ,2 ) . '%') : '',
                            $part->cost_q1 ? number_format($part->cost_q1, 0, '', ' ') : '',
                            $part->cost_q2 ? number_format($part->cost_q2, 0, '', ' ') : '',
                            $part->cost_q3 ? number_format($part->cost_q3, 0, '', ' ') : '',
                            $part->cost_q4 ? number_format($part->cost_q4, 0, '', ' ') : '',
                            $part->cost_total_year ? number_format($part->cost_total_year, 0, '', ' ') : '',
                            ($part->cost_total_year / $this->budgetPlan->conversion_xof) == 0 ? '' : number_format($part->cost_total_year / $this->budgetPlan->conversion_xof, 2),
                            0,
                            $part->chronogram_q1,
                            $part->chronogram_q2,
                            $part->chronogram_q3,
                            $part->chronogram_q4,
                            $part->comments,
                        ];
                        
                        $amount_ccc['cost_total_project'] = $part->cost_total_project ?? 0;
                        $amount_ccc['commitments'] += $part->commitments ?? 0;
                        $amount_ccc['cost_q1'] += $part->cost_q1 ?? 0;
                        $amount_ccc['cost_q2'] += $part->cost_q2 ?? 0;
                        $amount_ccc['cost_q3'] += $part->cost_q3 ?? 0;
                        $amount_ccc['cost_q4'] += $part->cost_q4 ?? 0;
                        $amount_ccc['cost_total_year'] += $part->cost_total_year ?? 0;

                        $activityIndex++;
                    }

                    
                    $data[$index_s][4] = $amount_ccc['cost_total_project'] ? number_format($amount_ccc['cost_total_project'], 0, '', ' ') : '';
                    $data[$index_s][5] = ($amount_ccc['cost_total_project'] / $this->budgetPlan->conversion_xof) == 0 ? '' : number_format($amount_ccc['cost_total_project'] / $this->budgetPlan->conversion_xof, 2);
                    $data[$index_s][6] = $amount_ccc['commitments'] ? number_format($amount_ccc['commitments'], 0, '', ' ') : '';
                    $data[$index_s][7] = ($amount_ccc['commitments'] / $this->budgetPlan->conversion_xof) == 0 ? '' : number_format($amount_ccc['commitments'] / $this->budgetPlan->conversion_xof, 2);
                    $data[$index_s][8] = ($amount_ccc['commitments'] && $amount_ccc['cost_total_project'] && $amount_ccc['commitments'] > 0 && $amount_ccc['cost_total_project'] > 0) ? (number_format(($amount_ccc['commitments'] / $amount_ccc['cost_total_project']) * 100, 0, '', ' ') . "%") : '';

                    $data[$index_s][9] = $amount_ccc['cost_q1'] ? number_format($amount_ccc['cost_q1'], 0, '', ' ') : '';
                    $data[$index_s][10] = $amount_ccc['cost_q2'] ? number_format($amount_ccc['cost_q2'], 0, '', ' ') : '';
                    $data[$index_s][11] = $amount_ccc['cost_q3'] ? number_format($amount_ccc['cost_q3'], 0, '', ' ') : '';
                    $data[$index_s][12] = $amount_ccc['cost_q4'] ? number_format($amount_ccc['cost_q4'], 0, '', ' ') : '';

                    $data[$index_s][13] = $amount_ccc['cost_total_year'] ? number_format($amount_ccc['cost_total_year'], 0, '', ' ') : '';
                    $data[$index_s][14] = ($amount_ccc['cost_total_year'] / $this->budgetPlan->conversion_xof) == 0 ? '' : number_format($amount_ccc['cost_total_year'] / $this->budgetPlan->conversion_xof, 2);

                    
                    $amount_cc['cost_total_project'] += $amount_ccc['cost_total_project'] ?? 0;
                    $amount_cc['commitments'] += $amount_ccc['commitments'] ?? 0;
                    $amount_cc['cost_q1'] += $amount_ccc['cost_q1'] ?? 0;
                    $amount_cc['cost_q2'] += $amount_ccc['cost_q2'] ?? 0;
                    $amount_cc['cost_q3'] += $amount_ccc['cost_q3'] ?? 0;
                    $amount_cc['cost_q4'] += $amount_ccc['cost_q4'] ?? 0;
                    $amount_cc['cost_total_year'] += $amount_ccc['cost_total_year'] ?? 0;

                    $index_s = $pivot_c;
                    $sectionIndex++;
                }

                $data[$index_sc][4] = $amount_cc['cost_total_project'] ? number_format($amount_cc['cost_total_project'], 0, '', ' ') : '';
                $data[$index_sc][5] = ($amount_cc['cost_total_project'] / $this->budgetPlan->conversion_xof) == 0 ? '' : number_format($amount_cc['cost_total_project'] / $this->budgetPlan->conversion_xof, 2);
                $data[$index_sc][6] = $amount_cc['commitments'] ? number_format($amount_cc['commitments'], 0, '', ' ') : '';
                $data[$index_sc][7] = ($amount_cc['commitments'] / $this->budgetPlan->conversion_xof) == 0 ? '' : number_format($amount_cc['commitments'] / $this->budgetPlan->conversion_xof, 2);
                $data[$index_sc][8] = ($amount_cc['commitments'] && $amount_cc['cost_total_project'] && $amount_cc['commitments'] > 0 && $amount_cc['cost_total_project'] > 0) ? (number_format(($amount_cc['commitments'] / $amount_cc['cost_total_project']) * 100, 0, '', ' ') . "%") : '';

                $data[$index_sc][9] = $amount_cc['cost_q1'] ? number_format($amount_cc['cost_q1'], 0, '', ' ') : '';
                $data[$index_sc][10] = $amount_cc['cost_q2'] ? number_format($amount_cc['cost_q2'], 0, '', ' ') : '';
                $data[$index_sc][11] = $amount_cc['cost_q3'] ? number_format($amount_cc['cost_q3'], 0, '', ' ') : '';
                $data[$index_sc][12] = $amount_cc['cost_q4'] ? number_format($amount_cc['cost_q4'], 0, '', ' ') : '';
                
                $data[$index_sc][13] = $amount_cc['cost_total_year'] ? number_format($amount_cc['cost_total_year'], 0, '', ' ') : '';
                $data[$index_sc][14] = ($amount_cc['cost_total_year'] / $this->budgetPlan->conversion_xof) == 0 ? '' : number_format($amount_cc['cost_total_year'] / $this->budgetPlan->conversion_xof, 2);

                
                $amount_c['cost_total_project'] += $subComponent->amount ?? 0;
                $amount_c['commitments'] += $amount_cc['commitments'] ?? 0;
                $amount_c['cost_q1'] += $amount_cc['cost_q1'] ?? 0;
                $amount_c['cost_q2'] += $amount_cc['cost_q2'] ?? 0;
                $amount_c['cost_q3'] += $amount_cc['cost_q3'] ?? 0;
                $amount_c['cost_q4'] += $amount_cc['cost_q4'] ?? 0;
                $amount_c['cost_total_year'] += $amount_cc['cost_total_year'] ?? 0;

                $index_sc = $pivot_c;
                $subComponentIndex++;
            }

            $componentTotals[] = [
                "",
                'Composante ' . $componentIndex,
                $amount_c['cost_total_year'] ? number_format($amount_c['cost_total_year'], 0, '', ' ') : '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
            ];

            $data[$index_c][4] = $amount_c['cost_total_project'] ? number_format($amount_c['cost_total_project'], 0, '', ' ') : '';
            $data[$index_c][5] = ($amount_c['cost_total_project'] / $this->budgetPlan->conversion_xof) == 0 ? '' : number_format($amount_c['cost_total_project'] / $this->budgetPlan->conversion_xof, 2);
            $data[$index_c][6] = $amount_c['commitments'] ? number_format($amount_c['commitments'], 0, '', ' ') : '';
            $data[$index_c][7] = ($amount_c['commitments'] / $this->budgetPlan->conversion_xof) == 0 ? '' : number_format($amount_c['commitments'] / $this->budgetPlan->conversion_xof, 2);
            $data[$index_c][8] = ($amount_c['commitments'] && $amount_c['cost_total_project'] && $amount_c['commitments'] > 0 && $amount_c['cost_total_project'] > 0) ? (number_format(($amount_c['commitments'] / $amount_c['cost_total_project']) * 100, 0, '', ' ') . "%") : '';

            $data[$index_c][9] = $amount_c['cost_q1'] ? number_format($amount_c['cost_q1'], 0, '', ' ') : '';
            $data[$index_c][10] = $amount_c['cost_q2'] ? number_format($amount_c['cost_q2'], 0, '', ' ') : '';
            $data[$index_c][11] = $amount_c['cost_q3'] ? number_format($amount_c['cost_q3'], 0, '', ' ') : '';
            $data[$index_c][12] = $amount_c['cost_q4'] ? number_format($amount_c['cost_q4'], 0, '', ' ') : '';
            
            $data[$index_c][13] = $amount_c['cost_total_year'] ? number_format($amount_c['cost_total_year'], 0, '', ' ') : '';
            $data[$index_c][14] = ($amount_c['cost_total_year'] / $this->budgetPlan->conversion_xof) == 0 ? '' : number_format($amount_c['cost_total_year'] / $this->budgetPlan->conversion_xof, 2);

            
            $totalGeneral['cost_total_project'] += $amount_c['cost_total_project'] ?? 0;
            $totalGeneral['commitments'] += $amount_c['commitments'] ?? 0;

            $totalGeneral['cost_q1'] += $amount_c['cost_q1'] ?? 0;
            $totalGeneral['cost_q2'] += $amount_c['cost_q2'] ?? 0;
            $totalGeneral['cost_q3'] += $amount_c['cost_q3'] ?? 0;
            $totalGeneral['cost_q4'] += $amount_c['cost_q4'] ?? 0;

            $totalGeneral['cost_total_year'] += $amount_c['cost_total_year'] ?? 0;

            $index_c = $pivot_c;
            $componentIndex++;
        }

        for ($v = 0; $v < 1; $v++)
            $data[] = [
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                ''
            ];

        
        $data[] = [
            '',
            'TOTAL PTAB',
            '',
            '',
            $totalGeneral['cost_total_project'] ? number_format($totalGeneral['cost_total_project'], 0, '', ' ') : '',
            ($totalGeneral['cost_total_project'] / $this->budgetPlan->conversion_xof) == 0 ? '' : number_format($totalGeneral['cost_total_project'] / $this->budgetPlan->conversion_xof, 2),
            $totalGeneral['commitments'] ? number_format($totalGeneral['commitments'], 0, '', ' ') : '',
            ($totalGeneral['commitments'] / $this->budgetPlan->conversion_xof) == 0 ? '' : number_format($totalGeneral['commitments'] / $this->budgetPlan->conversion_xof, 2),
            ($totalGeneral['commitments'] && $totalGeneral['cost_total_project'] && $totalGeneral['commitments'] > 0 && $totalGeneral['cost_total_project'] > 0) ? (number_format(($totalGeneral['commitments'] / $totalGeneral['cost_total_project']) * 100, 2) . "%") : '',
            $totalGeneral['cost_q1'] ? number_format($totalGeneral['cost_q1'], 0, '', ' ') : '',
            $totalGeneral['cost_q2'] ? number_format($totalGeneral['cost_q2'], 0, '', ' ') : '',
            $totalGeneral['cost_q3'] ? number_format($totalGeneral['cost_q3'], 0, '', ' ') : '',
            $totalGeneral['cost_q4'] ? number_format($totalGeneral['cost_q4'], 0, '', ' ') : '',
            $totalGeneral['cost_total_year'] ? number_format($totalGeneral['cost_total_year'], 0, '', ' ') : '',
            ($totalGeneral['cost_total_year'] / $this->budgetPlan->conversion_xof) == 0 ? '' : number_format($totalGeneral['cost_total_year'] / $this->budgetPlan->conversion_xof, 2),
            '',
            '',
            '',
            '',
            '',
            '',
        ];

        for ($v = 0; $v < 2; $v++)
            $data[] = [
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                ''
            ];

        $data[] = [
            '',
            '',
            'Budget prévisionnel (ANNEE)',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        ];

        foreach ($componentTotals as $row)
            $data[] = $row;


        
        $data[] = [
            '',
            'TOTAL PTAB DU BARM',
            $totalGeneral['cost_total_year'] ? number_format($totalGeneral['cost_total_year'], 0, '', ' ') : '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
        ];

        return $data;
    }



    /**
     * En-têtes du fichier Excel.
     */
    public function headings(): array
    {
        return [
            [
                'PLAN  DE TRAVAIL ANNUEL BUDGETISE',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
            ],
            [
                'Maître d\'ouvrage : ',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
            ],
            [
                'Secteur : ',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
            ],
            [
                'Nom du projet : ',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
            ],
            [
                'Convention AFD N° : ',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
            ],
            [
                'N°',
                'Libellé des activités planifiées',
                'Autres services impliquées dans la mise en œuvre',
                'Code d\'imputation budgétaire',
                'Coût total de l\'activité (sur toute la durée du projet)',
                '',
                'Cumul des engagements ',
                '',
                '',
                'Coût prévu de l\'activité (ANNEE)',
                '',
                '',
                '',
                '',
                '',
                '',
                'Chronogramme (ANNEE)',
                '',
                '',
                '',
                'Commentaires/Observations',
            ],
            [
                '',
                '',
                '',
                '',
                'FCFA',
                'Euro',
                'FCFA',
                'Euro',
                '%',
                'Trim 1',
                'Trim 2',
                'Trim 3',
                'Trim 4',
                'Total FCFA',
                'Total Euro',
                '%',
                'T1',
                'T2',
                'T3',
                'T4',
                '',
            ],
        ];
    }

    /**
     * Appliquer les styles au fichier Excel.
     */
    public function styles(Worksheet $sheet)
    {
        
        $sheet->mergeCells('A1:C1');
        $sheet->mergeCells('A2:C2');
        $sheet->mergeCells('A3:C3');
        $sheet->mergeCells('A4:C4');
        $sheet->mergeCells('A5:C5');

        $sheet->mergeCells('A6:A7');
        $sheet->mergeCells('B6:B7');
        $sheet->mergeCells('C6:C7');
        $sheet->mergeCells('D6:D7');
        $sheet->mergeCells('E6:F6'); 
        $sheet->mergeCells('G6:I6'); 
        $sheet->mergeCells('J6:P6'); 
        $sheet->mergeCells('Q6:T6'); 
        $sheet->mergeCells('U6:U7');

        
        foreach (range('A', 'U') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }


        
        foreach ($sheet->getRowIterator() as $row) {
            $sheet->getRowDimension($row->getRowIndex())->setRowHeight(25);
        }

        
        $sheet->getStyle('A6:B500')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT)
            ->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->getStyle('C6:U500')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);



        
        $rowStart = 3;
        $lastRow = $sheet->getHighestRow();

        for ($row = $rowStart; $row <= $lastRow; $row++) {
            foreach (['Q', 'R', 'S', 'T'] as $column) {
                $value = $sheet->getCell($column . $row)->getValue();
                if ($value === 'préparation') {
                    $sheet->getStyle($column . $row)->applyFromArray([
                        'font' => ['color' => ['rgb' => '32A8A8']],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => '32A8A8'],
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => 'AAAAAA'],
                            ],
                        ],
                    ]);
                } elseif (
                    $value === 'sélection'
                ) {
                    $sheet->getStyle($column . $row)->applyFromArray([
                        'font' => ['color' => ['rgb' => 'f2c00c']],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'f2c00c'],
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => 'AAAAAA'],
                            ],
                        ],
                    ]);
                } elseif (
                    $value === 'exécution'
                ) {
                    $sheet->getStyle($column . $row)->applyFromArray([
                        'font' => ['color' => ['rgb' => '0cf232']],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => '0cf232'],
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => 'AAAAAA'],
                            ],
                        ],
                    ]);
                }
            }
        }

        
        return [
            6 => [
                'font' => ['bold' => true, 'color' => ['rgb' => '00000']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'e2efda'],
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'AAAAAA'],
                    ],
                ],
            ],
            7 => [
                'font' => ['bold' => true, 'color' => ['rgb' => '00000']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'e2efda'],
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'AAAAAA'],
                    ],
                ],
            ],
            'A6:U7' => ['alignment' => ['horizontal' => 'center', 'vertical' => 'center']],
        ];
    }
}
