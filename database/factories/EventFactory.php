<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
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
            'organizer_id' => \App\Models\Organizer::factory(),
            'name' => fake()->sentence(3),
            'slug' => fake()->unique()->slug(),
            'description' => fake()->paragraph(),
            'start_time' => fake()->dateTimeBetween('+1 week', '+1 month'),
            'end_time' => fake()->dateTimeBetween('+1 month', '+2 months'),
            'status' => 'published',
        ];
    }
}
