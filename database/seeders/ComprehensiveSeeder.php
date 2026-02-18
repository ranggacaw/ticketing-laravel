<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Organizer;
use App\Models\TicketType;
use App\Models\Venue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ComprehensiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('seeders/dataset.json'));
        $data = json_decode($json, true);

        // Maps to store the mapping between JSON IDs and actual Database IDs
        $organizerMap = [];
        $venueMap = [];

        // 1. Seed Organizers
        $this->command->info('Seeding Organizers...');
        foreach ($data['organizers'] as $organizerData) {
            $jsonId = $organizerData['id'];
            unset($organizerData['id']); // Remove ID to let DB handle AI

            // Use name or email as unique key
            $organizer = Organizer::updateOrCreate(
                ['email' => $organizerData['email']],
                $organizerData
            );
            
            $organizerMap[$jsonId] = $organizer->id;
        }

        // 2. Seed Venues
        $this->command->info('Seeding Venues...');
        foreach ($data['venues'] as $venueData) {
            $jsonId = $venueData['id'];
            unset($venueData['id']);

            $venue = Venue::updateOrCreate(
                ['name' => $venueData['name']], // unique by name
                $venueData
            );

            $venueMap[$jsonId] = $venue->id;
        }

        // 3. Seed Events
        $this->command->info('Seeding Events...');
        foreach ($data['events'] as $eventData) {
            
            // Resolve relationships
            $organizerId = $organizerMap[$eventData['organizer_id']] ?? null;
            $venueId = $venueMap[$eventData['venue_id']] ?? null;

            // Extract ticket types to handle separately
            $ticketTypesData = $eventData['ticket_types'] ?? [];
            unset($eventData['ticket_types']); // Remove from event data
            unset($eventData['organizer_id']);
            unset($eventData['venue_id']);

            $eventData['organizer_id'] = $organizerId;
            $eventData['venue_id'] = $venueId;

            $event = Event::updateOrCreate(
                ['slug' => $eventData['slug']],
                $eventData
            );

            // 4. Seed Ticket Types for the Event
            foreach ($ticketTypesData as $ttData) {
                TicketType::updateOrCreate(
                    [
                        'event_id' => $event->id,
                        'name' => $ttData['name']
                    ],
                    [
                        'price' => $ttData['price'],
                        'quantity' => $ttData['quantity'],
                        // Defaults
                        'sold' => 0,
                        'description' => $ttData['name'] . ' for ' . $event->name,
                        'is_active' => true,
                        'sale_start_date' => now(), // Available immediately
                        'sale_end_date' => $event->start_time, // Sales end when event starts
                    ]
                );
            }
        }
        
        $this->command->info('Comprehensive Seeding Completed!');
    }
}
