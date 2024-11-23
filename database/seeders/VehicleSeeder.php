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
                'type_id' => 1,
                'code' => 'V123',
                'brand' => 'Toyota',
                'model' => 'Avanza',
                'color' => 'White',
                'year' => 2020,
                'license_plate' => 'B1234XYZ',
                'tax_year' => '2022-01-01',
                'tax_five_year' => '2023-01-01',
                'inspected' => '2023-01-01',
                'purchase_date' => '2020-01-01',
                'purchase_price' => 2000000,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'owner_id' => 2,
                'type_id' => 1,
                'code' => 'V124',
                'brand' => 'Honda',
                'model' => 'Civic',
                'color' => 'Black',
                'year' => 2019,
                'license_plate' => 'B5678ABC',
                'tax_year' => '2022-01-01',
                'tax_five_year' => '2023-01-01',
                'inspected' => '2023-01-01',
                'purchase_date' => '2019-01-01',
                'purchase_price' => 1800000,
                'status' => 'Maintenance',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'owner_id' => 1,
                'type_id' => 2,
                'code' => 'V125',
                'brand' => 'Isuzu',
                'model' => 'Elf',
                'color' => 'Red',
                'year' => 2018,
                'license_plate' => 'B91011DEF',
                'tax_year' => '2022-01-01',
                'tax_five_year' => '2023-01-01',
                'inspected' => '2023-01-01',
                'purchase_date' => '2018-01-01',
                'purchase_price' => 1600000,
                'status' => 'Inactive',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'owner_id' => 2,
                'type_id' => 1,
                'code' => 'V126',
                'brand' => 'Suzuki',
                'model' => 'Swift',
                'color' => 'Blue',
                'year' => 2021,
                'license_plate' => 'B1234XAB',
                'tax_year' => '2022-01-01',
                'tax_five_year' => '2023-01-01',
                'inspected' => '2023-01-01',
                'purchase_date' => '2021-01-01',
                'purchase_price' => 1900000,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'owner_id' => 1,
                'type_id' => 2,
                'code' => 'V127',
                'brand' => 'Mitsubishi',
                'model' => 'Lancer',
                'color' => 'Green',
                'year' => 2017,
                'license_plate' => 'B5678XCD',
                'tax_year' => '2022-01-01',
                'tax_five_year' => '2023-01-01',
                'inspected' => '2023-01-01',
                'purchase_date' => '2017-01-01',
                'purchase_price' => 1500000,
                'status' => 'Maintenance',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
