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
                'code' => 'SEAMING',
                'name' => 'Tools Seaming',
                'description' => 'Tools for use in seamings',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'SAFETY',
                'name' => 'Tools Safety',
                'description' => 'Tools for use in safety',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'DRILLING',
                'name' => 'Tools Drilling',
                'description' => 'Tools for use in drilling',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'CONVEYER',
                'name' => 'Tools Conveyor',
                'description' => 'Tools for use in conveyors',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'CABLE',
                'name' => 'Tools Cable',
                'description' => 'Tools for use in cables',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
