<?php

namespace Database\Seeders;

use App\Models\VehicleTransaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VehicleTransaction::insert([
            [
                'vehicle_id' => 1,
                'user_id' => 1,
                'code' => 'PPB/TF/XII/2021/AMM001',
                'type' => 'Transfer',
                'from' => 'Office XYZ',
                'to' => 'Branch ABC',
                'transaction_date' => now(),
                'return_date' => null,
                'notes' => 'Note 1',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
