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
                'branch_id' => 1,
                'department_id' => 1,
                'code' => 'EMP001',
                'nik' => '1234567890',
                'full_name' => 'Super Admin',
                'gender' => 'Male',
                'age' => '30',
                'phone' => '6211234567890',
                'position' => 'Super Admin',
                'address' => 'Jl. Contoh, No. 123, Contoh, Kec. Contoh, Kota Contoh, Prov. Contoh',
                'status' => 'Active',
                'photo' => 'photo1.jpg',
            ],
            [
                'user_id' => 2,
                'company_id' => 1,
                'branch_id' => 1,
                'department_id' => 3,
                'code' => 'EMP002',
                'nik' => '9876543210',
                'full_name' => 'Admin Legal',
                'gender' => 'Male',
                'age' => '25',
                'phone' => '6289876543210',
                'position' => 'Admin',
                'address' => 'Jl. Contoh, No. 456, Contoh, Kec. Contoh, Kota Contoh, Prov. Contoh',
                'status' => 'Active',
                'photo' => 'photo2.jpg',
            ],
            [
                'user_id' => 3,
                'company_id' => 1,
                'branch_id' => 1,
                'department_id' => 4,
                'code' => 'EMP003',
                'nik' => '3562343423443',
                'full_name' => 'Admin General Afairs',
                'gender' => 'Female',
                'age' => '28',
                'phone' => '628756543210',
                'position' => 'Admin',
                'address' => 'Jl. Contoh, No. 789, Contoh, Kec. Contoh, Kota Contoh, Prov. Contoh',
                'status' => 'Active',
                'photo' => 'photo3.jpg',
            ],
            [
                'user_id' => 4,
                'company_id' => 1,
                'branch_id' => 1,
                'department_id' => 2,
                'code' => 'EMP004',
                'nik' => '3562343423443',
                'full_name' => 'Admin Branch 1',
                'gender' => 'Female',
                'age' => '28',
                'phone' => '628756543210',
                'position' => 'Admin',
                'address' => 'Jl. Contoh, No. 789, Contoh, Kec. Contoh, Kota Contoh, Prov. Contoh',
                'status' => 'Active',
                'photo' => 'photo4.jpg',
            ],
            [
                'user_id' => 5,
                'company_id' => 1,
                'branch_id' => 2,
                'department_id' => 1,
                'code' => 'EMP005',
                'nik' => '3562343423443',
                'full_name' => 'Admin Branch 2',
                'gender' => 'Female',
                'age' => '28',
                'phone' => '628756543210',
                'position' => 'Admin',
                'address' => 'Jl. Contoh, No. 789, Contoh, Kec. Contoh, Kota Contoh, Prov. Contoh',
                'status' => 'Active',
                'photo' => 'photo5.jpg',
            ],
        ]);
    }
}
