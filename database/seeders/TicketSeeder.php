<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Category;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $admins = User::where('role', 'admin')->get();
        $categories = Category::all();

        Ticket::factory()
            ->count(20)
            ->create([
                'issued_by' => function () use ($users) {
                    return $users->random()->id;
                },
                'issued_to' => function () use ($admins) {
                    return $admins->random()->id;
                },
                'category_id' => function () use ($categories) {
                    return $categories->random()->id;
                }
            ]);
    }
}
