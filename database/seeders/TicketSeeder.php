<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Ticket;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $adminUsers = User::where('role', 'admin')->get();

        Ticket::factory()
            ->count(20)
            ->create([
                'issued_by' => function () use ($users) {
                    return $users->random()->id;
                },
                'issued_to' => function () use ($adminUsers) {
                    return $adminUsers->random()->id;
                },
            ]);
    }
}
