<?php

namespace Database\Seeders;

use App\Models\ToolsOwners;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class ToolsOwnersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ToolsOwners::insert([
            [
                'name' => 'Company A',
                'address' => 'Address A',
                'phone' => '1234567890',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Company B',
                'address' => 'Address B',
                'phone' => '9876543210',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Mr ABC',
                'address' => 'Address C',
                'phone' => '5555555555',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Ms XYZ',
                'address' => 'Address D',
                'phone' => '9999999999',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
