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
    public function run()
    {
        // 1. Membuat data proyek
        $project = CostBids::create([
            'code' => 'UD/BIDS/I/2025/00001',
            'project_name' => 'Wika Cibubur',
            'document_date' => '2025-01-10',
            'bid_date' => '2025-01-12',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Membuat data vendor
        $vendors = [
            [
                'name' => 'PT Putera Makmur',
                'phone' => '6232254545',
                'email' => 'abc@email.com',
                'address' => 'Jl. Ciputat Raya No. 10, Jakarta Selatan',
                'grand_total' => 4476000,
                'discount' => 40,
                'final_total' => 2685600,
                'terms_of_payment' => 'bdsad',
                'lead_time' => '14D',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PT Lion Metal Works',
                'phone' => '62324232343',
                'email' => 'bcd@example.com',
                'address' => 'Jl. Ciputat Raya No. 10, Jakarta Selatan',
                'grand_total' => 3444000,
                'discount' => 0,
                'final_total' => 3444000,
                'terms_of_payment' => 'fdsff',
                'lead_time' => '14D',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PT Trimulia Sarana Agung',
                'phone' => '6289523131',
                'email' => 'ghu@email.com',
                'address' => 'Jl. Ciputat Raya No. 10, Jakarta Selatan',
                'grand_total' => 4277400,
                'discount' => 40,
                'final_total' => 2566440,
                'terms_of_payment' => 'ewfew',
                'lead_time' => '10D',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($vendors as $vendor) {
            $project->vendors()->create($vendor);
        }

        // 3. Membuat data item
        $items = [
            [
                'description' => 'Elbow 250 x 100',
                'quantity' => 6,
                'uom' => 'PCS',
            ],
            [
                'description' => 'IR 250 x 100',
                'quantity' => 6,
                'uom' => 'PCS',
            ],
        ];

        foreach ($items as $itemData) {
            $item = $project->items()->create($itemData);

            // 4. Menambahkan harga vendor untuk setiap item
            $itemVendorPrices = [
                [
                    'cost_bids_item_id' => $item->id,
                    'cost_bids_vendor_id' => $project->vendors[0]->id,
                    'price' => $itemData['description'] === 'Elbow 250 x 100' ? 446000 : 300000,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'cost_bids_item_id' => $item->id,
                    'cost_bids_vendor_id' => $project->vendors[1]->id,
                    'price' => $itemData['description'] === 'Elbow 250 x 100' ? 375200 : 198800,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'cost_bids_item_id' => $item->id,
                    'cost_bids_vendor_id' => $project->vendors[2]->id,
                    'price' => $itemData['description'] === 'Elbow 250 x 100' ? 354700 : 358200,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            foreach ($itemVendorPrices as $itemVendorPrice) {
                $item->costBidsAnalysis()->create($itemVendorPrice);
            }
        }
    }
}
