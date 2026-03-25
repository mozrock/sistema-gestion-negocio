<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4 flex-wrap">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Medios de Pago
            </h2>

            <div class="flex items-center gap-3">
                <a href="{{ route('payment-methods.create') }}"
                   class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">
                    Nuevo medio de pago
                </a>

                <form action="{{ route('payment-methods.index') }}" method="GET" class="flex items-center gap-2">
                    <input
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Buscar"
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
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($paymentMethods as $paymentMethod)
                            <tr>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100">{{ $paymentMethod->name }}</td>
                                <td class="px-6 py-4">
                                    @if($paymentMethod->is_active)
                                        <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-700">Activo</span>
                                    @else
                                        <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-700">Inactivo</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('payment-methods.edit', $paymentMethod) }}"
                                       class="text-indigo-600 hover:text-indigo-800 mr-3">
                                        Editar
                                    </a>

                                    <form action="{{ route('payment-methods.destroy', $paymentMethod) }}"
                                          method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('¿Deseas eliminar este medio de pago?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-6 text-center text-gray-500">
                                    No hay medios de pago registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $paymentMethods->links() }}
            </div>
        </div>
    </div>
</x-app-layout>