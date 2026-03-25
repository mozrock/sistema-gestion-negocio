<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard Super Admin
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- MÉTRICAS -->
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

            <!-- CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <a href="#" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 block hover:scale-105 transition">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Usuarios</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                        Administración total del sistema.
                    </p>
                </a>

                <a href="{{ route('services.index') }}" 
                   class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 block hover:scale-105 transition">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Servicios</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                        Configuración de catálogo y precios.
                    </p>
                </a>

                <a href="#" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 block hover:scale-105 transition">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Reportes</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                        Consulta global del negocio.
                    </p>
                </a>

            </div>

            <!-- BIENVENIDA -->
            <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Bienvenida</h3>
                <p class="mt-2 text-gray-700 dark:text-gray-300">
                    Hola, {{ auth()->user()->name }}. Este es el panel de Super Admin.
                </p>
            </div>

        </div>
    </div>
</x-app-layout>