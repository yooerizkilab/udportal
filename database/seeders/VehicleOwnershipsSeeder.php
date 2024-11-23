<?php

namespace Database\Seeders;

use App\Models\VehicleOwnership;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleOwnershipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VehicleOwnership::insert([
            [
                'name' => 'Company A',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Company B',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
