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
            [
                'code' => 'CAR00001',
                'name' => 'Car',
                'description' => 'Passenger cars',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'TRUCK00001',
                'name' => 'Truck',
                'description' => 'Heavy-duty trucks',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'PICKUP00001',
                'name' => 'Pickup',
                'description' => 'Public transportation vehicles',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'MOTORBIKE00001',
                'name' => 'Motorbike',
                'description' => 'Two-wheeled motor vehicles',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
