<?php

namespace Database\Seeders;

use App\Models\IncomingSupplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncomingSupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IncomingSupplier::insert([
            [
                'name' => 'King Point Enterprise (Patta)',
                'phone' => '1234567890',
                'email' => '2Ct8U@example.com',
                'address' => 'Jl. Contoh, No. 123, Contoh, Kec. Contoh, Kota Contoh, Prov. Contoh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'New Kahiang Machinary',
                'phone' => '1234567890',
                'email' => '2Ct8U@example.com',
                'address' => 'Jl. Contoh, No. 123, Contoh, Kec. Contoh, Kota Contoh, Prov. Contoh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Longi',
                'phone' => '1234567890',
                'email' => '2Ct8U@example.com',
                'address' => 'Jl. Contoh, No. 123, Contoh, Kec. Contoh, Kota Contoh, Prov. Contoh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Qingdao TELD',
                'phone' => '1234567890',
                'email' => '2Ct8U@example.com',
                'address' => 'Jl. Contoh, No. 123, Contoh, Kec. Contoh, Kota Contoh, Prov. Contoh',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
