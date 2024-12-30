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
                'tool_id' => 5,
                'code' => 'UD/2024/XII/SEM00001/MTC00001',
                'maintenance_date' => now(),
                'cost' => 30000,
                'completion_date' => null,
                'status' => 'In Progress',
                'description' => 'Process repair',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
