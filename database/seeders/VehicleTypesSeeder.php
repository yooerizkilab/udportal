<?php

namespace Database\Seeders;

use App\Models\VehicleType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VehicleType::insert([
            ['type_name' => 'Car', 'description' => 'Passenger cars', 'created_at' => now(), 'updated_at' => now()],
            ['type_name' => 'Truck', 'description' => 'Heavy-duty trucks', 'created_at' => now(), 'updated_at' => now()],
            ['type_name' => 'Motorbike', 'description' => 'Two-wheeled motor vehicles', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
