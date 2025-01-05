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
                'code' => 'KO-0001',
                'brand' => 'TOYOTA',
                'model' => 'FORTUNER VRZ',
                'color' => 'BROWN',
                'transmission' => 'Automatic',
                'fuel' => 'Gasoline',
                'year' => 2018,
                'license_plate' => 'L 1941 BAM',
                'tax_year' => '2025-01-09',
                'tax_five_year' => '2029-01-09',
                'inspected' => null,
                'purchase_date' => null,
                'purchase_price' => null,
                'status' => 'Active',
                'description' => 'Description for Vehicle 1 Direksi',
                'origin' => 'UDMW',
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'owner_id' => 1,
                'type_id' => 1,
                'code' => 'KO-0002',
                'brand' => 'TOYOTA',
                'model' => 'AVANZA',
                'color' => 'SILVER',
                'transmission' => 'Automatic',
                'fuel' => 'Gasoline',
                'year' => 2013,
                'license_plate' => 'L 1447 HB',
                'tax_year' => '2025-01-13',
                'tax_five_year' => '2029-01-13',
                'inspected' => null,
                'purchase_date' => null,
                'purchase_price' => null,
                'status' => 'Active',
                'description' => 'Description for Vehicle 2 Manager',
                'origin' => 'UDMW',
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'owner_id' => 1,
                'type_id' => 1,
                'code' => 'TO-0003',
                'brand' => 'TOYOTA',
                'model' => 'AVANZA',
                'color' => 'WHITE',
                'transmission' => 'Automatic',
                'fuel' => 'Gasoline',
                'year' => 2013,
                'license_plate' => 'L 1096 GO',
                'tax_year' => '2025-01-17',
                'tax_five_year' => '2029-01-17',
                'inspected' => null,
                'purchase_date' => null,
                'purchase_price' => null,
                'status' => 'Active',
                'description' => 'Description for Vehicle 3 Staff',
                'origin' => 'UDMW',
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'owner_id' => 1,
                'type_id' => 1,
                'code' => 'KO-0004',
                'brand' => 'DAIHATSU',
                'model' => 'GRAN MAX',
                'color' => null,
                'transmission' => 'Manual',
                'fuel' => 'Gasoline',
                'year' => 2018,
                'license_plate' => 'L 1798 HW',
                'tax_year' => '2025-01-23',
                'tax_five_year' => '2029-01-23',
                'inspected' => null,
                'purchase_date' => null,
                'purchase_price' => null,
                'status' => 'Active',
                'description' => 'Description for Vehicle 4 Staff',
                'origin' => 'UDMW',
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'owner_id' => 1,
                'type_id' => 1,
                'code' => 'KO-0005',
                'brand' => 'TOYOTA',
                'model' => 'AVANZA VELOZ',
                'color' => 'SILVER',
                'transmission' => 'Automatic',
                'fuel' => 'Gasoline',
                'year' => 2015,
                'license_plate' => 'B 1612 PYI',
                'tax_year' => '2026-01-26',
                'tax_five_year' => '2026-01-26',
                'inspected' => null,
                'purchase_date' => null,
                'purchase_price' => null,
                'status' => 'Active',
                'description' => 'Description for Vehicle 5 Staff',
                'origin' => 'UDMW',
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
