<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productos = [
            [
                'name' => 'Laptop HP Pavilion',
                'description' => 'Laptop HP Pavilion 15" con Intel Core i5, 8GB RAM, 256GB SSD',
                'price' => 899.99,
                'stock' => 25
            ],
            [
                'name' => 'Mouse Inalámbrico Logitech',
                'description' => 'Mouse inalámbrico Logitech MX Master 3 con sensor de alta precisión',
                'price' => 79.99,
                'stock' => 50
            ],
            [
                'name' => 'Teclado Mecánico Corsair',
                'description' => 'Teclado mecánico Corsair K95 RGB con switches Cherry MX',
                'price' => 159.99,
                'stock' => 30
            ],
            [
                'name' => 'Monitor Samsung 24"',
                'description' => 'Monitor Samsung 24" Full HD con tecnología VA y 75Hz',
                'price' => 189.99,
                'stock' => 20
            ],
            [
                'name' => 'Auriculares Sony WH-1000XM4',
                'description' => 'Auriculares inalámbricos Sony con cancelación de ruido',
                'price' => 299.99,
                'stock' => 15
            ],
            [
                'name' => 'Webcam Logitech C920',
                'description' => 'Webcam Logitech C920 Full HD 1080p para streaming',
                'price' => 69.99,
                'stock' => 40
            ],
            [
                'name' => 'Smartphone Samsung Galaxy S23',
                'description' => 'Samsung Galaxy S23 128GB con pantalla Dynamic AMOLED',
                'price' => 799.99,
                'stock' => 18
            ],
            [
                'name' => 'Tablet iPad Air',
                'description' => 'iPad Air 64GB con pantalla Liquid Retina de 10.9"',
                'price' => 599.99,
                'stock' => 12
            ]
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }
    }
}
