<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRecordRequest;
use App\Http\Requests\UpdateServiceRecordRequest;
use App\Models\PaymentMethod;
use App\Models\Service;
use App\Models\ServiceRecord;
use App\Models\Worker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceRecordController extends Controller
{
    public function index(\Illuminate\Http\Request $request): \Illuminate\View\View
{
    $this->authorizeServiceRecordAccess();

    $query = \App\Models\ServiceRecord::with(['worker', 'service', 'paymentMethod'])
        ->latest('service_date')
        ->latest('id');

    if ($request->filled('worker')) {
        $workerSearch = $request->worker;

        $query->whereHas('worker', function ($q) use ($workerSearch) {
            $q->where('name', 'like', '%' . $workerSearch . '%');
        });
    }

    if ($request->filled('service_date')) {
        $query->whereDate('service_date', $request->service_date);
    }

    $serviceRecords = $query->paginate(10)->withQueryString();

    return view('service-records.index', compact('serviceRecords'));
}

    public function create(): View
    {
        $this->authorizeServiceRecordAccess();

        $workers = Worker::where('is_active', true)->orderBy('name')->get();
        $services = Service::where('is_active', true)->orderBy('name')->get();
        $paymentMethods = PaymentMethod::where('is_active', true)->orderBy('name')->get();

        return view('service-records.create', compact('workers', 'services', 'paymentMethods'));
    }

    public function store(StoreServiceRecordRequest $request): RedirectResponse
    {
        $this->authorizeServiceRecordAccess();

        $data = $request->validated();

        $roomCost = (float) ($data['room_cost'] ?? 0);
        $securityCost = (float) ($data['security_cost'] ?? 0);
        $additionalCost = (float) ($data['additional_cost'] ?? 0);
        $nightCost = (float) ($data['night_cost'] ?? 0);
        $wipesCost = (float) ($data['wipes_cost'] ?? 0);
        $fineAmount = (float) ($data['fine_amount'] ?? 0);
        $advancePayment = (float) ($data['advance_payment'] ?? 0);
        $servicePrice = (float) ($data['service_price'] ?? 0);

        $totalDiscounts = $roomCost + $securityCost + $additionalCost + $nightCost + $wipesCost + $fineAmount;
        $netTotal = $servicePrice - $totalDiscounts;
        $ownerTotal = $netTotal * 0.40;
        $workerTotal = $netTotal * 0.60;
        $pendingBalance = $servicePrice - $advancePayment;

    
        $data['created_by'] = request()->user()->id;
        $data['total_discounts'] = max($totalDiscounts, 0);
        $data['net_total'] = max($netTotal, 0);
        $data['owner_total'] = max($ownerTotal, 0);
        $data['worker_total'] = max($workerTotal, 0);
        $data['pending_balance'] = max($pendingBalance, 0);

        ServiceRecord::create($data);

        return redirect()
            ->route('service-records.index')
            ->with('success', 'Registro de servicio creado correctamente.');
    }

    public function edit(ServiceRecord $serviceRecord): View
    {
        $this->authorizeServiceRecordAccess();

        $workers = Worker::where('is_active', true)->orderBy('name')->get();
        $services = Service::where('is_active', true)->orderBy('name')->get();
        $paymentMethods = PaymentMethod::where('is_active', true)->orderBy('name')->get();

        return view('service-records.edit', compact('serviceRecord', 'workers', 'services', 'paymentMethods'));
    }

    public function update(UpdateServiceRecordRequest $request, ServiceRecord $serviceRecord): RedirectResponse
    {
        $this->authorizeServiceRecordAccess();

        $data = $request->validated();

        $roomCost = (float) ($data['room_cost'] ?? 0);
        $securityCost = (float) ($data['security_cost'] ?? 0);
        $additionalCost = (float) ($data['additional_cost'] ?? 0);
        $nightCost = (float) ($data['night_cost'] ?? 0);
        $wipesCost = (float) ($data['wipes_cost'] ?? 0);
        $fineAmount = (float) ($data['fine_amount'] ?? 0);
        $advancePayment = (float) ($data['advance_payment'] ?? 0);
        $servicePrice = (float) ($data['service_price'] ?? 0);

        $totalDiscounts = $roomCost + $securityCost + $additionalCost + $nightCost + $wipesCost + $fineAmount;
        $netTotal = $servicePrice - $totalDiscounts;
        $ownerTotal = $netTotal * 0.40;
        $workerTotal = $netTotal * 0.60;
        $pendingBalance = $servicePrice - $advancePayment;

        $data['total_discounts'] = max($totalDiscounts, 0);
        $data['net_total'] = max($netTotal, 0);
        $data['owner_total'] = max($ownerTotal, 0);
        $data['worker_total'] = max($workerTotal, 0);
        $data['pending_balance'] = max($pendingBalance, 0);

        $serviceRecord->update($data);

        return redirect()
            ->route('service-records.index')
            ->with('success', 'Registro de servicio actualizado correctamente.');
    }

    public function destroy(ServiceRecord $serviceRecord): RedirectResponse
    {
        $this->authorizeServiceRecordAccess();

        $serviceRecord->delete();

        return redirect()
            ->route('service-records.index')
            ->with('success', 'Registro de servicio eliminado correctamente.');
    }

    private function authorizeServiceRecordAccess(): void
    {
        $user = request()->user();

        abort_unless($user && $user->hasAnyRole(['super_admin', 'admin']), 403);
    }
}