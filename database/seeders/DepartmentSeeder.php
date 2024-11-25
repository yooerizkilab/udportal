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
                'code' => '001',
                'name' => 'Department A',
                'description' => 'Description for Department A',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => '002',
                'name' => 'Department B',
                'description' => 'Description for Department B',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => '003',
                'name' => 'Department C',
                'description' => 'Description for Department C',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => '004',
                'name' => 'Department D',
                'description' => 'Description for Department D',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code_department' => '005',
                'name_department' => 'Department E',
                'description' => 'Description for Department E',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
