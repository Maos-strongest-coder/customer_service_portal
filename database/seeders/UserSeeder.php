<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->count(3)
            ->admin()
            ->create();

        User::factory()
            ->count(15)
            ->user()
            ->create();
            
        User::factory()->admin()->create([
            'first_name' => 'Admin',
            'last_name' => 'Tester',
            'email' => 'admin@test.com',
        ]);
    }
}
