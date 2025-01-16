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
                'code' => 'PO-00001',
                'branch_id' => 1,
                'supplier_id' => 1,
                'eta' => '2025-01-05',
                'warehouse_id' => 1,
                'drop_site' => null,
                'phone_drop_site' => null,
                'email_drop_site' => null,
                'status' => 'On Progress',
                'notes' => null,
                'attachment' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'PO-00002',
                'branch_id' => 1,
                'supplier_id' => 2,
                'eta' => '2025-01-05',
                'warehouse_id' => 1,
                'drop_site' => null,
                'phone_drop_site' => null,
                'email_drop_site' => null,
                'status' => 'On Progress',
                'notes' => null,
                'attachment' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'PO-00003',
                'branch_id' => 2,
                'supplier_id' => 3,
                'eta' => '2025-01-17',
                'warehouse_id' => 1,
                'drop_site' => null,
                'phone_drop_site' => null,
                'email_drop_site' => null,
                'status' => 'On Progress',
                'notes' => null,
                'attachment' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'PO-00004',
                'branch_id' => 2,
                'supplier_id' => 4,
                'eta' => '2025-01-25',
                'warehouse_id' => 1,
                'drop_site' => null,
                'phone_drop_site' => null,
                'email_drop_site' => null,
                'status' => 'On Progress',
                'notes' => null,
                'attachment' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
