<?php

namespace Database\Seeders;

use App\Models\ToolsStock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToolsStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ToolsStock::insert([
            [
                'tools_id' => 1,
                'quantity' => 10,
                'unit' => 'SET',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'tools_id' => 2,
                'quantity' => 10,
                'unit' => 'SET',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'tools_id' => 3,
                'quantity' => 10,
                'unit' => 'PCS',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'tools_id' => 4,
                'quantity' => 10,
                'unit' => 'PCS',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'tools_id' => 5,
                'quantity' => 10,
                'unit' => 'ROLL',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
