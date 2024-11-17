<?php

namespace Database\Seeders;

use App\Models\VehicleAssignment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssignmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VehicleAssignment::insert([
            [
                'id' => 1, // Assuming vehicle with ID 1 exists
                'assigned_to' => 'Department A',
                'assignment_date' => '2023-01-01',
                'return_date' => '2023-01-10',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2, // Assuming vehicle with ID 2 exists
                'assigned_to' => 'Department B',
                'assignment_date' => '2023-02-01',
                'return_date' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
