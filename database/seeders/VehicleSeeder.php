<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vehicle::insert([
            [
                'vehicle_code' => 'V123',
                'brand' => 'Toyota',
                'model' => 'Avanza',
                'year' => 2020,
                'license_plate' => 'B1234XYZ',
                'status' => 'Active',
                'type_id' => 1, // Assuming 1 is 'Car' type
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'vehicle_code' => 'V124',
                'brand' => 'Honda',
                'model' => 'Civic',
                'year' => 2019,
                'license_plate' => 'B5678ABC',
                'status' => 'Maintenance',
                'type_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'vehicle_code' => 'V125',
                'brand' => 'Isuzu',
                'model' => 'Elf',
                'year' => 2018,
                'license_plate' => 'B91011DEF',
                'status' => 'Inactive',
                'type_id' => 2, // Assuming 2 is 'Truck' type
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
