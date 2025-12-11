<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@itech.com',
            'password' => Hash::make('password'),
        ]);

        // Create Warehouse Admin
        User::create([
            'name' => 'Warehouse Admin',
            'email' => 'warehouse@itech.com',
            'password' => Hash::make('password'),
        ]);

        // Create Customer Service
        User::create([
            'name' => 'Customer Service',
            'email' => 'cs@itech.com',
            'password' => Hash::make('password'),
        ]);

        // Call Product Seeder
        $this->call(ProductSeeder::class);
    }
}
