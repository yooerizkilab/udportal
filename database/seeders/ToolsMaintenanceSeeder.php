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
                'code' => 'TLSM/XII/2021/AMT001',
                'maintenance_date' => now(),
                'cost' => 30000,
                'completion_date' => now(),
                'status' => 'In Progress',
                'description' => 'Process repair',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
