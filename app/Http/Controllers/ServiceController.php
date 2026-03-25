<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorizeServiceAccess();

        $search = $request->get('search');

        $services = Service::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('services.index', compact('services', 'search'));
    }

    public function create(): View
    {
        $this->authorizeServiceAccess();

        return view('services.create');
    }

    public function store(StoreServiceRequest $request): RedirectResponse
    {
        $this->authorizeServiceAccess();

        Service::create($request->validated());

        return redirect()
            ->route('services.index')
            ->with('success', 'Servicio creado correctamente.');
    }

    public function edit(Service $service): View
    {
        $this->authorizeServiceAccess();

        return view('services.edit', compact('service'));
    }

    public function update(UpdateServiceRequest $request, Service $service): RedirectResponse
    {
        $this->authorizeServiceAccess();

        $service->update($request->validated());

        return redirect()
            ->route('services.index')
            ->with('success', 'Servicio actualizado correctamente.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $this->authorizeServiceAccess();

        $service->delete();

        return redirect()
            ->route('services.index')
            ->with('success', 'Servicio eliminado correctamente.');
    }

    private function authorizeServiceAccess(): void
    {
        $user = request()->user();

        abort_unless($user && $user->hasAnyRole(['super_admin', 'admin']), 403);
    }
}