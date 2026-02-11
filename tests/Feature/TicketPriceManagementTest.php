<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TicketPriceManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_ticket_types_list()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $event = Event::factory()->create();

        $response = $this->actingAs($admin)->get(route('admin.events.ticket-types.index', $event));

        $response->assertStatus(200);
        $response->assertSee('Manage ticket tiers');
    }

    public function test_admin_can_create_ticket_type()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $event = Event::factory()->create();

        $ticketTypeData = [
            'name' => 'VIP Ticket',
            'description' => 'Access to VIP area',
            'price' => 150000,
            'quantity' => 100,
            'sale_start_date' => now()->toDateTimeString(),
            'sale_end_date' => now()->addDays(7)->toDateTimeString(),
        ];

        $response = $this->actingAs($admin)->post(route('admin.events.ticket-types.store', $event), $ticketTypeData);

        $response->assertRedirect(route('admin.events.ticket-types.index', $event));
        $this->assertDatabaseHas('ticket_types', [
            'event_id' => $event->id,
            'name' => 'VIP Ticket',
            'price' => 150000,
        ]);
    }

    public function test_validation_prevents_invalid_data()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $event = Event::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.events.ticket-types.store', $event), [
            'name' => '', // Required
            'price' => -100, // Must be positive
            'quantity' => 0, // Must be >= 1
        ]);

        $response->assertSessionHasErrors(['name', 'price', 'quantity']);
    }

    public function test_admin_can_update_ticket_type()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $event = Event::factory()->create();
        $ticketType = TicketType::factory()->create(['event_id' => $event->id]);

        $updateData = [
            'name' => 'Updated Name',
            'price' => 200000,
            'quantity' => 50,
            'description' => 'Updated Description',
        ];

        $response = $this->actingAs($admin)->put(route('admin.events.ticket-types.update', [$event, $ticketType]), $updateData);

        $response->assertRedirect(route('admin.events.ticket-types.index', $event));
        $this->assertDatabaseHas('ticket_types', [
            'id' => $ticketType->id,
            'name' => 'Updated Name',
            'price' => 200000,
        ]);
    }

    public function test_admin_can_delete_ticket_type()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $event = Event::factory()->create();
        $ticketType = TicketType::factory()->create(['event_id' => $event->id, 'sold' => 0]);

        $response = $this->actingAs($admin)->delete(route('admin.events.ticket-types.destroy', [$event, $ticketType]));

        $response->assertRedirect(route('admin.events.ticket-types.index', $event));
        $this->assertDatabaseMissing('ticket_types', ['id' => $ticketType->id]);
    }

    public function test_cannot_delete_ticket_type_with_sales()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $event = Event::factory()->create();
        $ticketType = TicketType::factory()->create(['event_id' => $event->id, 'sold' => 5]);

        $response = $this->actingAs($admin)->delete(route('admin.events.ticket-types.destroy', [$event, $ticketType]));

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('ticket_types', ['id' => $ticketType->id]);
    }

    public function test_user_cannot_access_ticket_management()
    {
        $user = User::factory()->create(['role' => 'user']);
        $event = Event::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.events.ticket-types.index', $event));

        $response->assertStatus(403); // Forbidden by middleware
    }
}
