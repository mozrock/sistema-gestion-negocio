<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- Total -->
    <div class="bg-blue-600 text-white p-6 rounded-xl shadow">
        <h3 class="text-lg font-semibold">Total Trabajadoras</h3>
        <p class="text-3xl mt-2">{{ $total }}</p>
    </div>

    <!-- Activas -->
    <div class="bg-green-600 text-white p-6 rounded-xl shadow">
        <h3 class="text-lg font-semibold">Activas</h3>
        <p class="text-3xl mt-2">{{ $active }}</p>
    </div>

    <!-- Inactivas -->
    <div class="bg-red-600 text-white p-6 rounded-xl shadow">
        <h3 class="text-lg font-semibold">Inactivas</h3>
        <p class="text-3xl mt-2">{{ $inactive }}</p>
    </div>

</div>

</x-app-layout>
