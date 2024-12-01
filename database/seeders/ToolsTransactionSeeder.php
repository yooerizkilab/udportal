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
                'tools_id' => 2,
                'user_id' => 1,
                'code' => '2024/VII/ABC321',
                'type' => 'Out',
                'from' => 'Office XYZ',
                'to' => 'Branch ABC',
                'quantity' => '5',
                'location' => 'Stret 1',
                'activity' => 'Project XYZ',
                'transaction_date' => now(),
                'notes' => 'Note 1',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'tools_id' => 3,
                'user_id' => 1,
                'code' => '2024/VII/ABC213',
                'type' => 'Transfer',
                'from' => 'Office XYZ',
                'to' => 'Branch ABC',
                'quantity' => '5',
                'location' => 'Stret 1',
                'activity' => 'Project XYZ',
                'transaction_date' => now(),
                'notes' => 'Note 1',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
