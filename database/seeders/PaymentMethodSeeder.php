<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            'Efectivo',
            'Nequi',
            'Transferencia',
            'Tarjeta',
            'Dólares',
        ];

        foreach ($methods as $method) {
            PaymentMethod::firstOrCreate(
                ['name' => $method],
                ['is_active' => true]
            );
        }
    }
}