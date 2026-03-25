<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Trabajadora</label>
        <select
            name="worker_id"
            id="worker_id"
            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
            required
        >
            <option value="">Seleccione</option>
            @foreach($workers as $worker)
                <option value="{{ $worker->id }}"
                    {{ old('worker_id', $serviceRecord->worker_id ?? '') == $worker->id ? 'selected' : '' }}>
                    {{ $worker->name }}
                </option>
            @endforeach
        </select>
        @error('worker_id')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Servicio</label>
        <select
            name="service_id"
            id="service_id"
            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
            required
        >
            <option value="">Seleccione</option>
            @foreach($services as $service)
                <option value="{{ $service->id }}"
                    {{ old('service_id', $serviceRecord->service_id ?? '') == $service->id ? 'selected' : '' }}>
                    {{ $service->name }}
                </option>
            @endforeach
        </select>
        @error('service_id')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Medio de pago</label>
        <select
            name="payment_method_id"
            id="payment_method_id"
            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
        >
            <option value="">Seleccione</option>
            @foreach($paymentMethods as $paymentMethod)
                <option value="{{ $paymentMethod->id }}"
                    {{ old('payment_method_id', $serviceRecord->payment_method_id ?? '') == $paymentMethod->id ? 'selected' : '' }}>
                    {{ $paymentMethod->name }}
                </option>
            @endforeach
        </select>
        @error('payment_method_id')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha del servicio</label>
        <input
            type="date"
            name="service_date"
            id="service_date"
            value="{{ old('service_date', isset($serviceRecord->service_date) ? \Carbon\Carbon::parse($serviceRecord->service_date)->format('Y-m-d') : '') }}"
            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
            required
        >
        @error('service_date')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hora entrada</label>
        <input
            type="time"
            name="start_time"
            id="start_time"
            value="{{ old('start_time', isset($serviceRecord->start_time) ? \Illuminate\Support\Str::substr($serviceRecord->start_time, 0, 5) : '') }}"
            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
        >
        @error('start_time')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hora salida</label>
        <input
            type="time"
            name="end_time"
            id="end_time"
            value="{{ old('end_time', isset($serviceRecord->end_time) ? \Illuminate\Support\Str::substr($serviceRecord->end_time, 0, 5) : '') }}"
            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
        >
        @error('end_time')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="service_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            Valor servicio
        </label>
        <input
            type="number"
            step="0.01"
            min="0"
            name="service_price"
            id="service_price"
            value="{{ old('service_price', $serviceRecord->service_price ?? 0) }}"
            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 shadow-sm"
            required
        >
        @error('service_price')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Habitación</label>
        <input
            type="number"
            step="0.01"
            min="0"
            name="room_cost"
            id="room_cost"
            value="{{ old('room_cost', $serviceRecord->room_cost ?? 0) }}"
            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
        >
        @error('room_cost')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Seguridad</label>
        <input
            type="number"
            step="0.01"
            min="0"
            name="security_cost"
            id="security_cost"
            value="{{ old('security_cost', $serviceRecord->security_cost ?? 0) }}"
            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
        >
        @error('security_cost')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Adelanto</label>
        <input
            type="number"
            step="0.01"
            min="0"
            name="advance_payment"
            id="advance_payment"
            value="{{ old('advance_payment', $serviceRecord->advance_payment ?? 0) }}"
            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
        >
        @error('advance_payment')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Adicional</label>
        <input
            type="number"
            step="0.01"
            min="0"
            name="additional_cost"
            id="additional_cost"
            value="{{ old('additional_cost', $serviceRecord->additional_cost ?? 0) }}"
            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
        >
        @error('additional_cost')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Noches</label>
        <input
            type="number"
            step="0.01"
            min="0"
            name="night_cost"
            id="night_cost"
            value="{{ old('night_cost', $serviceRecord->night_cost ?? 0) }}"
            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
        >
        @error('night_cost')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-6 text-sm">

    <div class="bg-gray-900 p-3 rounded">
        <p class="text-gray-400">Descuentos</p>
        <p id="preview_discounts" class="text-red-400 font-bold">$0</p>
    </div>

    <div class="bg-gray-900 p-3 rounded">
        <p class="text-gray-400">Neto</p>
        <p id="preview_net" class="text-yellow-400 font-bold">$0</p>
    </div>

    <div class="bg-gray-900 p-3 rounded">
        <p class="text-gray-400">Dueño</p>
        <p id="preview_owner" class="text-blue-400 font-bold">$0</p>
    </div>

    <div class="bg-gray-900 p-3 rounded">
        <p class="text-gray-400">Trabajadora</p>
        <p id="preview_worker" class="text-green-400 font-bold">$0</p>
    </div>

    <div class="bg-gray-900 p-3 rounded">
        <p class="text-gray-400">Pendiente</p>
        <p id="preview_pending" class="text-orange-400 font-bold">$0</p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const getValue = (id) => parseFloat(document.getElementById(id)?.value || 0);

    const format = (value) => {
        return '$' + value.toLocaleString('es-CO');
    };

    const calculate = () => {
        const service_price = getValue('service_price');
        const room = getValue('room_cost');
        const security = getValue('security_cost');
        const additional = getValue('additional_cost');
        const night = getValue('night_cost');
        const wipes = getValue('wipes_cost');
        const fine = getValue('fine_amount');
        const advance = getValue('advance_payment');

        const discounts = room + security + additional + night + wipes + fine;
        const net = service_price - discounts;
        const owner = net * 0.4;
        const worker = net * 0.6;
        const pending = service_price - advance;

        document.getElementById('preview_discounts').innerText = format(discounts);
        document.getElementById('preview_net').innerText = format(net);
        document.getElementById('preview_owner').innerText = format(owner);
        document.getElementById('preview_worker').innerText = format(worker);
        document.getElementById('preview_pending').innerText = format(pending);
    };

    // 🔁 Escuchar todos los inputs
    const inputs = [
        'service_price',
        'room_cost',
        'security_cost',
        'additional_cost',
        'night_cost',
        'wipes_cost',
        'fine_amount',
        'advance_payment'
    ];

    inputs.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', calculate);
        }
    });

    // 💰 Autocompletar precio por servicio
    const serviceSelect = document.getElementById('service_id');
    const servicePriceInput = document.getElementById('service_price');

    if (serviceSelect && servicePriceInput) {
        serviceSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const price = selectedOption.getAttribute('data-price');

            if (price !== null && price !== '') {
                servicePriceInput.value = price;
                calculate();
            }
        });
    }

    // Ejecutar al cargar
    calculate();
});
</script>