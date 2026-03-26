<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Reporte por Servicio
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <form action="{{ route('reports.services.index') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        <div>
                            <label for="service_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Servicio
                            </label>
                            <select name="service_id" id="service_id"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                <option value="">Todos</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}"
                                        {{ request('service_id') == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Fecha inicio
                            </label>
                            <input type="date" name="start_date" id="start_date"
                                value="{{ request('start_date') }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Fecha fin
                            </label>
                            <input type="date" name="end_date" id="end_date"
                                value="{{ request('end_date') }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                        </div>

                        <div class="flex gap-2">
                            <button type="submit"
                                class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">
                                Filtrar
                            </button>

                            <a href="{{ route('reports.services.index') }}"
                                class="px-4 py-2 rounded-md bg-gray-500 text-white hover:bg-gray-600">
                                Limpiar
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total registros</p>
                    <h3 class="text-3xl font-bold text-white mt-2">{{ $totalRecords }}</h3>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total facturado</p>
                    <h3 class="text-3xl font-bold text-blue-400 mt-2">${{ number_format($totalFacturado, 0, ',', '.') }}</h3>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total descuentos</p>
                    <h3 class="text-3xl font-bold text-red-400 mt-2">${{ number_format($totalDescuentos, 0, ',', '.') }}</h3>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Neto</p>
                    <h3 class="text-3xl font-bold text-yellow-400 mt-2">${{ number_format($neto, 0, ',', '.') }}</h3>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total dueño</p>
                    <h3 class="text-3xl font-bold text-cyan-400 mt-2">${{ number_format($totalDueno, 0, ',', '.') }}</h3>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total trabajadoras</p>
                    <h3 class="text-3xl font-bold text-green-400 mt-2">${{ number_format($totalTrabajadora, 0, ',', '.') }}</h3>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <p class="text-sm text-gray-500 dark:text-gray-400">Saldo pendiente</p>
                <h3 class="text-3xl font-bold text-orange-400 mt-2">${{ number_format($saldoPendiente, 0, ',', '.') }}</h3>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Ranking de servicios</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="px-4 py-3 text-left">Servicio</th>
                                <th class="px-4 py-3 text-left">Cantidad</th>
                                <th class="px-4 py-3 text-left">Facturado</th>
                                <th class="px-4 py-3 text-left">Descuentos</th>
                                <th class="px-4 py-3 text-left">Neto</th>
                                <th class="px-4 py-3 text-left">Dueño</th>
                                <th class="px-4 py-3 text-left">Trabajadora</th>
                                <th class="px-4 py-3 text-left">Pendiente</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($ranking as $item)
                                <tr class="text-gray-900 dark:text-gray-100">
                                    <td class="px-4 py-3">{{ $item['servicio'] }}</td>
                                    <td class="px-4 py-3">{{ $item['cantidad'] }}</td>
                                    <td class="px-4 py-3 text-blue-400">${{ number_format($item['facturado'], 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-red-400">${{ number_format($item['descuentos'], 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-yellow-400">${{ number_format($item['neto'], 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-cyan-400">${{ number_format($item['dueno'], 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-green-400">${{ number_format($item['trabajadora'], 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-orange-400">${{ number_format($item['pendiente'], 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No hay datos para mostrar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Detalle de registros</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="px-4 py-3 text-left">Fecha</th>
                                <th class="px-4 py-3 text-left">Trabajadora</th>
                                <th class="px-4 py-3 text-left">Servicio</th>
                                <th class="px-4 py-3 text-left">Pago</th>
                                <th class="px-4 py-3 text-left">Precio</th>
                                <th class="px-4 py-3 text-left">Descuentos</th>
                                <th class="px-4 py-3 text-left">Neto</th>
                                <th class="px-4 py-3 text-left">Trabajadora</th>
                                <th class="px-4 py-3 text-left">Pendiente</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($records as $record)
                                <tr class="text-gray-900 dark:text-gray-100">
                                    <td class="px-4 py-3">{{ $record->service_date }}</td>
                                    <td class="px-4 py-3">{{ $record->worker->name ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $record->service->name ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $record->paymentMethod->name ?? '-' }}</td>
                                    <td class="px-4 py-3 text-blue-400">${{ number_format($record->service_price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-red-400">${{ number_format($record->total_discounts, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-yellow-400">${{ number_format($record->net_total, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-green-400">${{ number_format($record->worker_total, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-orange-400">${{ number_format($record->pending_balance, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No hay registros para mostrar.
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