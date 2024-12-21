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
                'address' => 'Jl Yudistira Pasekan Maguwoharjo Depok Sleman, Jawa Tengah',
                'phone' => '622741332813',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
