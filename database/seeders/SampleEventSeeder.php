<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\TicketType;
use App\Models\Venue;
use App\Models\Seat;

class SampleEventSeeder extends Seeder
{
    public function run(): void
    {
        $venue = Venue::factory()->create([
            'name' => 'Grand Hall',
            'capacity' => 100,
            'city' => 'New York',
            'country' => 'USA',
        ]);

        $event = Event::factory()->create([
            'venue_id' => $venue->id,
            'name' => 'Tech Conference 2026',
            'status' => 'published',
        ]);

        $vip = TicketType::factory()->create([
            'event_id' => $event->id,
            'name' => 'VIP',
            'price' => 500.00,
            'quantity' => 20,
        ]);

        $standard = TicketType::factory()->create([
            'event_id' => $event->id,
            'name' => 'Standard',
            'price' => 150.00,
            'quantity' => 80,
        ]);

        // Generate seats for the venue
        for ($i = 1; $i <= 5; $i++) { // 5 rows
            for ($j = 1; $j <= 20; $j++) { // 20 seats per row
                Seat::factory()->create([
                    'venue_id' => $venue->id,
                    'row' => chr(64 + $i), // A, B, C...
                    'number' => $j,
                    'section' => 'Main',
                ]);
            }
        }
    }
}
