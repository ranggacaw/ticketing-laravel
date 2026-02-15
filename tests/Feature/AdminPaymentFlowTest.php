<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Payment;
use App\Models\TicketType;
use App\Models\Bank;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;

class AdminPaymentFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_payment_list()
    {
        $admin = User::factory()->create(['role' => 'admin', 'name' => 'Admin User']);
        $bank = Bank::create(['name' => 'BCA', 'account_number' => '123', 'account_name' => 'PT Test', 'code' => 'BCA001']);

        $payment = Payment::create([
            'user_id' => $admin->id,
            'amount' => 100000,
            'status' => 'pending',
            'payment_method' => 'bank_transfer',
            'invoice_number' => 'INV-TEST-001',
            'sender_account_name' => 'John Doe',
            'sender_account_number' => '1234567890',
            'bank_id' => $bank->id,
            'payment_proof_url' => 'proofs/test.jpg'
        ]);

        $response = $this->actingAs($admin)->from(route('admin.payments.index'))->get(route('admin.payments.index'));

        $response->assertStatus(200);
        $response->assertSee('Admin User');
        $response->assertSee('INV-TEST-001');
    }

    public function test_admin_can_approve_payment()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        $bank = Bank::create(['name' => 'BCA', 'account_number' => '123', 'account_name' => 'PT Test', 'code' => 'BCA002']);
        
        $event = Event::factory()->create();
        $ticketType = TicketType::factory()->create(['event_id' => $event->id, 'price' => 50000]);

        // Create Payment
        $payment = Payment::create([
            'user_id' => $user->id,
            'amount' => 50000,
            'status' => 'pending',
            'payment_method' => 'bank_transfer',
            'invoice_number' => 'INV-TEST-APPROVE',
            'sender_account_name' => 'Jane Doe',
            'sender_account_number' => '987654321',
            'bank_id' => $bank->id,
            'payment_proof_url' => 'proofs/approve.jpg'
        ]);

        // Create Ticket linked to payment
        $ticket = Ticket::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'ticket_type_id' => $ticketType->id,
            'uuid' => 'uuid-test-approve',
            'barcode_data' => 'barcode-test-approve',
            'price' => 50000,
            'status' => 'issued',
            'payment_status' => 'pending',
            'user_name' => 'Jane Doe',
            'user_email' => 'jane@example.com'
        ]);

        $payment->tickets()->attach($ticket->id);

        $response = $this->actingAs($admin)->post(route('admin.payments.approve', $payment));

        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => 'confirmed',
        ]);

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'payment_status' => 'confirmed',
        ]);
    }

    public function test_admin_can_reject_payment_and_restore_inventory()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        $bank = Bank::create(['name' => 'BCA', 'account_number' => '123', 'account_name' => 'PT Test', 'code' => 'BCA003']);
        
        $event = Event::factory()->create();
        $ticketType = TicketType::factory()->create([
            'event_id' => $event->id, 
            'price' => 50000,
            'quantity' => 100,
            'sold' => 10
        ]);

        // Create Payment
        $payment = Payment::create([
            'user_id' => $user->id,
            'amount' => 50000,
            'status' => 'pending',
            'payment_method' => 'bank_transfer',
            'invoice_number' => 'INV-TEST-REJECT',
            'sender_account_name' => 'Reject Doe',
            'sender_account_number' => '987654321',
            'bank_id' => $bank->id,
            'payment_proof_url' => 'proofs/reject.jpg'
        ]);

        // Create Ticket linked to payment
        $ticket = Ticket::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'ticket_type_id' => $ticketType->id,
            'uuid' => 'uuid-test-reject',
            'barcode_data' => 'barcode-test-reject',
            'price' => 50000,
            'status' => 'issued',
            'payment_status' => 'pending',
            'user_name' => 'Reject Doe',
            'user_email' => 'reject@example.com'
        ]);

        $payment->tickets()->attach($ticket->id);

        $response = $this->actingAs($admin)->post(route('admin.payments.reject', $payment), [
            'rejection_reason' => 'Invalid proof'
        ]);

        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => 'cancelled',
            'rejection_reason' => 'Invalid proof'
        ]);

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'status' => 'cancelled',
            'payment_status' => 'cancelled',
        ]);

        // Verify inventory restored (sold should decrease)
        $this->assertDatabaseHas('ticket_types', [
            'id' => $ticketType->id,
            'sold' => 9 // Started at 10, should be 9
        ]);
    }
}
