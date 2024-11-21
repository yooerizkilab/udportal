<?php

namespace Database\Seeders;

use App\Models\Tools;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToolsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tools::insert([
            [
                'owner_id' => 1,
                'categorie_id' => 1,
                'code' => 'T001',
                'serial_number' => 'SN001',
                'name' => 'Tool 1',
                'brand' => 'Brand 1',
                'type' => 'Type 1',
                'model' => 'Model 1',
                'year' => '2022',
                'origin' => 'Office A',
                'condition' => 'New',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'owner_id' => 1,
                'categorie_id' => 2,
                'code' => 'T002',
                'serial_number' => 'SN002',
                'name' => 'Tool 2',
                'brand' => 'Brand 2',
                'type' => 'Type 2',
                'model' => 'Model 2',
                'year' => '2023',
                'origin' => 'Office B',
                'condition' => 'Good',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'owner_id' => 1,
                'categorie_id' => 3,
                'code' => 'T003',
                'serial_number' => 'SN003',
                'name' => 'Tool 3',
                'brand' => 'Brand 3',
                'type' => 'Type 3',
                'model' => 'Model 3',
                'year' => '2021',
                'origin' => 'Office C',
                'condition' => 'Used',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'owner_id' => 1,
                'categorie_id' => 1,
                'code' => 'T004',
                'serial_number' => 'SN004',
                'name' => 'Tool 4',
                'brand' => 'Brand 4',
                'type' => 'Type 4',
                'model' => 'Model 4',
                'year' => '2020',
                'origin' => 'Office D',
                'condition' => 'Broken',
                'status' => 'Maintenance',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'owner_id' => 1,
                'categorie_id' => 2,
                'code' => 'T005',
                'serial_number' => 'SN005',
                'name' => 'Tool 5',
                'brand' => 'Brand 5',
                'type' => 'Type 5',
                'model' => 'Model 5',
                'year' => '2019',
                'origin' => 'Office E',
                'condition' => 'Broken',
                'status' => 'Inactive',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
