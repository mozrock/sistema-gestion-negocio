<?php

namespace App\Http\Controllers;

use App\Models\ServiceRecord;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $period = $request->get('period');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        if ($period === 'today') {
            $startDate = Carbon::today()->toDateString();
            $endDate = Carbon::today()->toDateString();
        } elseif ($period === 'week') {
            $startDate = Carbon::now()->startOfWeek()->toDateString();
            $endDate = Carbon::now()->endOfWeek()->toDateString();
        } elseif ($period === 'month') {
            $startDate = Carbon::now()->startOfMonth()->toDateString();
            $endDate = Carbon::now()->endOfMonth()->toDateString();
        } elseif ($period === 'year') {
            $startDate = Carbon::now()->startOfYear()->toDateString();
            $endDate = Carbon::now()->endOfYear()->toDateString();
        } elseif ($period === 'all') {
            $startDate = null;
            $endDate = null;
        }

        $workerStats = [
            'total' => Worker::count(),
            'active' => Worker::where('is_active', true)->count(),
            'inactive' => Worker::where('is_active', false)->count(),
        ];

        $recordsQuery = ServiceRecord::query();

        if ($startDate) {
            $recordsQuery->whereDate('service_date', '>=', $startDate);
        }

        if ($endDate) {
            $recordsQuery->whereDate('service_date', '<=', $endDate);
        }

        $financialStats = [
            'records_count' => (clone $recordsQuery)->count(),
            'total_service_price' => (clone $recordsQuery)->sum('service_price'),
            'total_discounts' => (clone $recordsQuery)->sum('total_discounts'),
            'total_net' => (clone $recordsQuery)->sum('net_total'),
            'total_owner' => (clone $recordsQuery)->sum('owner_total'),
            'total_worker' => (clone $recordsQuery)->sum('worker_total'),
            'total_pending' => (clone $recordsQuery)->sum('pending_balance'),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'period' => $period,
        ];

        if ($user->hasRole('super_admin')) {
            return view('dashboard.super-admin', array_merge($workerStats, $financialStats));
        }

        if ($user->hasRole('admin')) {
            return view('dashboard.admin', array_merge($workerStats, $financialStats));
        }

        if ($user->hasRole('trabajadora')) {
            return view('dashboard.trabajadora');
        }

        abort(403, 'No tienes un rol asignado.');
    }
}