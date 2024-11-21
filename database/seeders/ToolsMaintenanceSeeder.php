<?php

namespace Database\Seeders;

use App\Models\ToolsMaintenance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToolsMaintenanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ToolsMaintenance::insert([
            [
                'tools_id' => 4,
                'maintenance_date' => now(),
                'status' => 'In Progress',
                'description' => 'Process repair',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
