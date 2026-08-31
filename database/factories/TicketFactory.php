<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'category' => fake()->word(),
            'status' => fake()->randomElement(['open', 'started', 'closed']),
            'issued_by' => User::factory()->user(),
            'issued_to' => User::factory()->admin(),
            'created_at' => fake()->dateTimeBetween('-2 month', '-1 month'),
            'updated_at' => fake()->dateTimeBetween('-1 month')
        ];
    }
}
