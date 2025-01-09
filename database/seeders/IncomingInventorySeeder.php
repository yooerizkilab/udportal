<?php

namespace Database\Seeders;

use App\Models\IncomingInventory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncomingInventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IncomingInventory::insert([
            [
                'shipment_id' => '1',
                'item_name' => 'Self Drilling Screws',
                'quantity' => '3 Pallets',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'shipment_id' => '1',
                'item_name' => 'Self Drilling Screws',
                'quantity' => '3 Pallets',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'shipment_id' => '2',
                'item_name' => 'Bailing Waste Press Machine',
                'quantity' => 'Cont 1x40',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'shipment_id' => '3',
                'item_name' => 'Mono Solar Module LR5-72HGD-580M',
                'quantity' => 'Cont 4x40',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'shipment_id' => '4',
                'item_name' => 'Charging Terminal',
                'quantity' => '2 Pakages',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
