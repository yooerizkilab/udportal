<?php

namespace Database\Seeders;

use App\Models\ToolsTransaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToolsTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ToolsTransaction::insert([
            [
                'user_id' => 1,
                'source_project_id' => 1,
                'destination_project_id' => 2,
                'document_code' => 'DN/2024/XII/25/00001',
                'document_date' => '2025-01-30',
                'delivery_date' => '2025-01-30',
                'ppic' => 'Jane Doe',
                'driver' => 'John Doe',
                'driver_phone' => '08123456789',
                'transportation' => 'Car',
                'plate_number' => 'ABC123',
                'status' => 'In Progress',
                'type' => 'Delivery Note',
                'notes' => 'This is a delivery note.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
