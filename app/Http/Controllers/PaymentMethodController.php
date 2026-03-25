<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentMethodRequest;
use App\Http\Requests\UpdatePaymentMethodRequest;
use App\Models\PaymentMethod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentMethodController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorizePaymentMethodAccess();

        $search = $request->get('search');

        $paymentMethods = PaymentMethod::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('payment-methods.index', compact('paymentMethods', 'search'));
    }

    public function create(): View
    {
        $this->authorizePaymentMethodAccess();

        return view('payment-methods.create');
    }

    public function store(StorePaymentMethodRequest $request): RedirectResponse
    {
        $this->authorizePaymentMethodAccess();

        PaymentMethod::create($request->validated());

        return redirect()
            ->route('payment-methods.index')
            ->with('success', 'Medio de pago creado correctamente.');
    }

    public function edit(PaymentMethod $paymentMethod): View
    {
        $this->authorizePaymentMethodAccess();

        return view('payment-methods.edit', compact('paymentMethod'));
    }

    public function update(UpdatePaymentMethodRequest $request, PaymentMethod $paymentMethod): RedirectResponse
    {
        $this->authorizePaymentMethodAccess();

        $paymentMethod->update($request->validated());

        return redirect()
            ->route('payment-methods.index')
            ->with('success', 'Medio de pago actualizado correctamente.');
    }

    public function destroy(PaymentMethod $paymentMethod): RedirectResponse
    {
        $this->authorizePaymentMethodAccess();

        $paymentMethod->delete();

        return redirect()
            ->route('payment-methods.index')
            ->with('success', 'Medio de pago eliminado correctamente.');
    }

    private function authorizePaymentMethodAccess(): void
    {
        $user = request()->user();

        abort_unless($user && $user->hasAnyRole(['super_admin', 'admin']), 403);
    }
}