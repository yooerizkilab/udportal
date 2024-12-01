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
                'quantity' => 10,
                'unit' => 'Pcs',
                'origin' => 'Office A',
                'condition' => 'New',
                'status' => 'Active',
                'description' => 'Description 1',
                'purchase_date' => '2022-01-01',
                'purchase_price' => 100.00,
                'warranty' => 'Warranty 1',
                'warranty_start' => '2023-01-01',
                'warranty_end' => '2024-01-01',
                'photo' => 'photo1.jpg',
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
                'quantity' => 5,
                'unit' => 'Set',
                'origin' => 'Office B',
                'condition' => 'Used',
                'status' => 'Active',
                'description' => 'Description 2',
                'purchase_date' => '2023-01-01',
                'purchase_price' => 200.00,
                'warranty' => 'Warranty 2',
                'warranty_start' => '2024-01-01',
                'warranty_end' => '2025-01-01',
                'photo' => 'photo2.jpg',
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
                'quantity' => 8,
                'unit' => 'Unit',
                'origin' => 'Office C',
                'condition' => 'Used',
                'status' => 'Active',
                'description' => 'Description 3',
                'purchase_date' => '2021-01-01',
                'purchase_price' => 300.00,
                'warranty' => 'Warranty 3',
                'warranty_start' => '2022-01-01',
                'warranty_end' => '2023-01-01',
                'photo' => 'photo3.jpg',
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
                'quantity' => 6,
                'unit' => 'Rol',
                'origin' => 'Office D',
                'condition' => 'Broken',
                'status' => 'Maintenance',
                'description' => 'Description 4',
                'purchase_date' => '2020-01-01',
                'purchase_price' => 400.00,
                'warranty' => 'Warranty 4',
                'warranty_start' => '2021-01-01',
                'warranty_end' => '2022-01-01',
                'photo' => 'photo4.jpg',
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
                'quantity' => 4,
                'unit' => 'Pcs',
                'origin' => 'Office E',
                'condition' => 'Broken',
                'status' => 'Inactive',
                'description' => 'Description 5',
                'purchase_date' => '2019-01-01',
                'purchase_price' => 500.00,
                'warranty' => 'Warranty 5',
                'warranty_start' => '2020-01-01',
                'warranty_end' => '2021-01-01',
                'photo' => 'photo5.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
