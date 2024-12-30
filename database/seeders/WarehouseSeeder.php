<?php

namespace Database\Seeders;

use App\Models\Warehouses;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Warehouses::insert([
            [
                'company_id' => 1,
                'branch_id' => 1,
                'code' => 'WRHS0001',
                'name' => 'Warehouse 1',
                'phone' => '1234567890',
                'email' => 'warehouse1@example.com',
                'address' => 'Jl Srengseng Sawah 87, Dki Jakarta',
                'description' => 'Warehouse 1 description',
                'status' => 'Active',
                'type' => 'Warehouse',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'company_id' => 1,
                'branch_id' => 1,
                'code' => 'WHRM0001',
                'name' => 'Warehouse 2 Raw Material',
                'phone' => '1234567890',
                'email' => 'warehouse2@example.com',
                'address' => 'Jl Kb Kacang IX 57, Dki Jakarta',
                'description' => 'Warehouse 2 for raw material',
                'status' => 'Active',
                'type' => 'Raw Material',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'company_id' => 1,
                'branch_id' => 1,
                'code' => 'WHFG0001',
                'name' => 'Warehouse 3 Finish Good',
                'phone' => '1234567890',
                'email' => 'warehouse3@example.com',
                'address' => 'Jl Kemang Utr IX 9, Dki Jakarta',
                'description' => 'Warehouse 3 for finish good',
                'status' => 'Active',
                'type' => 'Finished Goods',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
