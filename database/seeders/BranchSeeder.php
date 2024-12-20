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
                'company_id' => 1,
                'code' => 'B001',
                'name' => 'Branch 1',
                'type' => 'Head Office',
                'address' => 'Address 1',
                'phone' => '1234567890',
                'status' => 'Active',
                'description' => 'Description 1',
                'photo' => 'photo1.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'company_id' => 1,
                'code' => 'B002',
                'name' => 'Branch 2',
                'type' => 'Head Office',
                'address' => 'Address 2',
                'phone' => '9876543210',
                'status' => 'Inactive',
                'description' => 'Description 2',
                'photo' => 'photo2.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'company_id' => 1,
                'code' => 'B003',
                'name' => 'Branch 3',
                'type' => 'Head Office',
                'address' => 'Address 3',
                'phone' => '5555555555',
                'status' => 'Active',
                'description' => 'Description 3',
                'photo' => 'photo3.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'company_id' => 1,
                'code' => 'B004',
                'name' => 'Branch 4',
                'type' => 'Branch Office',
                'address' => 'Address 4',
                'phone' => '9999999999',
                'status' => 'Inactive',
                'description' => 'Description 4',
                'photo' => 'photo4.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'company_id' => 1,
                'code' => 'B005',
                'name' => 'Branch 5',
                'type' => 'Branch Office',
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
