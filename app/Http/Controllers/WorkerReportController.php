<?php

namespace App\Http\Controllers;

use App\Exports\WorkerReportExport;
use App\Models\ServiceRecord;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class WorkerReportController extends Controller
{
    public function index(Request $request): View|BinaryFileResponse
    {
        $workers = Worker::where('is_active', true)
            ->orderBy('name')
            ->get();

        $workerId = $request->worker_id;
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $query = ServiceRecord::with(['worker', 'service', 'paymentMethod'])
            ->orderByDesc('service_date')
            ->orderByDesc('id');

        if (!empty($workerId)) {
            $query->where('worker_id', $workerId);
        }

        if (!empty($startDate)) {
            $query->whereDate('service_date', '>=', $startDate);
        }

        if (!empty($endDate)) {
            $query->whereDate('service_date', '<=', $endDate);
        }

        $records = $query->get();

        if ($request->filled('export') && $request->export === 'excel') {
            $filename = 'reporte_trabajadoras_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

return Excel::download(
    new WorkerReportExport($records),
    $filename

            );
        }

        $summary = [
            'total_records' => $records->count(),
            'total_facturado' => $records->sum('service_price'),
            'total_descuentos' => $records->sum('total_discounts'),
            'neto' => $records->sum('net_total'),
            'total_trabajadora' => $records->sum('worker_total'),
            'saldo_pendiente' => $records->sum('pending_balance'),
        ];

        $workersSummary = $records
            ->groupBy(function ($record) {
                return $record->worker->name ?? 'Sin nombre';
            })
            ->map(function ($items, $workerName) {
                return [
                    'worker_name' => $workerName,
                    'cantidad' => $items->count(),
                    'total' => $items->sum('service_price'),
                    'neto' => $items->sum('net_total'),
                    'trabajadora' => $items->sum('worker_total'),
                    'pendiente' => $items->sum('pending_balance'),
                ];
            })
            ->sortByDesc('total');

        return view('reports.workers.index', [
            'workers' => $workers,
            'records' => $records,
            'workerId' => $workerId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'summary' => $summary,
            'workersSummary' => $workersSummary,
        ]);
    }
}