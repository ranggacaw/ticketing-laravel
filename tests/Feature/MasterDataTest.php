<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Event;
use App\Models\Venue;
use App\Models\Organizer;
use App\Models\TicketType;
use App\Models\Ticket;
use App\Models\User;

class MasterDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_event_with_relations()
    {
        $venue = Venue::factory()->create();
        $organizer = Organizer::factory()->create();

        $event = Event::factory()->create([
            'venue_id' => $venue->id,
            'organizer_id' => $organizer->id,
        ]);

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'venue_id' => $venue->id,
            'organizer_id' => $organizer->id,
        ]);

        $this->assertTrue($event->venue->is($venue));
        $this->assertTrue($event->organizer->is($organizer));
    }

    public function test_ticket_type_inventory_check()
    {
        $ticketType = TicketType::factory()->create([
            'quantity' => 10,
            'sold' => 10,
        ]);

        $this->assertFalse($ticketType->is_available);

        $ticketType->update(['sold' => 9]);
        $this->assertTrue($ticketType->is_available);
    }

    public function test_ticket_issuance_validates_token()
    {
        $user = User::factory()->create();
        $ticketType = TicketType::factory()->create();

        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
            'ticket_type_id' => $ticketType->id,
        ]);

        $this->assertNotNull($ticket->secure_token);
        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'secure_token' => $ticket->secure_token,
        ]);

        // Ensure token uniqueness
        try {
            Ticket::factory()->create([
                'secure_token' => $ticket->secure_token, // Duplicate token
            ]);
            $this->fail('Should not allow duplicate secure_token');
        } catch (\Illuminate\Database\QueryException $e) {
            $this->assertStringContainsString('tickets_secure_token_unique', $e->getMessage());
        }
    }
}
