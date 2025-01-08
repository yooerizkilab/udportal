<?php

namespace Database\Seeders;

use App\Models\IncomingShipments;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncomingShipmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IncomingShipments::insert([
            [
                'code' => 'PO-001',
                'branch_id' => 1,
                'supplier_id' => 1,
                'item_id' => 1,
                'drop_site_id' => 1,
                'eta' => '2025-01-07',
                'status' => 'On Progress',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'PO-001',
                'branch_id' => 1,
                'supplier_id' => 1,
                'item_id' => 2,
                'drop_site_id' => 1,
                'eta' => '2025-01-07',
                'status' => 'On Progress',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'PO-002',
                'branch_id' => 1,
                'supplier_id' => 2,
                'item_id' => 3,
                'drop_site_id' => 1,
                'eta' => '2025-01-18',
                'status' => 'On Progress',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'PO-003',
                'branch_id' => 2,
                'supplier_id' => 3,
                'item_id' => 4,
                'drop_site_id' => 2,
                'eta' => '2025-01-15',
                'status' => 'On Progress',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'PO-004',
                'branch_id' => 2,
                'supplier_id' => 4,
                'item_id' => 5,
                'drop_site_id' => 2,
                'eta' => '2025-01-14',
                'status' => 'On Progress',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
