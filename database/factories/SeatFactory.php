<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seat>
 */
class SeatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'venue_id' => \App\Models\Venue::factory(),
            'section' => fake()->randomLetter(),
            'row' => fake()->numberBetween(1, 20),
            'number' => fake()->numberBetween(1, 50),
            'status' => 'available',
            'type' => 'standard',
        ];
    }
}
