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
                'code' => 'C001',
                'company' => 'PT ABC',
                'name' => 'Company A',
                'password' => 'password1',
                'email' => 'q3pG6@example.com',
                'address' => 'Address A',
                'phone' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
