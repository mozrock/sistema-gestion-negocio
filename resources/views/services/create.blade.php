<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Crear Servicio
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <form action="{{ route('services.store') }}" method="POST" class="space-y-6">
                    @csrf

                    @php($service = null)
                    @include('services._form')

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('services.index') }}"
                           class="px-4 py-2 rounded-md bg-gray-500 text-white hover:bg-gray-600">
                            Cancelar
                        </a>

                        <button type="submit"
                                class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>