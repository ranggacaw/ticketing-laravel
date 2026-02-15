<?php

use App\Models\User;
use App\Models\Ticket;
use App\Models\Event;
use App\Models\TicketType;

test('admin dashboard can filter tickets', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $event = Event::factory()->create();
    $typeVIP = TicketType::factory()->create(['event_id' => $event->id, 'name' => 'VIP']);
    $typeReg = TicketType::factory()->create(['event_id' => $event->id, 'name' => 'Regular']);

    // Create tickets
    $ticket1 = Ticket::factory()->create([
        'event_id' => $event->id, 
        'ticket_type_id' => $typeVIP->id, 
        'type' => 'VIP', 
        'user_name' => 'Alice',
        'created_at' => now()->subDays(1),
        'scanned_at' => now(),
    ]);
    
    $ticket2 = Ticket::factory()->create([
        'event_id' => $event->id, 
        'ticket_type_id' => $typeReg->id, 
        'type' => 'Regular', 
        'user_name' => 'Bob',
        'created_at' => now()->subDays(5),
        'scanned_at' => null,
    ]);

    $this->actingAs($admin);

    // Filter by Search (Name)
    $response = $this->get(route('admin.dashboard', ['search' => 'Alice']));
    $response->assertSee('Alice');
    $response->assertDontSee('Bob');

    // Filter by Status (Scanned)
    $response = $this->get(route('admin.dashboard', ['status' => 'scanned']));
    $response->assertSee('Alice');
    $response->assertDontSee('Bob');

    // Filter by Status (Unscanned)
    $response = $this->get(route('admin.dashboard', ['status' => 'unscanned']));
    $response->assertSee('Bob');
    $response->assertDontSee('Alice');

    // Filter by Date (From)
    $response = $this->get(route('admin.dashboard', ['date_from' => now()->subDays(2)->toDateString()]));
    $response->assertSee('Alice');
    $response->assertDontSee('Bob');
});
