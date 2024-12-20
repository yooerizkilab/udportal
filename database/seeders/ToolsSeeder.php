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

        Projects::insert([
            [
                'code' => 'PRJ001',
                'name' => 'Project Alpha',
                'address' => '123 Main Street',
                'phone' => '1234567890',
                'email' => 'alpha@project.com',
                'ppic' => 'John Doe',
                'description' => 'This is the first project.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'PRJ002',
                'name' => 'Project Beta',
                'address' => '456 Another St',
                'phone' => '0987654321',
                'email' => 'beta@project.com',
                'ppic' => 'Jane Smith',
                'description' => 'This is the second project.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        ToolsOwners::insert([
            [
                'name' => 'Owner Alpha',
                'address' => '789 Tool Lane',
                'phone' => '1122334455',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Owner Beta',
                'address' => '321 Wrench Way',
                'phone' => '5566778899',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        ToolsCategorie::insert([
            [
                'code' => 'TC001',
                'name' => 'Electrical',
                'description' => 'Tools for electrical works.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'TC002',
                'name' => 'Mechanical',
                'description' => 'Tools for mechanical works.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        Tools::insert([
            [
                'owner_id' => 1,
                'category_id' => 1,
                'code' => 'TOOL001',
                'serial_number' => 'SN12345',
                'name' => 'Drill Machine',
                'brand' => 'Bosch',
                'type' => 'Electrical',
                'year' => 2020,
                'quantity' => 5,
                'condition' => 'New',
                'status' => 'Active',
                'purchase_price' => 150.75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'owner_id' => 2,
                'category_id' => 2,
                'code' => 'TOOL002',
                'serial_number' => 'SN67890',
                'name' => 'Wrench Set',
                'brand' => 'Stanley',
                'type' => 'Mechanical',
                'year' => 2019,
                'quantity' => 10,
                'condition' => 'Used',
                'status' => 'Active',
                'purchase_price' => 80.50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        ToolsMaintenance::insert([
            [
                'tool_id' => 1,
                'code' => 'MAINT001',
                'maintenance_date' => now(),
                'cost' => 50.00,
                'status' => 'Completed',
                'description' => 'Routine maintenance.',
                'completion_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        ToolsTransaction::insert([
            [
                'user_id' => 1,
                'tool_id' => 1,
                'source_project_id' => 1,
                'destination_project_id' => 2,
                'document_code' => 'TRX001',
                'document_date' => now(),
                'delivery_date' => now(),
                'quantity' => 1,
                'type' => 'Delivery Note',
                'driver' => 'Driver A',
                'driver_phone' => '1231231234',
                'plate_number' => 'B1234ABC',
                'notes' => 'Delivering drill machine.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
