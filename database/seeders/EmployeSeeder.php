<?php

namespace Database\Seeders;

use App\Models\Employe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employe::insert([
            [
                'user_id' => 1,
                'company_id' => 1,
                'department_id' => 1,
                'code' => 'A001',
                'nik' => '1234567890',
                'full_name' => 'John Doe',
                'gender' => 'Male',
                'phone' => '1234567890',
                'address' => '123 Main St',
                'position' => 'Super Admin',
                'age' => '30',
                'status' => 'Active',
                'photo' => 'photo1.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 2,
                'company_id' => 1, // Assuming company with ID 1 exists
                'department_id' => 2,
                'code' => 'A002',
                'nik' => '9876543210',
                'full_name' => 'Jane Smith',
                'gender' => 'Female',
                'phone' => '9876543210',
                'address' => '456 Elm St',
                'position' => 'Developer',
                'age' => '25',
                'status' => 'Active',
                'photo' => 'photo2.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
