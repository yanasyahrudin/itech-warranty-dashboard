<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Fuel System Parts
            [
                'part_number' => 'INJ-COMMONRAIL-01',
                'name' => 'Injector Common Rail Diesel',
                'type' => 'Fuel System',
                'warranty_period_months' => 12,
                'stock_quantity' => 25,
            ],

            // Engine Parts
            [
                'part_number' => 'PISTON-STD-01',
                'name' => 'Piston Set Standard Size',
                'type' => 'Engine',
                'warranty_period_months' => 6,
                'stock_quantity' => 30,
            ],


            // Turbocharger Parts
            [
                'part_number' => 'TURBO-CT16-01',
                'name' => 'Turbocharger CT16 Toyota',
                'type' => 'Turbo',
                'warranty_period_months' => 12,
                'stock_quantity' => 12,
            ],

            // Cooling System
            [
                'part_number' => 'RAD-ALUM-01',
                'name' => 'Aluminium Radiator Heavy Duty',
                'type' => 'Cooling',
                'warranty_period_months' => 12,
                'stock_quantity' => 18,
            ],

            // Suspension Parts
            [
                'part_number' => 'SHOCK-HEAVYDUTY-01',
                'name' => 'Shockbreaker Heavy Duty',
                'type' => 'Suspension',
                'warranty_period_months' => 12,
                'stock_quantity' => 20,
            ],

            // Brake System
            [
                'part_number' => 'DISC-BRAKE-01',
                'name' => 'Brake Disc Rotor',
                'type' => 'Brake System',
                'warranty_period_months' => 12,
                'stock_quantity' => 20,
            ],

            // Electrical Parts
            [
                'part_number' => 'ALT-120A-01',
                'name' => 'Alternator 120A Diesel',
                'type' => 'Electrical',
                'warranty_period_months' => 12,
                'stock_quantity' => 15,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
