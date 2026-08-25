<?php

namespace Database\Factories;

use App\Models\TicketNote;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Ticket;
use App\Models\User;

/**
 * @extends Factory<TicketNote>
 */
class TicketNoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ticket_id' => Ticket::factory(),
            'user_id' => User::factory(['role' => 'admin']),
            'note' => fake()->text()
        ];
    }
}
