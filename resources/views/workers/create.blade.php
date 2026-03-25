<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Crear Trabajadora
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <form action="{{ route('workers.store') }}" method="POST" class="space-y-6">
                    @csrf

                    @include('workers._form')

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('workers.index') }}"
                           class="px-4 py-2 rounded-md bg-gray-500 text-white hover:bg-gray-600">
                            Cancelar
                        </a>

          <button
        type="submit"
        id="btnGuardar"
        class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700"
    >
        Guardar
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        const btnGuardar = document.getElementById('btnGuardar');

        if (form && btnGuardar) {
            form.addEventListener('submit', function () {
                btnGuardar.disabled = true;
                btnGuardar.innerText = 'Guardando...';
            });
        }
    });
</script>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>