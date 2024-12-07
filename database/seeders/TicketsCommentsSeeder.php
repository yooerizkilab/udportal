<?php

namespace Database\Seeders;

use App\Models\TicketsComments;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketsCommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TicketsComments::insert([
            [
                'ticket_id' => 1,
                'user_id' => 1,
                'comment' => 'Test comment 1 for ticket 1',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ticket_id' => 2,
                'user_id' => 1,
                'comment' => 'Test comment 2 for ticket 2',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ticket_id' => 1,
                'user_id' => 2,
                'comment' => 'Test comment 3 for ticket 1 reply user 1',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
