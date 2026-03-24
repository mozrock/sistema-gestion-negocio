<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Videollamada', 'category' => 'virtual', 'base_price' => 80000],
            ['name' => 'Pack', 'category' => 'virtual', 'base_price' => 150000],
            ['name' => 'Media hora', 'category' => 'presencial', 'base_price' => 130000],
            ['name' => '40 minutos', 'category' => 'presencial', 'base_price' => 150000],
            ['name' => 'Rato', 'category' => 'presencial', 'base_price' => 110000],
            ['name' => '1 hora', 'category' => 'presencial', 'base_price' => 170000],
            ['name' => 'Domicilio 1 hora', 'category' => 'presencial', 'base_price' => 250000],
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(
                ['name' => $service['name']],
                [
                    'category' => $service['category'],
                    'base_price' => $service['base_price'],
                    'is_active' => true,
                ]
            );
        }
    }
}