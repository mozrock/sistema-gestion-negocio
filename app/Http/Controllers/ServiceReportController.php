<?php

namespace App\Http\Controllers;

use App\Exports\ServiceReportExport;
use App\Models\Service;
use App\Models\ServiceRecord;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ServiceReportController extends Controller
{
    public function index(Request $request): View|BinaryFileResponse
    {
        $services = Service::where('is_active', true)
            ->orderBy('name')
            ->get();

        $query = ServiceRecord::with(['worker', 'service', 'paymentMethod'])
            ->orderByDesc('service_date')
            ->orderByDesc('id');

        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('service_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('service_date', '<=', $request->end_date);
        }

        $records = $query->get();

        $totalRecords = $records->count();
        $totalFacturado = $records->sum('service_price');
        $totalDescuentos = $records->sum('total_discounts');
        $neto = $records->sum('net_total');
        $totalDueno = $records->sum('owner_total');
        $totalTrabajadora = $records->sum('worker_total');
        $saldoPendiente = $records->sum('pending_balance');

        $ranking = $records
            ->groupBy(fn ($record) => $record->service->name ?? 'Sin nombre')
            ->map(function ($items, $serviceName) {
                return [
                    'servicio' => $serviceName,
                    'cantidad' => $items->count(),
                    'facturado' => $items->sum('service_price'),
                    'descuentos' => $items->sum('total_discounts'),
                    'neto' => $items->sum('net_total'),
                    'dueno' => $items->sum('owner_total'),
                    'trabajadora' => $items->sum('worker_total'),
                    'pendiente' => $items->sum('pending_balance'),
                ];
            })
            ->sortByDesc('facturado');

        if ($request->filled('export') && $request->export === 'excel') {
            return Excel::download(
                new ServiceReportExport($records, [
                    'totalFacturado' => $totalFacturado,
                    'totalDescuentos' => $totalDescuentos,
                    'neto' => $neto,
                    'totalDueno' => $totalDueno,
                    'totalTrabajadora' => $totalTrabajadora,
                    'saldoPendiente' => $saldoPendiente,
                ]),
                'reporte_servicios_' . now()->format('Y-m-d_H-i-s') . '.xlsx'
            );
        }

        return view('reports.services.index', [
            'services' => $services,
            'records' => $records,
            'totalRecords' => $totalRecords,
            'totalFacturado' => $totalFacturado,
            'totalDescuentos' => $totalDescuentos,
            'neto' => $neto,
            'totalDueno' => $totalDueno,
            'totalTrabajadora' => $totalTrabajadora,
            'saldoPendiente' => $saldoPendiente,
            'ranking' => $ranking,
        ]);
    }
}