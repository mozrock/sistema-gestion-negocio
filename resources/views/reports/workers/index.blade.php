<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Reporte por Trabajadora
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <form method="GET" action="{{ route('reports.workers.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="worker_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Trabajadora
                        </label>
                        <select
                            name="worker_id"
                            id="worker_id"
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                        >
                            <option value="">Todas</option>
                            @foreach ($workers as $worker)
                                <option value="{{ $worker->id }}" {{ (string) $workerId === (string) $worker->id ? 'selected' : '' }}>
                                    {{ $worker->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Fecha inicio
                        </label>
                        <input
                            type="date"
                            name="start_date"
                            id="start_date"
                            value="{{ $startDate }}"
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                        >
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Fecha fin
                        </label>
                        <input
                            type="date"
                            name="end_date"
                            id="end_date"
                            value="{{ $endDate }}"
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                        >
                    </div>

                    <div class="flex items-end gap-3">
                        <button
                            type="submit"
                            class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700"
                        >
                            Filtrar
                        </button>

                        <a
                            href="{{ route('reports.workers.index') }}"
                            class="px-4 py-2 rounded-md bg-gray-500 text-white hover:bg-gray-600"
                        >
                            Limpiar
                        </a>
                        <button type="submit"
        name="export"
        value="excel"
        class="px-4 py-2 rounded-md bg-green-600 text-white hover:bg-green-700">
    Exportar Excel
</button>
                    </div>

                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase">Total registros</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $summary['total_records'] }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase">Total facturado</h3>
                    <p class="mt-2 text-3xl font-bold text-blue-500">${{ number_format($summary['total_facturado'], 0, ',', '.') }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase">Total descuentos</h3>
                    <p class="mt-2 text-3xl font-bold text-red-400">${{ number_format($summary['total_descuentos'], 0, ',', '.') }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase">Neto</h3>
                    <p class="mt-2 text-3xl font-bold text-yellow-400">${{ number_format($summary['neto'], 0, ',', '.') }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase">Total trabajadora</h3>
                    <p class="mt-2 text-3xl font-bold text-green-400">${{ number_format($summary['total_trabajadora'], 0, ',', '.') }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase">Saldo pendiente</h3>
                    <p class="mt-2 text-3xl font-bold text-orange-400">${{ number_format($summary['saldo_pendiente'], 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
        Ranking de trabajadoras
    </h3>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-900">
                <tr>
                    <th class="px-4 py-2 text-left text-xs text-gray-500 uppercase">Trabajadora</th>
                    <th class="px-4 py-2 text-left text-xs text-gray-500 uppercase">Servicios</th>
                    <th class="px-4 py-2 text-left text-xs text-gray-500 uppercase">Facturado</th>
                    <th class="px-4 py-2 text-left text-xs text-gray-500 uppercase">Neto</th>
                    <th class="px-4 py-2 text-left text-xs text-gray-500 uppercase">Ganancia</th>
                    <th class="px-4 py-2 text-left text-xs text-gray-500 uppercase">Pendiente</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($workersSummary as $item)
                    <tr>
                        <td class="px-4 py-2 text-sm text-white">
                            {{ $item['worker_name'] }}
                        </td>

                        <td class="px-4 py-2 text-sm text-gray-300">
                            {{ $item['cantidad'] }}
                        </td>

                        <td class="px-4 py-2 text-sm text-blue-400">
                            ${{ number_format($item['total'], 0, ',', '.') }}
                        </td>

                        <td class="px-4 py-2 text-sm text-yellow-400">
                            ${{ number_format($item['neto'], 0, ',', '.') }}
                        </td>

                        <td class="px-4 py-2 text-sm text-green-400">
                            ${{ number_format($item['trabajadora'], 0, ',', '.') }}
                        </td>

                        <td class="px-4 py-2 text-sm text-orange-400">
                            ${{ number_format($item['pendiente'], 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-400">
                            No hay datos
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        Detalle de registros
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Fecha</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Trabajadora</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Servicio</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Pago</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Precio</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Descuentos</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Neto</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Trabajadora</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Pendiente</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($records as $record)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $record->service_date }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $record->worker->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $record->service->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $record->paymentMethod->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-blue-400">
                                        ${{ number_format($record->service_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-red-400">
                                        ${{ number_format($record->total_discounts, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-yellow-400">
                                        ${{ number_format($record->net_total, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-green-400">
                                        ${{ number_format($record->worker_total, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-orange-400">
                                        ${{ number_format($record->pending_balance, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                                        No hay registros para los filtros seleccionados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>