<?php

namespace Database\Seeders;

use App\Models\ToolsShipments;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToolsShipmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ToolsShipments::insert([
            [
                'transactions_id' => 1,
                'tool_id' => 1,
                'quantity' => 1,
                'unit' => 'UNIT',
                'last_location' => 'Kompl Tmn Permata Indah II Bl N/37, Dki Jakarta',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
