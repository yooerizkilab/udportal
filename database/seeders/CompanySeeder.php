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
                'company' => 'Company A',
                'name' => 'Company A',
                'password' => 'password1',
                'full_name' => 'Company A',
                'email' => 'q3pG6@example.com',
                'address' => 'Address A',
                'phone' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'C002',
                'company' => 'Company B',
                'name' => 'Company B',
                'password' => 'password2',
                'full_name' => 'Company B',
                'email' => 'b3q3pG6@example.com',
                'address' => 'Address B',
                'phone' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
