<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vehicle::insert([
            [
                'owner_id' => 1,
                'vehicle_code' => 'V123',
                'brand' => 'Toyota',
                'model' => 'Avanza',
                'year' => 2020,
                'license_plate' => 'B1234XYZ',
                'tax_year' => '2022-01-01',
                'tax_five_year' => '2023-01-01',
                'inspected' => '2023-01-01',
                'purchase_date' => '2020-01-01',
                'purchase_price' => 2000000,
                'status' => 'Active',
                'type_id' => 1, // Assuming 1 is 'Car' type
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'owner_id' => 2,
                'vehicle_code' => 'V124',
                'brand' => 'Honda',
                'model' => 'Civic',
                'year' => 2019,
                'license_plate' => 'B5678ABC',
                'tax_year' => '2022-01-01',
                'tax_five_year' => '2023-01-01',
                'inspected' => '2023-01-01',
                'purchase_date' => '2019-01-01',
                'purchase_price' => 1800000,
                'status' => 'Maintenance',
                'type_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'owner_id' => 1,
                'vehicle_code' => 'V125',
                'brand' => 'Isuzu',
                'model' => 'Elf',
                'year' => 2018,
                'license_plate' => 'B91011DEF',
                'tax_year' => '2022-01-01',
                'tax_five_year' => '2023-01-01',
                'inspected' => '2023-01-01',
                'purchase_date' => '2018-01-01',
                'purchase_price' => 1600000,
                'status' => 'Inactive',
                'type_id' => 2, // Assuming 2 is 'Truck' type
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'owner_id' => 2,
                'vehicle_code' => 'V126',
                'brand' => 'Suzuki',
                'model' => 'Swift',
                'year' => 2021,
                'license_plate' => 'B1234XAB',
                'tax_year' => '2022-01-01',
                'tax_five_year' => '2023-01-01',
                'inspected' => '2023-01-01',
                'purchase_date' => '2021-01-01',
                'purchase_price' => 1900000,
                'status' => 'Active',
                'type_id' => 1, // Assuming 1 is 'Car' type
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
