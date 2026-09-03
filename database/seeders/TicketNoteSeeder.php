<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\TicketNote;
use App\Models\User;

class TicketNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tickets = Ticket::all();
        $adminUsers = User::where('role', 'admin')->get();

        TicketNote::factory()
            ->count(50)
            ->recycle([$tickets, $adminUsers])
            ->create();
    }
}
