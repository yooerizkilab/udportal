<?php

namespace Database\Seeders;

use App\Models\Projects;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Projects::insert([
            [
                'code' => 'WRHS0001',
                'name' => 'Warehouse Alpha',
                'address' => 'Jl Srengseng Sawah 87, Dki Jakarta',
                'phone' => '1234567890',
                'email' => 'warehousealpha@example.com',
                'ppic' => 'John Doe',
                'description' => 'Description for Warehouse 1',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'PRJ0001',
                'name' => 'Project Alpha',
                'address' => 'Jl Susukan 2 Ponjong Wonosari, Jawa Tengah',
                'phone' => '1234567890',
                'email' => 'projectalpha@example.com',
                'ppic' => 'John Doe',
                'description' => 'Description for Project 1',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'PRJ0002',
                'name' => 'Project Beta',
                'address' => 'Jl Kemang Utr IX 9, Dki Jakarta',
                'phone' => '1234567890',
                'email' => 'projectbeta@example.com',
                'ppic' => 'John Doe',
                'description' => 'Description for Project 2',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'PRJ0003',
                'name' => 'Project Gamma',
                'address' => 'Jl Pembangunan II/6, Dki Jakarta',
                'phone' => '1234567890',
                'email' => 'projectgamma@example.com',
                'ppic' => 'John Doe',
                'description' => 'Description for Project 3',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
