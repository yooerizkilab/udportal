<?php

namespace Database\Seeders;

use App\Models\CostBidsVendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CostBidsVendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CostBidsVendor::insert([
            [
                'name' => 'PT Putra Makmur Sejahtera (Tree Star)',
                'phone' => '621234567890',
                'email' => 'email@example.com',
                'address' => 'JL. Contoh, No. 123, Contoh, Kec. Contoh, Kota Contoh, Prov. Contoh',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'PT Lion Metal Works',
                'phone' => '621234567890',
                'email' => 'email@example.com',
                'address' => 'JL. Contoh, No. 123, Contoh, Kec. Contoh, Kota Contoh, Prov. Contoh',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'PT Trimulia Sarana Agung',
                'phone' => '621234567890',
                'email' => 'email@example.com',
                'address' => 'JL. Contoh, No. 123, Contoh, Kec. Contoh, Kota Contoh, Prov. Contoh',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
