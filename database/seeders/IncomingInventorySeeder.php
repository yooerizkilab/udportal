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
                'item_name' => 'Self Drilling Screws',
                'quantity' => '3 Pallets',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'item_name' => 'Self Drilling Screws',
                'quantity' => '3 Pallets',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'item_name' => 'Bailing Waste Press Machine',
                'quantity' => 'Cont 1x40',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'item_name' => 'Mono Solar Module LR5-72HGD-580M',
                'quantity' => 'Cont 4x40',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'item_name' => 'Charging Terminal',
                'quantity' => '2 Pakages',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
