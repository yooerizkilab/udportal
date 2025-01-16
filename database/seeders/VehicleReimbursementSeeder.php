<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use App\Models\VehicleReimbursement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleReimbursementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VehicleReimbursement::insert([
            [
                'id' => 1,
                'vehicle_id' => 1,
                'date_recorded' => now(),
                'user_by' => 1,
                'fuel' => 'Pertamax',
                'amount' => 12000,
                'price' => 500000,
                'first_mileage' => 10000,
                'last_mileage' => 20000,
                'attachment_mileage' => null,
                'attachment_receipt' => 'receipt.jpg',
                'notes' => null,
                'reason' => null,
                'status' => 'Approved',
                'type' => 'Refueling',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'vehicle_id' => 2,
                'date_recorded' => now(),
                'user_by' => null,
                'fuel' => 'Pertamax',
                'amount' => 15000,
                'price' => 200000,
                'first_mileage' => 20000,
                'last_mileage' => 40000,
                'attachment_mileage' => null,
                'attachment_receipt' => 'receipt.jpg',
                'notes' => null,
                'reason' => null,
                'status' => 'Pending',
                'type' => 'Refueling',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'vehicle_id' => 1,
                'date_recorded' => now(),
                'user_by' => null,
                'fuel' => null,
                'amount' => null,
                'price' => 2000,
                'first_mileage' => null,
                'last_mileage' => null,
                'attachment_mileage' => null,
                'attachment_receipt' => 'receipt.jpg',
                'notes' => null,
                'reason' => null,
                'status' => 'Pending',
                'type' => 'Parking',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'vehicle_id' => 1,
                'date_recorded' => now(),
                'user_by' => null,
                'fuel' => null,
                'amount' => null,
                'price' => 150000,
                'first_mileage' => null,
                'last_mileage' => null,
                'attachment_mileage' => null,
                'attachment_receipt' => 'receipt.jpg',
                'notes' => null,
                'reason' => null,
                'status' => 'Pending',
                'type' => 'E-Toll',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
