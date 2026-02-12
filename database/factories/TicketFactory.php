<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'secure_token' => (string) Str::random(64),
            'ticket_type_id' => \App\Models\TicketType::factory(),
            'event_id' => function (array $attributes) {
                return \App\Models\TicketType::find($attributes['ticket_type_id'])->event_id;
            },
            'seat_id' => null,
            'user_id' => \App\Models\User::factory(),
            'status' => 'issued',

            // Legacy fields populated for compatibility
            'user_name' => fake()->name(),
            'user_email' => fake()->unique()->safeEmail(),
            'seat_number' => strtoupper(fake()->bothify('??-##')),
            'price' => function (array $attributes) {
                if (isset($attributes['ticket_type_id'])) {
                    $ticketType = \App\Models\TicketType::find($attributes['ticket_type_id']);
                    return $ticketType ? $ticketType->price : fake()->numberBetween(50000, 1000000);
                }
                return fake()->numberBetween(50000, 1000000);
            },
            'type' => fake()->randomElement(['VIP', 'General Admission']),
            'barcode_data' => strtoupper(fake()->bothify('TICKET-####-####')),
            'scanned_at' => null,
        ];
    }
}
