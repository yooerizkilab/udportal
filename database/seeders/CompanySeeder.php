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
                'company_code' => 'C001',
                'company' => 'Company A',
                'company_name' => 'Company A',
                'company_password' => 'password1',
                'company_full_name' => 'Company A',
                'company_email' => 'q3pG6@example.com',
                'company_address' => 'Address A',
                'company_phone' => '1234567890',
            ],
            [
                'company_code' => 'C002',
                'company' => 'Company B',
                'company_name' => 'Company B',
                'company_password' => 'password2',
                'company_full_name' => 'Company B',
                'company_email' => 'b3q3pG6@example.com',
                'company_address' => 'Address B',
                'company_phone' => '1234567890',
            ]
        ]);
    }
}
