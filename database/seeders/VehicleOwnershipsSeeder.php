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
                'owner_id' => 1, // Assuming vehicle with ID 1 exists
                'owner' => 'Company A',
                'purchase_date' => '2020-01-10',
                'purchase_price' => 300000000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'owner_id' => 2, // Assuming vehicle with ID 2 exists
                'owner' => 'Company B',
                'purchase_date' => '2019-05-20',
                'purchase_price' => 350000000,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
