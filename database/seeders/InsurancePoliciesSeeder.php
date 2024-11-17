<?php

namespace Database\Seeders;

use App\Models\VehicleInsurance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InsurancePoliciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VehicleInsurance::insert([
            [
                'id' => 1, // Assuming vehicle with ID 1 exists
                'insurance_provider' => 'ABC Insurance',
                'policy_number' => 'INS123456',
                'coverage_start' => '2020-01-01',
                'coverage_end' => '2023-01-01',
                'premium' => 1500000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2, // Assuming vehicle with ID 2 exists
                'insurance_provider' => 'XYZ Insurance',
                'policy_number' => 'INS654321',
                'coverage_start' => '2019-05-20',
                'coverage_end' => '2022-05-20',
                'premium' => 2000000,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
