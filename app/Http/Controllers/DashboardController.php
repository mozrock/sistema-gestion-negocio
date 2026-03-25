<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        if ($user->hasRole('super_admin')) {
            return view('dashboard.super-admin', [
                'total' => Worker::count(),
                'active' => Worker::where('is_active', true)->count(),
                'inactive' => Worker::where('is_active', false)->count(),
            ]);
        }

        if ($user->hasRole('admin')) {
            return view('dashboard.admin');
        }

        if ($user->hasRole('trabajadora')) {
            return view('dashboard.trabajadora');
        }

        abort(403, 'No tienes un rol asignado.');
    }
}