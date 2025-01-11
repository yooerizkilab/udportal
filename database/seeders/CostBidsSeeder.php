<?php

namespace Database\Seeders;

use App\Models\CostBids;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CostBidsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CostBids::insert([
            'code' => '153/XI/2025',
            'document_date' => '2025-11-15',
            'for_company' => 'PT. WIKA CIBUBUR',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
