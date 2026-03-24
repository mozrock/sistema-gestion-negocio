<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Registrar servicio</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Registrar la operación del día.</p>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Trabajadoras</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Consultar y administrar trabajadoras.</p>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Reportes</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Ver reportes operativos.</p>
                </div>
            </div>

            <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Bienvenida</h3>
                <p class="mt-2 text-gray-700 dark:text-gray-300">
                    Hola, {{ auth()->user()->name }}. Este es el panel de Admin.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>