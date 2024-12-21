<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::insert([
            [
                'code' => 'D001',
                'company_id' => 1,
                'name' => 'Head Office',
                'description' => 'Description for Head Office',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'D002',
                'company_id' => 1,
                'name' => 'IT',
                'description' => 'Description for Department IT',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'D003',
                'company_id' => 1,
                'name' => 'Legal',
                'description' => 'Description for Department Legal',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'D004',
                'company_id' => 1,
                'name' => 'GA',
                'description' => 'Description for Department GA',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
