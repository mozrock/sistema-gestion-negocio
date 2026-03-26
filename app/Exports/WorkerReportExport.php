<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WorkerReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle, WithEvents
{
    protected Collection $records;

    public function __construct(Collection $records)
    {
        $this->records = $records;
    }

    public function collection(): Collection
    {
        return $this->records;
    }

    public function headings(): array
    {
        return [
            'Fecha',
            'Trabajadora',
            'Servicio',
            'Medio de pago',
            'Precio',
            'Descuentos',
            'Neto',
            'Dueño',
            'Trabajadora total',
            'Pendiente',
            'Hora entrada',
            'Hora salida',
            'Habitación',
            'Seguridad',
            'Adelanto',
            'Adicional',
            'Noches',
            'Pañitos',
            'Multa',
            'Descripción multa',
            'Notas',
        ];
    }

    public function map($record): array
    {
        return [
            $record->service_date,
            $record->worker->name ?? '',
            $record->service->name ?? '',
            $record->paymentMethod->name ?? '',
            (float) $record->service_price,
            (float) $record->total_discounts,
            (float) $record->net_total,
            (float) $record->owner_total,
            (float) $record->worker_total,
            (float) $record->pending_balance,
            $record->start_time,
            $record->end_time,
            (float) $record->room_cost,
            (float) $record->security_cost,
            (float) $record->advance_payment,
            (float) $record->additional_cost,
            (float) $record->night_cost,
            (float) $record->wipes_cost,
            (float) $record->fine_amount,
            $record->fine_description,
            $record->notes,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $highestRow = $sheet->getHighestRow();

        $sheet->freezePane('A2');
        $sheet->setAutoFilter("A1:U{$highestRow}");

        $sheet->getStyle('A1:U1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F46E5'],
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
        ]);

        $sheet->getRowDimension(1)->setRowHeight(24);

        $sheet->getStyle("A2:A{$highestRow}")->getNumberFormat()->setFormatCode('yyyy-mm-dd');
        $sheet->getStyle("K2:L{$highestRow}")->getNumberFormat()->setFormatCode('hh:mm');
        $sheet->getStyle("E2:J{$highestRow}")->getNumberFormat()->setFormatCode('"$"#,##0');
        $sheet->getStyle("M2:S{$highestRow}")->getNumberFormat()->setFormatCode('"$"#,##0');

        $sheet->getStyle("A1:U{$highestRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'D1D5DB'],
                ],
            ],
            'alignment' => [
                'vertical' => 'center',
            ],
        ]);

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastDataRow = $sheet->getHighestRow();
                $totalRow = $lastDataRow + 2;

                $sheet->setCellValue("D{$totalRow}", 'TOTALES');
                $sheet->setCellValue("E{$totalRow}", "=SUM(E2:E{$lastDataRow})");
                $sheet->setCellValue("F{$totalRow}", "=SUM(F2:F{$lastDataRow})");
                $sheet->setCellValue("G{$totalRow}", "=SUM(G2:G{$lastDataRow})");
                $sheet->setCellValue("H{$totalRow}", "=SUM(H2:H{$lastDataRow})");
                $sheet->setCellValue("I{$totalRow}", "=SUM(I2:I{$lastDataRow})");
                $sheet->setCellValue("J{$totalRow}", "=SUM(J2:J{$lastDataRow})");
                $sheet->setCellValue("M{$totalRow}", "=SUM(M2:M{$lastDataRow})");
                $sheet->setCellValue("N{$totalRow}", "=SUM(N2:N{$lastDataRow})");
                $sheet->setCellValue("O{$totalRow}", "=SUM(O2:O{$lastDataRow})");
                $sheet->setCellValue("P{$totalRow}", "=SUM(P2:P{$lastDataRow})");
                $sheet->setCellValue("Q{$totalRow}", "=SUM(Q2:Q{$lastDataRow})");
                $sheet->setCellValue("R{$totalRow}", "=SUM(R2:R{$lastDataRow})");
                $sheet->setCellValue("S{$totalRow}", "=SUM(S2:S{$lastDataRow})");

                $sheet->getStyle("D{$totalRow}:S{$totalRow}")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '111827'],
                    ],
                ]);

                $sheet->getStyle("E{$totalRow}:J{$totalRow}")->getNumberFormat()->setFormatCode('"$"#,##0');
                $sheet->getStyle("M{$totalRow}:S{$totalRow}")->getNumberFormat()->setFormatCode('"$"#,##0');
            },
        ];
    }

    public function title(): string
    {
        return 'Reporte trabajadoras';
    }
}