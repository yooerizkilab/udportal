<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CostBidsInventory;

class CostBidsInventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CostBidsInventory::insert([
            [
                'name' => 'Elbow 250 x 100',
                'quantity' => '6',
                'uom' => 'PCS',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'IR 250 x 100',
                'quantity' => '6',
                'uom' => 'PCS',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'OR 250 x 100',
                'quantity' => '6',
                'uom' => 'PCS',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Equal 250',
                'quantity' => '1',
                'uom' => 'PCS',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Jombing type c 100',
                'quantity' => '180',
                'uom' => 'PCS',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Cover Elbow 250 x 100',
                'quantity' => '6',
                'uom' => 'PCS',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Cover IR 250 x 100',
                'quantity' => '6',
                'uom' => 'PCS',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
