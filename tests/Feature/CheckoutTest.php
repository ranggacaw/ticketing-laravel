<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\TicketType;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_checkout()
    {
        $event = Event::factory()->create(['status' => 'published']);
        $ticketType = TicketType::factory()->create(['event_id' => $event->id, 'quantity' => 10, 'sold' => 0]);

        $response = $this->post(route('events.checkout', $event), [
            'ticket_type_id' => $ticketType->id,
            'quantity' => 1,
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_user_can_purchase_ticket()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['status' => 'published']);
        $ticketType = TicketType::factory()->create(['event_id' => $event->id, 'quantity' => 10, 'sold' => 0]);

        $this->actingAs($user);

        $response = $this->post(route('events.checkout', $event), [
            'ticket_type_id' => $ticketType->id,
            'quantity' => 2,
        ]);

        // Should redirect to success
        $response->assertRedirect();

        // Follow redirect to check success page?
        // Usually checkout redirects to route('checkout.success', uuid)
        // We can assert database changes first.

        $this->assertDatabaseHas('ticket_types', [
            'id' => $ticketType->id,
            'sold' => 2,
        ]);

        $this->assertCount(2, Ticket::where('user_id', $user->id)->get());
    }

    public function test_cannot_purchase_unavailable_ticket()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['status' => 'published']);
        $ticketType = TicketType::factory()->create(['event_id' => $event->id, 'quantity' => 5, 'sold' => 5]);

        $this->actingAs($user);

        $response = $this->post(route('events.checkout', $event), [
            'ticket_type_id' => $ticketType->id,
            'quantity' => 1,
        ]);

        // Should fail validation or throw error and redirect back with error
        $response->assertSessionHasErrors(['ticket_type_id']);

        $this->assertDatabaseHas('ticket_types', [
            'id' => $ticketType->id,
            'sold' => 5, // Unchanged
        ]);
    }
}
