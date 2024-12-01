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
                'address' => '123 Main St',
                'phone' => '555-555-5555',
                'email' => 'j7bPw@example.com',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Company B',
                'address' => '456 Elm St',
                'phone' => '555-555-5556',
                'email' => '5eTt4@example.com',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
