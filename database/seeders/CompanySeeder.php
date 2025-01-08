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
                'name' => 'Utomodeck Metal Works',
                'email' => 'companya@example.com',
                'address' => 'Jl Hayam Wuruk Glodok Harco Bl D/82, Dki Jakarta',
                'phone' => '62227272262',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
