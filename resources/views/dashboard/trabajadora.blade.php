<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Mi Panel
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Mis servicios</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Consulta de servicios realizados.</p>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Mis pagos</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Consulta de pagos y liquidaciones.</p>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Mis estadísticas</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Resumen personal de actividad.</p>
                </div>
            </div>

            <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Bienvenida</h3>
                <p class="mt-2 text-gray-700 dark:text-gray-300">
                    Hola, {{ auth()->user()->name }}. Este es tu panel personal.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>