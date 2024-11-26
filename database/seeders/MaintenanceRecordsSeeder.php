<?php

namespace Database\Seeders;

use App\Models\VehicleMaintenance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaintenanceRecordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VehicleMaintenance::insert([
            [
                'vehicle_id' => 2, // Assuming vehicle with ID 1 exists
                'maintenance_date' => '2022-02-15',
                'description' => 'Oil Change',
                'cost' => 500000,
                'next_maintenance' => '2023-02-15',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'vehicle_id' => 5, // Assuming vehicle with ID 2 exists
                'maintenance_date' => '2022-08-10',
                'description' => 'Brake Replacement',
                'cost' => 1000000,
                'next_maintenance' => '2023-08-10',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
