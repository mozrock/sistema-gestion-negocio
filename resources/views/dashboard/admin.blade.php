<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- FILTROS --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
                <form action="{{ route('dashboard') }}" method="GET" class="space-y-4">

                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('dashboard', ['period' => 'today']) }}"
                           class="px-4 py-2 rounded-md text-white {{ ($period ?? '') === 'today' ? 'bg-indigo-700' : 'bg-indigo-600 hover:bg-indigo-700' }}">
                            Hoy
                        </a>

                        <a href="{{ route('dashboard', ['period' => 'week']) }}"
                           class="px-4 py-2 rounded-md text-white {{ ($period ?? '') === 'week' ? 'bg-indigo-700' : 'bg-indigo-600 hover:bg-indigo-700' }}">
                            Esta semana
                        </a>

                        <a href="{{ route('dashboard', ['period' => 'month']) }}"
                           class="px-4 py-2 rounded-md text-white {{ ($period ?? '') === 'month' ? 'bg-indigo-700' : 'bg-indigo-600 hover:bg-indigo-700' }}">
                            Este mes
                        </a>

                        <a href="{{ route('dashboard', ['period' => 'year']) }}"
                           class="px-4 py-2 rounded-md text-white {{ ($period ?? '') === 'year' ? 'bg-indigo-700' : 'bg-indigo-600 hover:bg-indigo-700' }}">
                            Este año
                        </a>

                        <a href="{{ route('dashboard', ['period' => 'all']) }}"
                           class="px-4 py-2 rounded-md text-white {{ ($period ?? '') === 'all' ? 'bg-gray-700' : 'bg-gray-600 hover:bg-gray-700' }}">
                            Histórico
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Fecha inicio
                            </label>
                            <input type="date"
                                   name="start_date"
                                   id="start_date"
                                   value="{{ $start_date ?? '' }}"
                                   class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Fecha fin
                            </label>
                            <input type="date"
                                   name="end_date"
                                   id="end_date"
                                   value="{{ $end_date ?? '' }}"
                                   class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                        </div>

                        <div class="flex gap-2">
                            <button type="submit"
                                    class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">
                                Filtrar
                            </button>

                            <a href="{{ route('dashboard') }}"
                               class="px-4 py-2 rounded-md bg-gray-500 text-white hover:bg-gray-600">
                                Limpiar
                            </a>
                        </div>

                        <div class="text-sm text-gray-600 dark:text-gray-300">
                            @if($start_date || $end_date)
                                Mostrando resultados filtrados por fecha.
                            @else
                                Mostrando total histórico acumulado.
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            {{-- TARJETAS DE TRABAJADORAS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-blue-600 text-white p-6 rounded-xl shadow">
                    <h3 class="text-lg font-semibold">Total Trabajadoras</h3>
                    <p class="text-3xl mt-2">{{ $total }}</p>
                </div>

                <div class="bg-green-600 text-white p-6 rounded-xl shadow">
                    <h3 class="text-lg font-semibold">Activas</h3>
                    <p class="text-3xl mt-2">{{ $active }}</p>
                </div>

                <div class="bg-red-600 text-white p-6 rounded-xl shadow">
                    <h3 class="text-lg font-semibold">Inactivas</h3>
                    <p class="text-3xl mt-2">{{ $inactive }}</p>
                </div>
            </div>

            {{-- TARJETAS FINANCIERAS 1 --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase">Registros</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $records_count }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase">Total Facturado</h3>
                    <p class="mt-2 text-3xl font-bold text-blue-400">${{ number_format($total_service_price, 0, ',', '.') }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase">Total Descuentos</h3>
                    <p class="mt-2 text-3xl font-bold text-red-400">${{ number_format($total_discounts, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- TARJETAS FINANCIERAS 2 --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase">Neto</h3>
                    <p class="mt-2 text-3xl font-bold text-yellow-400">${{ number_format($total_net, 0, ',', '.') }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase">Total Dueño</h3>
                    <p class="mt-2 text-3xl font-bold text-cyan-400">${{ number_format($total_owner, 0, ',', '.') }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase">Total Trabajadoras</h3>
                    <p class="mt-2 text-3xl font-bold text-green-400">${{ number_format($total_worker, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- SALDO PENDIENTE --}}
            <div class="grid grid-cols-1 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase">Saldo Pendiente</h3>
                    <p class="mt-2 text-3xl font-bold text-orange-400">${{ number_format($total_pending, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- ACCESOS RÁPIDOS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <a href="{{ route('workers.index') }}"
                   class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 block hover:scale-105 transition">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Trabajadoras</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Gestión de trabajadoras.</p>
                </a>

                <a href="{{ route('service-records.index') }}"
                   class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 block hover:scale-105 transition">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Registros</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Consulta de registros financieros.</p>
                </a>

                <a href="{{ route('payment-methods.index') }}"
                   class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 block hover:scale-105 transition">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Medios de pago</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Administración de métodos de pago.</p>
                </a>
            </div>

            {{-- BIENVENIDA --}}
            <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Bienvenida</h3>
                <p class="mt-2 text-gray-700 dark:text-gray-300">
                    Hola, {{ auth()->user()->name }}. Este es el panel de Admin.
                </p>
            </div>

        </div>
    </div>
</x-app-layout>