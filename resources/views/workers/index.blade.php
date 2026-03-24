<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Trabajadoras
            </h2>

            <a href="{{ route('workers.create') }}"
               class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">
                Nueva trabajadora
            </a>
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Documento</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teléfono</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($workers as $worker)
                            <tr>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100">{{ $worker->name }}</td>
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $worker->document }}</td>
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $worker->phone }}</td>
                                <td class="px-6 py-4">
                                    @if($worker->is_active)
                                        <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-700">Activa</span>
                                    @else
                                        <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-700">Inactiva</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('workers.edit', $worker) }}"
                                       class="text-indigo-600 hover:text-indigo-800 mr-3">
                                        Editar
                                    </a>

                                    <form action="{{ route('workers.destroy', $worker) }}"
                                          method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('¿Deseas eliminar esta trabajadora?')">
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
                                <td colspan="5" class="px-6 py-6 text-center text-gray-500">
                                    No hay trabajadoras registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $workers->links() }}
            </div>
        </div>
    </div>
</x-app-layout>