<?php

namespace Database\Seeders;

use App\Models\TicketsCategories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketsCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 
        TicketsCategories::insert([
            [
                'name' => 'Technical Issue',
                'slug' => 'technical-issue',
                'description' => 'This is a description of the Technical Issue category',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Billing Issue',
                'slug' => 'billing-issue',
                'description' => 'This is a description of the Billing Issue category',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Account Issue',
                'slug' => 'account-issue',
                'description' => 'This is a description of the Account Issue category',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Other Issue',
                'slug' => 'other-issue',
                'description' => 'This is a description of the Other Issue category',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
