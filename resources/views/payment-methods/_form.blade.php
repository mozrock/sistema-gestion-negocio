<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre</label>
        <input
            type="text"
            name="name"
            value="{{ old('name', $paymentMethod->name ?? '') }}"
            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
            required
        >
        @error('name')
            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Estado</label>
        <select
            name="is_active"
            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
            required
        >
            <option value="1" {{ old('is_active', $paymentMethod->is_active ?? 1) == 1 ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ old('is_active', $paymentMethod->is_active ?? 1) == 0 ? 'selected' : '' }}>Inactivo</option>
        </select>
        @error('is_active')
            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>