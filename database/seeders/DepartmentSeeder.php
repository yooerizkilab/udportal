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
            [
                'code' => 'D005',
                'company_id' => 1,
                'name' => 'HR',
                'description' => 'Description for Department HR',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'D006',
                'company_id' => 1,
                'name' => 'Sales',
                'description' => 'Description for Department Sales',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'D007',
                'company_id' => 1,
                'name' => 'Marketing',
                'description' => 'Description for Department Marketing',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'D008',
                'company_id' => 1,
                'name' => 'Finance',
                'description' => 'Description for Department Finance',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'D009',
                'company_id' => 1,
                'name' => 'Production',
                'description' => 'Description for Department Production',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'D010',
                'company_id' => 1,
                'name' => 'Purchasing',
                'description' => 'Description for Department Purchasing',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'D011',
                'company_id' => 1,
                'name' => 'Retail',
                'description' => 'Description for Department Retail',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'D012',
                'company_id' => 1,
                'name' => 'Logistics',
                'description' => 'Description for Department Logistics',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'D013',
                'company_id' => 1,
                'name' => 'Project',
                'description' => 'Description for Department Project',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'D014',
                'company_id' => 1,
                'name' => 'Warehouse',
                'description' => 'Description for Department Warehouse',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'D015',
                'company_id' => 1,
                'name' => 'Accounting',
                'description' => 'Description for Department Accounting',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
