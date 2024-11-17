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
                'department_id' => 1,
                'employe_code' => 'A001',
                'nik' => '1234567890',
                'full_name' => 'John Doe',
                'gender' => 'Male',
                'phone' => '1234567890',
                'address' => '123 Main St',
                'position' => 'Manager',
                'age' => '30',
                'status' => 'Active',
                'photo' => 'photo1.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'department_id' => 2,
                'employe_code' => 'A002',
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
            [
                'department_id' => 3,
                'employe_code' => 'A003',
                'nik' => '5555555555',
                'full_name' => 'Bob Johnson',
                'gender' => 'Male',
                'phone' => '5555555555',
                'address' => '789 Oak St',
                'position' => 'Designer',
                'age' => '35',
                'status' => 'Active',
                'photo' => 'photo3.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'department_id' => 4,
                'employe_code' => 'A004',
                'nik' => '1111111111',
                'full_name' => 'Alice Brown',
                'gender' => 'Female',
                'phone' => '1111111111',
                'address' => '123 Maple St',
                'position' => 'Analyst',
                'age' => '28',
                'status' => 'Active',
                'photo' => 'photo4.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'department_id' => 5,
                'employe_code' => 'A005',
                'nik' => '2222222222',
                'full_name' => 'Tom Green',
                'gender' => 'Male',
                'phone' => '2222222222',
                'address' => '456 Oak St',
                'position' => 'Tester',
                'age' => '32',
                'status' => 'Active',
                'photo' => 'photo5.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
