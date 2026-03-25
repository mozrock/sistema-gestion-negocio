<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4 flex-wrap">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Registros de Servicios
            </h2>

            <div class="flex flex-col md:flex-row gap-3 items-start md:items-center">
                <a href="{{ route('service-records.create') }}"
                   class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">
                    Nuevo registro
                </a>

                <form action="{{ route('service-records.index') }}" method="GET"
                      class="flex flex-col md:flex-row gap-3">

                    <input
                        type="text"
                        name="worker"
                        value="{{ request('worker') }}"
                        placeholder="Buscar por trabajadora"
                        class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                    >

                    <input
                        type="date"
                        name="service_date"
                        value="{{ request('service_date') }}"
                        class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                    >

                    <button type="submit"
                            class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">
                        Buscar
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 rounded-md bg-green-100 text-green-800 px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="overflow-x-auto">

                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100 dark:bg-gray-900">
                            <tr>
                                <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-200">Fecha</th>
                                <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-200">Trabajadora</th>
                                <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-200">Servicio</th>
                                <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-200">Pago</th>
                                <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-200">Precio</th>
                                <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-200">Descuentos</th>
                                <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-200">Neto</th>
                                <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-200">Dueño</th>
                                <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-200">Trabajadora</th>
                                <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-200">Pendiente</th>
                                <th class="px-4 py-3 text-right text-gray-700 dark:text-gray-200">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">

                            @forelse($serviceRecords as $record)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40">

                                    <td class="px-4 py-3 text-gray-900 dark:text-gray-100">
                                        {{ $record->service_date }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-900 dark:text-gray-100">
                                        {{ $record->worker?->name }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-900 dark:text-gray-100">
                                        {{ $record->service?->name }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-900 dark:text-gray-100">
                                        {{ $record->paymentMethod?->name ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-900 dark:text-gray-100">
                                        ${{ number_format($record->service_price, 0, ',', '.') }}
                                    </td>

                                    <td class="px-4 py-3 text-red-600 dark:text-red-400">
                                        ${{ number_format($record->total_discounts, 0, ',', '.') }}
                                    </td>

                                    <td class="px-4 py-3 text-yellow-600 dark:text-yellow-300">
                                        ${{ number_format($record->net_total, 0, ',', '.') }}
                                    </td>

                                    <td class="px-4 py-3 text-blue-600 dark:text-blue-300">
                                        ${{ number_format($record->owner_total, 0, ',', '.') }}
                                    </td>

                                    <td class="px-4 py-3 text-green-600 dark:text-green-300">
                                        ${{ number_format($record->worker_total, 0, ',', '.') }}
                                    </td>

                                    <td class="px-4 py-3 text-orange-600 dark:text-orange-300">
                                        ${{ number_format($record->pending_balance, 0, ',', '.') }}
                                    </td>

                                    <td class="px-4 py-3 text-right">

                                        <a href="{{ route('service-records.edit', $record) }}"
                                           class="text-indigo-600 dark:text-indigo-400 hover:underline mr-3">
                                            Editar
                                        </a>

                                        <form action="{{ route('service-records.destroy', $record) }}"
                                              method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('¿Deseas eliminar este registro?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 dark:text-red-400 hover:underline">
                                                Eliminar
                                            </button>
                                        </form>

                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="11"
                                        class="px-4 py-6 text-center text-gray-500 dark:text-gray-300">
                                        No hay registros creados.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                {{ $serviceRecords->links() }}
            </div>

        </div>
    </div>
</x-app-layout>