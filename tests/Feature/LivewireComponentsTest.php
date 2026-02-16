<?php

namespace Tests\Feature;

use App\Livewire\BrowseEvents;
use App\Livewire\MyTickets;
use App\Livewire\PaymentStatus;
use App\Livewire\TicketDetail;
use App\Livewire\TicketPurchase;
use App\Livewire\TicketScanner;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
use App\Models\Venue;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireComponentsTest extends TestCase
{
    /** @test */
    public function browse_events_component_renders_successfully()
    {
        Livewire::test(BrowseEvents::class)
            ->assertStatus(200);
    }

    /** @test */
    public function browse_events_component_can_search_events()
    {
        $venue = Venue::factory()->create();
        $event1 = Event::factory()->create(['name' => 'Concert A', 'venue_id' => $venue->id, 'status' => 'published']);
        $event2 = Event::factory()->create(['name' => 'Concert B', 'venue_id' => $venue->id, 'status' => 'published']);

        Livewire::test(BrowseEvents::class)
            ->set('search', 'Concert A')
            ->assertSee('Concert A')
            ->assertDontSee('Concert B');
    }

    /** @test */
    public function ticket_detail_component_renders_successfully()
    {
        $venue = Venue::factory()->create();
        $event = Event::factory()->create(['venue_id' => $venue->id, 'status' => 'published']);

        Livewire::test(TicketDetail::class, ['slug' => $event->slug])
            ->assertStatus(200)
            ->assertSee($event->name);
    }

    /** @test */
    public function ticket_purchase_component_calculates_total_correctly()
    {
        $user = User::factory()->create();
        $venue = Venue::factory()->create();
        $event = Event::factory()->create(['venue_id' => $venue->id, 'status' => 'published']);
        $ticketType = TicketType::factory()->create([
            'event_id' => $event->id,
            'price' => 100,
            'quantity' => 50
        ]);

        Livewire::test(TicketPurchase::class, ['eventId' => $event->id])
            ->set('quantities.' . $ticketType->id, 2)
            ->assertSet('total', 200);
    }

    /** @test */
    public function my_tickets_component_renders_for_authenticated_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(MyTickets::class)
            ->assertStatus(200);
    }

    /** @test */
    public function ticket_scanner_component_can_scan_valid_ticket()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $venue = Venue::factory()->create();
        $event = Event::factory()->create(['venue_id' => $venue->id, 'status' => 'published']);
        $ticketType = TicketType::factory()->create(['event_id' => $event->id]);
        $ticket = Ticket::factory()->create([
            'event_id' => $event->id,
            'ticket_type_id' => $ticketType->id,
            'user_id' => $user->id,
            'payment_status' => 'paid',
            'status' => 'active'
        ]);

        Livewire::test(TicketScanner::class)
            ->set('barcode_input', $ticket->uuid)
            ->call('scan')
            ->assertSet('scan_result.status', 'success');
        
        $this->assertEquals('scanned', $ticket->fresh()->status);
    }

    /** @test */
    public function ticket_scanner_rejects_already_scanned_ticket()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $venue = Venue::factory()->create();
        $event = Event::factory()->create(['venue_id' => $venue->id, 'status' => 'published']);
        $ticketType = TicketType::factory()->create(['event_id' => $event->id]);
        $ticket = Ticket::factory()->create([
            'event_id' => $event->id,
            'ticket_type_id' => $ticketType->id,
            'user_id' => $user->id,
            'payment_status' => 'paid',
            'status' => 'scanned',
            'scanned_at' => now(),
        ]);

        Livewire::test(TicketScanner::class)
            ->set('barcode_input', $ticket->uuid)
            ->call('scan')
            ->assertSet('scan_result.status', 'error');
    }

    /** @test */
    public function payment_status_component_shows_correct_status()
    {
        $user = User::factory()->create();
        $venue = Venue::factory()->create();
        $event = Event::factory()->create(['venue_id' => $venue->id, 'status' => 'published']);
        $ticketType = TicketType::factory()->create(['event_id' => $event->id]); // Ensure TicketType exists
        $ticket = Ticket::factory()->create([
            'event_id' => $event->id, 
            'ticket_type_id' => $ticketType->id, 
            'user_id' => $user->id, 
            'payment_status' => 'pending'
        ]);

        Livewire::test(PaymentStatus::class, ['ticketUuid' => $ticket->uuid])
            ->assertSet('status', 'pending');
            
        $ticket->update(['payment_status' => 'paid']);
        
        Livewire::test(PaymentStatus::class, ['ticketUuid' => $ticket->uuid])
             ->call('checkStatus')
             ->assertSet('status', 'paid');
    }
}
