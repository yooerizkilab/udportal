<?php

namespace Database\Seeders;

use App\Models\CostBidsAnalysis;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CostBidsAnalysisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CostBidsAnalysis::insert([
            [
                'cost_bids_id' => 1,
                'selected_vendor_id' => 1,
                'total_price' => 4476000,
                'discount' => 5,
                'total_after_discount' => 4476000 - (4476000 * 5 / 100),
                'terms_of_payment' => null,
                'lead_time' => '7D',
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'cost_bids_id' => 1,
                'selected_vendor_id' => 2,
                'total_price' => 3068400,
                'discount' => 0,
                'total_after_discount' => 3068400 - (3068400 * 0 / 100),
                'terms_of_payment' => null,
                'lead_time' => '10D',
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'cost_bids_id' => 1,
                'selected_vendor_id' => 3,
                'total_price' => 4277400,
                'discount' => 2,
                'total_after_discount' => 4277400 - (4277400 * 0 / 100),
                'terms_of_payment' => null,
                'lead_time' => '4D',
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
