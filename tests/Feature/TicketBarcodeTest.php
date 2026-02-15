<?php

use App\Models\Event;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

test('multiple tickets created in one transaction have uniqueBarcodeData', function () {
    $user = User::factory()->create();
    $event = Event::factory()->create();
    $ticketType = TicketType::factory()->create(['event_id' => $event->id]);

    $tickets = Ticket::factory()->count(10)->create([
        'user_id' => $user->id,
        'event_id' => $event->id,
        'ticket_type_id' => $ticketType->id,
        'seat_number' => fn () => Str::random(10),
    ]);

    $barcodes = $tickets->pluck('barcode_data');

    expect($barcodes->unique()->count())->toBe(10);
    
    $validUUIDs = $barcodes->filter(fn ($code) => Str::isUuid($code));
    expect($validUUIDs->count())->toBe(10);
});
