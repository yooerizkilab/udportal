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
                'code' => 'A',
                'name' => 'Tools',
                'description' => 'Tools',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'B',
                'name' => 'Accessories',
                'description' => 'Accessories',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'C',
                'name' => 'Parts',
                'description' => 'Parts',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'D',
                'name' => 'Other',
                'description' => 'Other',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
