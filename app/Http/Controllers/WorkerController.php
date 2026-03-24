<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkerRequest;
use App\Http\Requests\UpdateWorkerRequest;
use App\Models\Worker;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class WorkerController extends Controller
{
    public function index(): View
    {
        $this->authorizeWorkerAccess();

    $workers = Worker::latest()->paginate(10);

    return view('workers.index', compact('workers'));
    }

    public function create(): View
    {
            $this->authorizeWorkerAccess();

        return view('workers.create');
    }

    public function store(StoreWorkerRequest $request): RedirectResponse
    {
         $this->authorizeWorkerAccess();

    Worker::create($request->validated());

    return redirect()
        ->route('workers.index')
        ->with('success', 'Trabajadora creada correctamente.');
    }

    public function edit(Worker $worker): View
    {
 $this->authorizeWorkerAccess();

    return view('workers.edit', compact('worker'));    }

    public function update(UpdateWorkerRequest $request, Worker $worker): RedirectResponse
    {
       $this->authorizeWorkerAccess();

    $worker->update($request->validated());

    return redirect()
        ->route('workers.index')
        ->with('success', 'Trabajadora actualizada correctamente.');
    }

    public function destroy(Worker $worker): RedirectResponse
    {
        $this->authorizeWorkerAccess();

    $worker->delete();

    return redirect()
        ->route('workers.index')
        ->with('success', 'Trabajadora eliminada correctamente.');

    }

    private function authorizeWorkerAccess(): void
{
    $user = request()->user();

    abort_unless($user && $user->hasAnyRole(['super_admin', 'admin']), 403);
}
}