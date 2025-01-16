<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::insert([
            [
                'code' => 'C00001',
                'name' => 'PT Utomodeck Metal Works',
                'email' => 'info@utomodeck.com',
                'address' => 'Jl. Basuki Rahmat No.149, Embong Kaliasin, Kec. Genteng, Surabaya, Jawa Timur 60271',
                'phone' => '(031) 534 4356',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
