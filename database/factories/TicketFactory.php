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
            'user_name' => $this->faker->name(),
            'user_email' => $this->faker->unique()->safeEmail(),
            'seat_number' => strtoupper($this->faker->bothify('??-##')),
            'price' => $this->faker->randomFloat(2, 50, 500),
            'type' => $this->faker->randomElement(['VIP', 'General Admission', 'Backstage Pass']),
            'barcode_data' => strtoupper($this->faker->bothify('TICKET-####-####')),
            'scanned_at' => null,
        ];
    }
}
