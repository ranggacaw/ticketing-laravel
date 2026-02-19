<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Payment;
use App\Models\Ticket;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'tickets' => 'required|array',
            'tickets.*' => 'integer|min:0',
            'bank_id' => 'required|exists:banks,id',
            'sender_account_name' => 'required|string|max:255',
            'sender_account_number' => 'required|string|max:50',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Filter out tickets with 0 quantity
        $selectedTickets = array_filter($validated['tickets'], function ($quantity) {
            return $quantity > 0;
        });

        if (empty($selectedTickets)) {
            return back()->with('error', 'Please select at least one ticket.');
        }

        try {
            // Calculate total amount and validate tickets
            $totalAmount = 0;
            $ticketTypesToProcess = [];

            foreach ($selectedTickets as $ticketTypeId => $quantity) {
                $ticketType = TicketType::find($ticketTypeId);

                if (!$ticketType || $ticketType->event_id !== $event->id) {
                    throw new \Exception("Invalid ticket type selected.");
                }

                if (!$ticketType->isAvailable()) {
                    throw new \Exception("Ticket type '{$ticketType->name}' is no longer available.");
                }

                $totalAmount += $ticketType->price * $quantity;
                $ticketTypesToProcess[$ticketTypeId] = [
                    'type' => $ticketType,
                    'quantity' => $quantity
                ];
            }

            // Handle File Upload
            $paymentProof = $request->file('payment_proof');
            $tempPath = $paymentProof->getRealPath() ?: $paymentProof->getPathname();
            $proofPath = Storage::disk('public')->putFileAs(
                'payment-proofs',
                $tempPath,
                $paymentProof->hashName()
            );

            $firstTicket = DB::transaction(function () use ($ticketTypesToProcess, $event, $validated, $totalAmount, $proofPath) {

                // Create Payment Record
                $payment = Payment::create([
                    'user_id' => auth()->id(),
                    'bank_id' => $validated['bank_id'],
                    'invoice_number' => 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(6)),
                    'amount' => $totalAmount,
                    'status' => 'pending',
                    'payment_proof_url' => $proofPath,
                    'sender_account_name' => $validated['sender_account_name'],
                    'sender_account_number' => $validated['sender_account_number'],
                ]);

                $allCreatedTickets = [];

                foreach ($ticketTypesToProcess as $item) {
                    $quantity = $item['quantity'];
                    // Lock the ticket type row to ensure inventory consistency
                    $lockedType = TicketType::where('id', $item['type']->id)->lockForUpdate()->first();

                    if ($lockedType->sold + $quantity > $lockedType->quantity) {
                        throw new \Exception("Not enough tickets available for '{$lockedType->name}'.");
                    }

                    for ($i = 0; $i < $quantity; $i++) {
                        $ticket = Ticket::create([
                            'event_id' => $event->id,
                            'ticket_type_id' => $lockedType->id,
                            'user_id' => auth()->id(),
                            'price' => $lockedType->price,
                            'status' => 'issued',
                            'payment_status' => 'pending', // Pending admin approval
                            'user_name' => auth()->user()->name,
                            'user_email' => auth()->user()->email,
                            'type' => $lockedType->name,
                            'seat_number' => 'General Admission',
                        ]);

                        // Link to Payment
                        $payment->tickets()->attach($ticket->id);
                        $allCreatedTickets[] = $ticket;
                    }

                    // Update sold count
                    $lockedType->sold += $quantity;
                    $lockedType->save();
                }

                return $allCreatedTickets[0];
            });

            return redirect()->route('checkout.success', ['ticket' => $firstTicket->uuid])
                ->with('success', 'Order placed successfully! Please wait for payment confirmation.');

        } catch (\Exception $e) {
            // Cleanup uploaded file if transaction fails
            if (isset($proofPath) && Storage::disk('public')->exists($proofPath)) {
                Storage::disk('public')->delete($proofPath);
            }
            return back()->with('error', 'Purchase failed: ' . $e->getMessage());
        }
    }

    public function success(\App\Models\Ticket $ticket)
    {
        if ($ticket->user_id !== auth()->id()) {
            abort(403);
        }

        // Load related tickets purchased at the same time? 
        // For MVP, just show this one or we can query by created_at proximity.
        // Or better, just show the single ticket success.

        $ticket->load(['event.venue', 'ticketType']);
        return view('checkout.success', compact('ticket'));
    }
}
