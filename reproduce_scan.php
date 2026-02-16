<?php

use App\Models\Ticket;
use App\Models\User;
use App\Models\Event;
use App\Models\TicketType;

// Ensure dependencies exist
$user = User::first() ?? User::factory()->create();
$event = Event::first() ?? Event::factory()->create();
$ticketType = TicketType::first() ?? TicketType::factory()->create(['event_id' => $event->id]);

// Create the specific ticket
$uuid = '35fdc865-7a35-4fdb-b03e-bf51b6e542f2';

$ticket = Ticket::where('uuid', $uuid)->first();

if (!$ticket) {
    echo "Creating ticket with UUID: $uuid\n";
    $ticket = Ticket::create([
        'uuid' => $uuid,
        'user_id' => $user->id,
        'event_id' => $event->id,
        'ticket_type_id' => $ticketType->id,
        'price' => 100,
        'status' => 'paid',
        'payment_status' => 'paid',
        'user_name' => 'Test User',
        'user_email' => 'test@example.com',
    ]);
} else {
    echo "Ticket already exists.\n";
    // Reset scanned_at to test again
    $ticket->update(['scanned_at' => null]);
}

echo "Ticket created/reset. ID: " . $ticket->id . "\n";
echo "UUID: " . $ticket->uuid . "\n";
echo "Barcode Data: " . $ticket->barcode_data . "\n";

// Simulate the checkCode logic from ScanTickets.php
$code = $uuid;

$foundTicket = Ticket::where('barcode_data', $code)
            ->orWhere('uuid', $code)
            ->first();

if ($foundTicket) {
    echo "Logic SUCCESS: Ticket found by code '$code'.\n";
} else {
    echo "Logic FAILURE: Ticket NOT found by code '$code'.\n";
}
