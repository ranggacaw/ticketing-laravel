<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPortalTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_access_dashboard()
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get(route('user.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('My Dashboard');
    }

    public function test_user_can_view_own_tickets()
    {
        $user = User::factory()->create(['role' => 'user']);
        $ticket = Ticket::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('user.tickets.index'));
        $response->assertStatus(200);
        $response->assertSee($ticket->seat_number);
    }

    public function test_user_cannot_view_others_tickets()
    {
        $user = User::factory()->create(['role' => 'user']);
        $otherUser = User::factory()->create(['role' => 'user']);
        $ticket = Ticket::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($user)->get(route('user.tickets.show', $ticket));
        $response->assertStatus(403);
    }
}
