<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TicketType>
 */
class TicketTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => \App\Models\Event::factory(),
            'name' => fake()->word() . ' Access',
            'description' => fake()->sentence(),
            'price' => fake()->numberBetween(50000, 1000000),
            'quantity' => fake()->numberBetween(50, 500),
            'sold' => 0,
            'sale_start_date' => now()->subDays(1),
            'sale_end_date' => now()->addMonths(1),
        ];
    }
}
