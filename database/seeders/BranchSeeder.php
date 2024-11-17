<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Branch::insert([
            [
                'code_branch' => 'B001',
                'name_branch' => 'Branch 1',
                'address' => 'Address 1',
                'phone' => '1234567890',
                'status' => 'Active',
                'description' => 'Description 1',
                'photo' => 'photo1.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code_branch' => 'B002',
                'name_branch' => 'Branch 2',
                'address' => 'Address 2',
                'phone' => '9876543210',
                'status' => 'Inactive',
                'description' => 'Description 2',
                'photo' => 'photo2.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code_branch' => 'B003',
                'name_branch' => 'Branch 3',
                'address' => 'Address 3',
                'phone' => '5555555555',
                'status' => 'Active',
                'description' => 'Description 3',
                'photo' => 'photo3.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code_branch' => 'B004',
                'name_branch' => 'Branch 4',
                'address' => 'Address 4',
                'phone' => '9999999999',
                'status' => 'Inactive',
                'description' => 'Description 4',
                'photo' => 'photo4.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code_branch' => 'B005',
                'name_branch' => 'Branch 5',
                'address' => 'Address 5',
                'phone' => '7777777777',
                'status' => 'Active',
                'description' => 'Description 5',
                'photo' => 'photo5.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
