<?php

use App\Models\Event;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('event participants page lists users with tickets', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create();
    $event = Event::factory()->create();
    $ticketType = TicketType::factory()->create(['event_id' => $event->id]);

    $ticket = Ticket::factory()->create([
        'user_id' => $user->id,
        'event_id' => $event->id,
        'ticket_type_id' => $ticketType->id,
        'user_name' => 'John Participant',
        'user_email' => 'john@party.com',
    ]);

    $response = $this->actingAs($admin)
        ->get(route('admin.events.participants', $event));

    $response->assertStatus(200);
    $response->assertSee('Participants List');
    $response->assertSee('John Participant');
    $response->assertSee('john@party.com');
});
