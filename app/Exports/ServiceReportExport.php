<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ServiceReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents, WithTitle
{
    protected Collection $records;
    protected array $summary;

    public function __construct(Collection $records, array $summary)
    {
        $this->records = $records;
        $this->summary = $summary;
    }

    public function title(): string
    {
        return 'Reporte servicios';
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
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => '4F46E5'],
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                $lastDataRow = $this->records->count() + 1;
                $summaryRow = $lastDataRow + 2;

                $sheet->setCellValue("D{$summaryRow}", 'TOTALES');
                $sheet->setCellValue("E{$summaryRow}", (float) ($this->summary['totalFacturado'] ?? 0));
                $sheet->setCellValue("F{$summaryRow}", (float) ($this->summary['totalDescuentos'] ?? 0));
                $sheet->setCellValue("G{$summaryRow}", (float) ($this->summary['neto'] ?? 0));
                $sheet->setCellValue("H{$summaryRow}", (float) ($this->summary['totalDueno'] ?? 0));
                $sheet->setCellValue("I{$summaryRow}", (float) ($this->summary['totalTrabajadora'] ?? 0));
                $sheet->setCellValue("J{$summaryRow}", (float) ($this->summary['saldoPendiente'] ?? 0));

                $sheet->getStyle("D{$summaryRow}:J{$summaryRow}")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['rgb' => '111827'],
                    ],
                ]);

                foreach (['E', 'F', 'G', 'H', 'I', 'J', 'M', 'N', 'O', 'P', 'Q', 'R', 'S'] as $column) {
                    $sheet->getStyle("{$column}2:{$column}{$summaryRow}")
                        ->getNumberFormat()
                        ->setFormatCode('#,##0');
                }

                $sheet->freezePane('A2');
                $sheet->setAutoFilter("A1:U1");
            },
        ];
    }
}