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
                'name' => 'Branch Head Office',
                'type' => 'Head Office',
                'address' => 'Jl Hayam Wuruk Glodok Harco Bl D/82,  Dki Jakarta',
                'phone' => '621234567890',
                'status' => 'Active',
                'description' => 'Description for Branch Head Office',
                'photo' => 'photo1.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'company_id' => 1,
                'code' => 'B002',
                'name' => 'Branch Distribution',
                'type' => 'Branch Office',
                'address' => 'Jl Jemur Andayani 50 Ruko Permata E/18-19, Jawa Timur',
                'phone' => '6211234567890',
                'status' => 'Active',
                'description' => 'Description for Branch Distribution',
                'photo' => 'photo2.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'company_id' => 1,
                'code' => 'B003',
                'name' => 'Branch Production',
                'type' => 'Branch Office',
                'address' => 'Kompl Tata Plaza Bl B/24, Sumatera Utara',
                'phone' => '6211234567890',
                'status' => 'Active',
                'description' => 'Description for Branch Production',
                'photo' => 'photo3.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
