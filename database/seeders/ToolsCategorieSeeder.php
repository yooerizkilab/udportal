<?php

namespace Database\Seeders;

use App\Models\ToolsCategorie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToolsCategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        ToolsCategorie::insert([
            [
                'code' => 'TC0001',
                'name' => 'SEAMING',
                'description' => 'Tools for use in seamings',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'TC0002',
                'name' => 'SAFETY',
                'description' => 'Tools for use in safety',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'TC0003',
                'name' => 'DRILLING',
                'description' => 'Tools for use in drilling',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
