<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class BudgetPlanExportMem implements WithEvents, ShouldAutoSize
{
    protected $budgetPlan;
    protected $components;

    
    protected $effectCounter = 0;
    protected $produitCounter = 0;
    protected $actionCounter = 0;
    protected $activiteCounter = 0;
    protected $currentEffectNumber = '';
    protected $currentProduitNumber = '';
    protected $currentActionNumber = '';

    public function __construct($budgetPlan)
    {
        $this->budgetPlan = $budgetPlan;
        $this->components = $budgetPlan->components;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $this->formatSheet($event->sheet);
            },
        ];
    }

    private function formatSheet($sheet)
    {
        $phpSpreadsheet = $sheet->getDelegate();

        
        $phpSpreadsheet->getPageSetup()
            ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE)
            ->setPaperSize(PageSetup::PAPERSIZE_A4)
            ->setFitToWidth(1)
            ->setFitToHeight(0);

        
        $phpSpreadsheet->getPageMargins()
            ->setTop(0.5)
            ->setBottom(0.5)
            ->setLeft(0.5)
            ->setRight(0.5);

        
        $this->writeData($phpSpreadsheet);

        
        $this->applyFormatting($phpSpreadsheet);
    }

    private function writeData($sheet)
    {
        $currentRow = 1;

        
        $sheet->setCellValue('A1', 'PLAN DE TRAVAIL ANNUEL ' . $this->budgetPlan->year . ' DU ' . strtoupper($this->budgetPlan->name));
        $sheet->mergeCells('A1:P1');

        $sheet->setCellValue('A3', 'MINISTERE D\'ETAT, MINISTERE DE LA DEFENSE');
        $sheet->mergeCells('A3:P3');

        
        $this->writeHeaders($sheet);

        $currentRow = 7; 

        
        $totalMinistere = $this->calculateTotalMinistere();

        
        $sheet->setCellValue('A' . $currentRow, 'TOTAL MINISTERE');
        $sheet->setCellValue('J' . $currentRow, $this->formatAmount($totalMinistere['investment']));
        $sheet->setCellValue('K' . $currentRow, $this->formatAmount($totalMinistere['service']));
        $sheet->setCellValue('L' . $currentRow, $this->formatAmount($totalMinistere['transfer']));
        $sheet->setCellValue('M' . $currentRow, $this->formatAmount($totalMinistere['personal']));
        $sheet->setCellValue('N' . $currentRow, $this->formatAmount($totalMinistere['total']));

        
        $sheet->mergeCells('A' . $currentRow . ':I' . $currentRow);
        $sheet->mergeCells('O' . $currentRow . ':P' . $currentRow);
        $currentRow++;

        
        $this->effectCounter = 0;
        $this->produitCounter = 0;
        $this->actionCounter = 0;
        $this->activiteCounter = 0;

        
        foreach ($this->components as $component) {
            $currentRow = $this->writeComponent($sheet, $component, $currentRow);
        }
    }

    private function writeHeaders($sheet)
    {
        
        $headers = [
            'A5' => 'Resultats/Interventions',
            'B5' => 'Indicateurs',
            'C5' => 'Période',
            'H5' => 'Zones d\'exécution',
            'I5' => 'Structures Resp',
            'J5' => 'Coûts annuels (en millions FCFA)',
            'O5' => 'Entités',
            'P5' => 'Observations'
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        
        $sheet->mergeCells('A5:A6');
        $sheet->mergeCells('B5:B6');
        $sheet->mergeCells('C5:G5');
        $sheet->mergeCells('H5:H6');
        $sheet->mergeCells('I5:I6');
        $sheet->mergeCells('J5:N5');
        $sheet->mergeCells('O5:O6');
        $sheet->mergeCells('P5:P6');

        
        $periodHeaders = [
            'C6' => 'Objectif (Trim 1)',
            'D6' => 'Objectif (Trim2)',
            'E6' => 'Objectif (Trim 3)',
            'F6' => 'Objectif (Trim 4)',
            'G6' => 'Objectif Annuel'
        ];

        foreach ($periodHeaders as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        
        $costHeaders = [
            'J6' => 'Investissement',
            'K6' => 'Biens et Services',
            'L6' => 'Transfert',
            'M6' => 'Personnel',
            'N6' => 'Total'
        ];

        foreach ($costHeaders as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }
    }

    private function calculateTotalMinistere()
    {
        $total = [
            'investment' => 0,
            'service' => 0,
            'transfer' => 0,
            'personal' => 0,
            'total' => 0
        ];

        foreach ($this->components as $component) {
            $effectTotal = $this->calculateEffectTotal($component);
            $total['investment'] += $effectTotal['investment'];
            $total['service'] += $effectTotal['service'];
            $total['transfer'] += $effectTotal['transfer'];
            $total['personal'] += $effectTotal['personal'];
            $total['total'] += $effectTotal['total'];
        }

        return $total;
    }

    private function calculateEffectTotal($component)
    {
        $total = [
            'investment' => 0,
            'service' => 0,
            'transfer' => 0,
            'personal' => 0,
            'total' => 0
        ];

        foreach ($component->subComponents as $subComponent) {
            $produitTotal = $this->calculateProduitTotal($subComponent);
            $total['investment'] += $produitTotal['investment'];
            $total['service'] += $produitTotal['service'];
            $total['transfer'] += $produitTotal['transfer'];
            $total['personal'] += $produitTotal['personal'];
            $total['total'] += $produitTotal['total'];
        }

        return $total;
    }

    private function calculateProduitTotal($subComponent)
    {
        $total = [
            'investment' => 0,
            'service' => 0,
            'transfer' => 0,
            'personal' => 0,
            'total' => 0
        ];

        foreach ($subComponent->sections as $section) {
            $actionTotal = $this->calculateActionTotal($section);
            $total['investment'] += $actionTotal['investment'];
            $total['service'] += $actionTotal['service'];
            $total['transfer'] += $actionTotal['transfer'];
            $total['personal'] += $actionTotal['personal'];
            $total['total'] += $actionTotal['total'];
        }

        return $total;
    }

    private function calculateActionTotal($section)
    {
        $total = [
            'investment' => 0,
            'service' => 0,
            'transfer' => 0,
            'personal' => 0,
            'total' => 0
        ];

        foreach ($section->activities as $activity) {
            $total['investment'] += $activity->ca_investment ?? 0;
            $total['service'] += $activity->ca_service ?? 0;
            $total['transfer'] += $activity->ca_transfer ?? 0;
            $total['personal'] += $activity->ca_personal ?? 0;
            $total['total'] += $activity->ca_total ?? 0;
        }

        return $total;
    }

    private function writeComponent($sheet, $component, $currentRow)
    {
        
        $this->effectCounter++;
        $this->currentEffectNumber = $this->effectCounter;
        $this->produitCounter = 0; 

        
        $effectTotal = $this->calculateEffectTotal($component);

        
        $sheet->setCellValue('A' . $currentRow, 'Effet ' . $this->effectCounter . ': ' . $component->title);
        $sheet->setCellValue('J' . $currentRow, $this->formatAmount($effectTotal['investment']));
        $sheet->setCellValue('K' . $currentRow, $this->formatAmount($effectTotal['service']));
        $sheet->setCellValue('L' . $currentRow, $this->formatAmount($effectTotal['transfer']));
        $sheet->setCellValue('M' . $currentRow, $this->formatAmount($effectTotal['personal']));
        $sheet->setCellValue('N' . $currentRow, $this->formatAmount($effectTotal['total']));

        
        $sheet->mergeCells('A' . $currentRow . ':I' . $currentRow);
        $sheet->mergeCells('O' . $currentRow . ':P' . $currentRow);
        $currentRow++;

        
        foreach ($component->subComponents as $subComponent) {
            $currentRow = $this->writeSubComponent($sheet, $subComponent, $currentRow);
        }

        return $currentRow;
    }

    private function writeSubComponent($sheet, $subComponent, $currentRow)
    {
        
        $this->produitCounter++;
        $this->currentProduitNumber = $this->currentEffectNumber . '.' . $this->produitCounter;
        $this->actionCounter = 0; 

        
        $produitTotal = $this->calculateProduitTotal($subComponent);

        
        $sheet->setCellValue('A' . $currentRow, 'Produit ' . $this->currentProduitNumber . ' : ' . $subComponent->title);
        $sheet->setCellValue('J' . $currentRow, $this->formatAmount($produitTotal['investment']));
        $sheet->setCellValue('K' . $currentRow, $this->formatAmount($produitTotal['service']));
        $sheet->setCellValue('L' . $currentRow, $this->formatAmount($produitTotal['transfer']));
        $sheet->setCellValue('M' . $currentRow, $this->formatAmount($produitTotal['personal']));
        $sheet->setCellValue('N' . $currentRow, $this->formatAmount($produitTotal['total']));

        
        $sheet->mergeCells('A' . $currentRow . ':I' . $currentRow);
        $sheet->mergeCells('O' . $currentRow . ':P' . $currentRow);
        $currentRow++;

        
        foreach ($subComponent->sections as $section) {
            $currentRow = $this->writeSection($sheet, $section, $currentRow);
        }

        return $currentRow;
    }

    private function writeSection($sheet, $section, $currentRow)
    {
        
        $this->actionCounter++;
        $this->currentActionNumber = $this->currentProduitNumber . '.' . $this->actionCounter;
        $this->activiteCounter = 0; 

        
        $actionTotal = $this->calculateActionTotal($section);

        
        $sheet->setCellValue('A' . $currentRow, 'Action ' . $this->currentActionNumber . ' : ' . $section->title);
        $sheet->setCellValue('J' . $currentRow, $this->formatAmount($actionTotal['investment']));
        $sheet->setCellValue('K' . $currentRow, $this->formatAmount($actionTotal['service']));
        $sheet->setCellValue('L' . $currentRow, $this->formatAmount($actionTotal['transfer']));
        $sheet->setCellValue('M' . $currentRow, $this->formatAmount($actionTotal['personal']));
        $sheet->setCellValue('N' . $currentRow, $this->formatAmount($actionTotal['total']));

        
        $sheet->mergeCells('A' . $currentRow . ':I' . $currentRow);
        $sheet->mergeCells('O' . $currentRow . ':P' . $currentRow);
        $currentRow++;

        
        foreach ($section->activities as $activity) {
            $currentRow = $this->writeActivity($sheet, $activity, $currentRow);
        }

        return $currentRow;
    }

    private function writeActivity($sheet, $activity, $currentRow)
    {
        
        $this->activiteCounter++;
        $activiteNumber = $this->currentActionNumber . '.' . $this->activiteCounter;

        
        $sheet->setCellValue('A' . $currentRow, 'Activité ' . $activiteNumber . ' : ' . $activity->title);
        $sheet->setCellValue('B' . $currentRow, $activity->code ?? ''); 
        $sheet->setCellValue('C' . $currentRow, $activity->p_objective_q1 ?? '');
        $sheet->setCellValue('D' . $currentRow, $activity->p_objective_q2 ?? '');
        $sheet->setCellValue('E' . $currentRow, $activity->p_objective_q3 ?? '');
        $sheet->setCellValue('F' . $currentRow, $activity->p_objective_q4 ?? '');
        $sheet->setCellValue('G' . $currentRow, $activity->p_objective_annual ?? '');
        $sheet->setCellValue('H' . $currentRow, $activity->execution_zone ?? '');
        $sheet->setCellValue('I' . $currentRow, $activity->company ?? '');
        $sheet->setCellValue('J' . $currentRow, $this->formatAmount($activity->ca_investment));
        $sheet->setCellValue('K' . $currentRow, $this->formatAmount($activity->ca_service));
        $sheet->setCellValue('L' . $currentRow, $this->formatAmount($activity->ca_transfer));
        $sheet->setCellValue('M' . $currentRow, $this->formatAmount($activity->ca_personal));
        $sheet->setCellValue('N' . $currentRow, $this->formatAmount($activity->ca_total));
        $sheet->setCellValue('O' . $currentRow, $activity->entity ?? '');
        $sheet->setCellValue('P' . $currentRow, $activity->observation ?? '');

        return $currentRow + 1;
    }

    private function formatAmount($amount)
    {
        return $amount ? number_format($amount, 0, ',', ' ') : '';
    }

    private function applyFormatting($sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = 'P';

        
        $sheet->getStyle('A5:' . $highestColumn . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => ['argb' => '000000'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A3')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        
        $sheet->getStyle('A5:P6')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 10,
                'color' => ['argb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => '2D5016'], 
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ]);

        
        $this->styleRowByContent($sheet, 'TOTAL MINISTERE', [
            'font' => [
                'bold' => true,
                'size' => 10,
                'color' => ['argb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => '1F3A0D'], 
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        
        $this->styleRowsByPattern($sheet, 'Effet ', [
            'font' => [
                'bold' => false,
                'size' => 10,
                'color' => ['argb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => '548235'], 
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        
        $this->styleRowsByPattern($sheet, 'Produit ', [
            'font' => [
                'bold' => false,
                'size' => 10,
                'color' => ['argb' => '000000'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'A9D18E'], 
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        
        $this->styleRowsByPattern($sheet, 'Action ', [
            'font' => [
                'bold' => false,
                'size' => 10,
                'color' => ['argb' => '000000'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'D5E8D4'], 
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        
        $this->styleRowsByPattern($sheet, 'Activité ', [
            'font' => [
                'bold' => false,
                'size' => 9,
                'color' => ['argb' => '000000'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        
        $sheet->getStyle('J7:N' . $highestRow)->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        
        $columnWidths = [
            'A' => 50, 
            'B' => 12, 
            'C' => 20, 
            'D' => 20, 
            'E' => 20, 
            'F' => 20, 
            'G' => 20, 
            'H' => 20, 
            'I' => 20, 
            'J' => 15, 
            'K' => 15, 
            'L' => 15, 
            'M' => 15, 
            'N' => 15, 
            'O' => 15, 
            'P' => 20, 
        ];

        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        
        $sheet->getRowDimension(1)->setRowHeight(25);
        $sheet->getRowDimension(3)->setRowHeight(20);
        $sheet->getRowDimension(5)->setRowHeight(20);
        $sheet->getRowDimension(6)->setRowHeight(20);
    }

    private function styleRowByContent($sheet, $searchText, $style)
    {
        $highestRow = $sheet->getHighestRow();

        for ($row = 1; $row <= $highestRow; $row++) {
            $cellValue = $sheet->getCell('A' . $row)->getValue();
            if (strpos($cellValue, $searchText) !== false) {
                $sheet->getStyle('A' . $row . ':P' . $row)->applyFromArray($style);
                break;
            }
        }
    }

    private function styleRowsByPattern($sheet, $pattern, $style)
    {
        $highestRow = $sheet->getHighestRow();

        for ($row = 1; $row <= $highestRow; $row++) {
            $cellValue = $sheet->getCell('A' . $row)->getValue();
            if (strpos($cellValue, $pattern) !== false) {
                $sheet->getStyle('A' . $row . ':P' . $row)->applyFromArray($style);
            }
        }
    }
}
