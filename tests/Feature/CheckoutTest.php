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
        $bank = \App\Models\Bank::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('events.checkout', $event), [
            'ticket_type_id' => $ticketType->id,
            'quantity' => 2,
            'bank_id' => $bank->id,
            'sender_account_name' => 'John Doe',
            'sender_account_number' => '1234567890',
            'payment_proof' => \Illuminate\Http\UploadedFile::fake()->create('proof.jpg', 1024),
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('ticket_types', [
            'id' => $ticketType->id,
            'sold' => 2,
        ]);

        $this->assertDatabaseHas('payments', [
            'user_id' => $user->id,
            'amount' => $ticketType->price * 2,
            'status' => 'pending',
            'bank_id' => $bank->id,
        ]);

        $this->assertDatabaseHas('tickets', [
            'user_id' => $user->id,
            'status' => 'issued',
            'payment_status' => 'pending',
        ]);
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
