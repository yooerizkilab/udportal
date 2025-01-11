<?php

namespace Database\Seeders;

use App\Models\CostBidsInventoryVendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CostBidsInventoryVendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        CostBidsInventoryVendor::insert([
            [
                'cost_bids_id' => 1,
                'cost_bids_vendor_id' => 1,
                'cost_bids_inventory_id' => 1,
                'price_per_unit' => 446000,
                'sub_total' => 2676000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cost_bids_id' => 1,
                'cost_bids_vendor_id' => 1,
                'cost_bids_inventory_id' => 2,
                'price_per_unit' => 300000,
                'sub_total' => 1800000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cost_bids_id' => 1,
                'cost_bids_vendor_id' => 2,
                'cost_bids_inventory_id' => 1,
                'price_per_unit' => 375200,
                'sub_total' => 2015400,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cost_bids_id' => 1,
                'cost_bids_vendor_id' => 2,
                'cost_bids_inventory_id' => 2,
                'price_per_unit' => 198800,
                'sub_total' => 1053000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cost_bids_id' => 1,
                'cost_bids_vendor_id' => 3,
                'cost_bids_inventory_id' => 1,
                'price_per_unit' => 354700,
                'sub_total' => 2128200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cost_bids_id' => 1,
                'cost_bids_vendor_id' => 3,
                'cost_bids_inventory_id' => 2,
                'price_per_unit' => 358200,
                'sub_total' => 2149200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
