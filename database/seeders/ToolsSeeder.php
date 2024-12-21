<?php

namespace Database\Seeders;

use App\Models\Projects;
use App\Models\Tools;
use App\Models\ToolsCategorie;
use App\Models\ToolsMaintenance;
use App\Models\ToolsOwners;
use App\Models\ToolsTransaction;
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
                'category_id' => 1,
                'code' => 'SEAM0001',
                'serial_number' => 'ALTRA 300 NO 6',
                'name' => 'ALTRA 300',
                'brand' => 'ALTRA',
                'type' => 'ELEKTRIK',
                'model' => '300',
                'year' => null,
                'origin' => 'Lawang',
                'quantity' => 1,
                'unit' => 'UNIT',
                'condition' => 'New',
                'status' => 'Active',
                'description' => null,
                'purchase_date' => null,
                'purchase_price' => null,
                'warranty' => null,
                'warranty_start' => null,
                'warranty_end' => null,
                'photo' => null,
            ],
            [
                'owner_id' => 1,
                'category_id' => 1,
                'code' => 'SEAM0002',
                'serial_number' => 'ALTRA 1(2)',
                'name' => 'ALTRA I',
                'brand' => 'ALTRA',
                'type' => 'ELEKTRIK',
                'model' => null,
                'year' => null,
                'origin' => 'Lawang',
                'quantity' => 1,
                'unit' => 'UNIT',
                'condition' => 'New',
                'status' => 'Active',
                'description' => null,
                'purchase_date' => null,
                'purchase_price' => null,
                'warranty' => null,
                'warranty_start' => null,
                'warranty_end' => null,
                'photo' => null,
            ],
            [
                'owner_id' => 1,
                'category_id' => 1,
                'code' => 'SEAM0003',
                'serial_number' => 'ALTRA I-A',
                'name' => 'ALTRA I',
                'brand' => 'ALTRA',
                'type' => 'ELEKTRIK',
                'model' => null,
                'year' => null,
                'origin' => 'Lawang',
                'quantity' => 1,
                'unit' => 'UNIT',
                'condition' => 'New',
                'status' => 'Active',
                'description' => null,
                'purchase_date' => null,
                'purchase_price' => null,
                'warranty' => null,
                'warranty_start' => null,
                'warranty_end' => null,
                'photo' => null,
            ],
            [
                'owner_id' => 1,
                'category_id' => 1,
                'code' => 'SEAM0004',
                'serial_number' => 'ALTRA I-5',
                'name' => 'ALTRA I',
                'brand' => 'ALTRA',
                'type' => 'ELEKTRIK',
                'model' => null,
                'year' => null,
                'origin' => 'Lawang',
                'quantity' => 1,
                'unit' => 'UNIT',
                'condition' => 'New',
                'status' => 'Active',
                'description' => null,
                'purchase_date' => null,
                'purchase_price' => null,
                'warranty' => null,
                'warranty_start' => null,
                'warranty_end' => null,
                'photo' => null,
            ],
            [
                'owner_id' => 1,
                'category_id' => 1,
                'code' => 'SEAM0005',
                'serial_number' => 'ALTRA I-B',
                'name' => 'ALTRA I',
                'brand' => 'ALTRA',
                'type' => 'ELEKTRIK',
                'model' => null,
                'year' => null,
                'origin' => 'Lawang',
                'quantity' => 1,
                'unit' => 'UNIT',
                'condition' => 'New',
                'status' => 'Active',
                'description' => null,
                'purchase_date' => null,
                'purchase_price' => null,
                'warranty' => null,
                'warranty_start' => null,
                'warranty_end' => null,
                'photo' => null,
            ],
        ]);
    }
}
