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
            // Power Supply Products
            [
                'part_number' => 'PSU-500W-01',
                'name' => '500W Power Supply Unit',
                'type' => 'Power Supply',
                'warranty_period_months' => 24,
                'stock_quantity' => 50,
            ],
            [
                'part_number' => 'PSU-750W-01',
                'name' => '750W Power Supply Unit',
                'type' => 'Power Supply',
                'warranty_period_months' => 24,
                'stock_quantity' => 35,
            ],
            [
                'part_number' => 'PSU-1000W-01',
                'name' => '1000W Power Supply Unit',
                'type' => 'Power Supply',
                'warranty_period_months' => 36,
                'stock_quantity' => 20,
            ],

            // Motherboard Products
            [
                'part_number' => 'MB-H610-01',
                'name' => 'H610 Motherboard',
                'type' => 'Motherboard',
                'warranty_period_months' => 36,
                'stock_quantity' => 45,
            ],
            [
                'part_number' => 'MB-B660-01',
                'name' => 'B660 Motherboard',
                'type' => 'Motherboard',
                'warranty_period_months' => 36,
                'stock_quantity' => 30,
            ],
            [
                'part_number' => 'MB-Z790-01',
                'name' => 'Z790 Motherboard Premium',
                'type' => 'Motherboard',
                'warranty_period_months' => 36,
                'stock_quantity' => 25,
            ],

            // RAM Products
            [
                'part_number' => 'RAM-8GB-DDR4-01',
                'name' => '8GB DDR4 RAM',
                'type' => 'Memory',
                'warranty_period_months' => 24,
                'stock_quantity' => 100,
            ],
            [
                'part_number' => 'RAM-16GB-DDR4-01',
                'name' => '16GB DDR4 RAM',
                'type' => 'Memory',
                'warranty_period_months' => 24,
                'stock_quantity' => 75,
            ],
            [
                'part_number' => 'RAM-32GB-DDR5-01',
                'name' => '32GB DDR5 RAM',
                'type' => 'Memory',
                'warranty_period_months' => 36,
                'stock_quantity' => 40,
            ],

            // Storage Products
            [
                'part_number' => 'SSD-500GB-NVME-01',
                'name' => '500GB NVMe SSD',
                'type' => 'Storage',
                'warranty_period_months' => 24,
                'stock_quantity' => 60,
            ],
            [
                'part_number' => 'SSD-1TB-NVME-01',
                'name' => '1TB NVMe SSD',
                'type' => 'Storage',
                'warranty_period_months' => 24,
                'stock_quantity' => 80,
            ],
            [
                'part_number' => 'SSD-2TB-NVME-01',
                'name' => '2TB NVMe SSD',
                'type' => 'Storage',
                'warranty_period_months' => 36,
                'stock_quantity' => 50,
            ],
            [
                'part_number' => 'HDD-2TB-7200-01',
                'name' => '2TB HDD 7200RPM',
                'type' => 'Storage',
                'warranty_period_months' => 24,
                'stock_quantity' => 40,
            ],
            [
                'part_number' => 'HDD-4TB-7200-01',
                'name' => '4TB HDD 7200RPM',
                'type' => 'Storage',
                'warranty_period_months' => 24,
                'stock_quantity' => 35,
            ],

            // Cooling Products
            [
                'part_number' => 'COOLER-AIR-01',
                'name' => 'Air CPU Cooler',
                'type' => 'Cooling',
                'warranty_period_months' => 24,
                'stock_quantity' => 55,
            ],
            [
                'part_number' => 'COOLER-LIQUID-240-01',
                'name' => 'Liquid CPU Cooler 240mm',
                'type' => 'Cooling',
                'warranty_period_months' => 36,
                'stock_quantity' => 30,
            ],
            [
                'part_number' => 'COOLER-LIQUID-360-01',
                'name' => 'Liquid CPU Cooler 360mm',
                'type' => 'Cooling',
                'warranty_period_months' => 36,
                'stock_quantity' => 20,
            ],

            // Graphics Card Products
            [
                'part_number' => 'GPU-RTX3060-01',
                'name' => 'NVIDIA RTX 3060',
                'type' => 'Graphics Card',
                'warranty_period_months' => 36,
                'stock_quantity' => 15,
            ],
            [
                'part_number' => 'GPU-RTX4060-01',
                'name' => 'NVIDIA RTX 4060',
                'type' => 'Graphics Card',
                'warranty_period_months' => 36,
                'stock_quantity' => 18,
            ],
            [
                'part_number' => 'GPU-RTX4080-01',
                'name' => 'NVIDIA RTX 4080',
                'type' => 'Graphics Card',
                'warranty_period_months' => 36,
                'stock_quantity' => 10,
            ],

            // Case Products
            [
                'part_number' => 'CASE-MID-TOWER-01',
                'name' => 'Mid Tower PC Case',
                'type' => 'Case',
                'warranty_period_months' => 12,
                'stock_quantity' => 25,
            ],
            [
                'part_number' => 'CASE-FULL-TOWER-01',
                'name' => 'Full Tower PC Case',
                'type' => 'Case',
                'warranty_period_months' => 12,
                'stock_quantity' => 15,
            ],

            // Monitor Products
            [
                'part_number' => 'MON-27-1080P-01',
                'name' => '27" FHD Monitor 60Hz',
                'type' => 'Monitor',
                'warranty_period_months' => 36,
                'stock_quantity' => 20,
            ],
            [
                'part_number' => 'MON-27-1440P-01',
                'name' => '27" QHD Monitor 144Hz',
                'type' => 'Monitor',
                'warranty_period_months' => 36,
                'stock_quantity' => 18,
            ],
            [
                'part_number' => 'MON-32-4K-01',
                'name' => '32" 4K Monitor 60Hz',
                'type' => 'Monitor',
                'warranty_period_months' => 36,
                'stock_quantity' => 12,
            ],

            // Keyboard & Mouse Products
            [
                'part_number' => 'KBD-MECH-RGB-01',
                'name' => 'Mechanical Keyboard RGB',
                'type' => 'Peripherals',
                'warranty_period_months' => 24,
                'stock_quantity' => 40,
            ],
            [
                'part_number' => 'MOUSE-GAMING-01',
                'name' => 'Gaming Mouse 16000DPI',
                'type' => 'Peripherals',
                'warranty_period_months' => 24,
                'stock_quantity' => 50,
            ],
            [
                'part_number' => 'MOUSE-PAD-XL-01',
                'name' => 'XL Mouse Pad',
                'type' => 'Peripherals',
                'warranty_period_months' => 12,
                'stock_quantity' => 60,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}