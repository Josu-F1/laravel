<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientes = [
            [
                'name' => 'Juan Pérez',
                'email' => 'juan.perez@email.com',
                'phone' => '555-0101',
                'address' => 'Calle Principal 123, Ciudad'
            ],
            [
                'name' => 'María García',
                'email' => 'maria.garcia@email.com',
                'phone' => '555-0102',
                'address' => 'Avenida Central 456, Ciudad'
            ],
            [
                'name' => 'Carlos López',
                'email' => 'carlos.lopez@email.com',
                'phone' => '555-0103',
                'address' => 'Calle Secundaria 789, Ciudad'
            ],
            [
                'name' => 'Ana Martínez',
                'email' => 'ana.martinez@email.com',
                'phone' => '555-0104',
                'address' => 'Plaza Mayor 321, Ciudad'
            ],
            [
                'name' => 'Luis Rodríguez',
                'email' => 'luis.rodriguez@email.com',
                'phone' => '555-0105',
                'address' => 'Barrio Norte 654, Ciudad'
            ]
        ];

        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        }
    }
}
