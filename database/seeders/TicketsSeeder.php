<?php

namespace Database\Seeders;

use App\Models\Tickets;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tickets::insert([
            [
                'user_id' => 2,
                'category_id' => 1,
                'assignee_id' => 1, // Assignee to Department
                'fixed_by' => null, // User Fixed
                'code' => 'TICKET-0001',
                'title' => 'Test Ticket 1',
                'description' => 'This is a test ticket 1',
                'solution' => null,
                'attachment' => null,
                'closed_date' => null,
                'priority' => 'Low',
                'status' => 'Open',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 1,
                'category_id' => 2,
                'assignee_id' => 2, // Assignee to Department
                'fixed_by' => null, // User Fixed
                'code' => 'TICKET-0002',
                'title' => 'Test Ticket 2',
                'description' => 'This is a test ticket 2',
                'solution' => null,
                'attachment' => null,
                'closed_date' => null,
                'priority' => 'High',
                'status' => 'In Progress',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 2,
                'category_id' => 3,
                'assignee_id' => 1, // Assignee to Department
                'fixed_by' => 1, // User Fixed
                'code' => 'TICKET-0003',
                'title' => 'Test Ticket 3',
                'description' => 'This is a test ticket 3',
                'solution' => 'This is the solution for ticket 3',
                'attachment' => 'test.jpg',
                'closed_date' => '2023-01-01',
                'priority' => 'Medium',
                'status' => 'Closed',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
