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
            // Technical Issue
            [
                'name' => 'Technical Issue',
                'slug' => 'technical-issue',
                'description' => 'This is a description of the Technical Issue category',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Billing Issue
            [
                'name' => 'Billing Issue',
                'slug' => 'billing-issue',
                'description' => 'This is a description of the Billing Issue category',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Account Issue
            [
                'name' => 'Account Issue',
                'slug' => 'account-issue',
                'description' => 'This is a description of the Account Issue category',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Security Issue
            [
                'name' => 'Security Issue',
                'slug' => 'security-issue',
                'description' => 'This is a description of the Security Issue category',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Insfrastructure Issue
            [
                'name' => 'Infrastructure Issue',
                'slug' => 'infrastructure-issue',
                'description' => 'This is a description of the Infrastructure Issue category',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Support Issue
            [
                'name' => 'Support Issue',
                'slug' => 'support-issue',
                'description' => 'This is a description of the Support Issue category',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // General Issue
            [
                'name' => 'General Issue',
                'slug' => 'general-issue',
                'description' => 'This is a description of the General Issue category',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Other Issue
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
