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
            'ticket_type_id' => [
                'required',
                'exists:ticket_types,id',
                function ($attribute, $value, $fail) use ($event) {
                    $type = TicketType::find($value);
                    if ($type->event_id !== $event->id) {
                        $fail('The selected ticket type does not belong to this event.');
                    }
                    if (!$type->isAvailable()) {
                        $fail('This ticket type is no longer available.');
                    }
                },
            ],
            'quantity' => 'required|integer|min:1|max:10',
            'bank_id' => 'required|exists:banks,id',
            'sender_account_name' => 'required|string|max:255',
            'sender_account_number' => 'required|string|max:50',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        try {
            $ticketType = TicketType::findOrFail($validated['ticket_type_id']);
            $quantity = $validated['quantity'];
            $totalAmount = $ticketType->price * $quantity;

            // Handle File Upload
            $proofPath = $request->file('payment_proof')->store('payment-proofs', 'public');

            $firstTicket = DB::transaction(function () use ($ticketType, $quantity, $event, $validated, $totalAmount, $proofPath) {
                // Lock the ticket type row
                $lockedType = TicketType::where('id', $ticketType->id)->lockForUpdate()->first();

                if ($lockedType->sold + $quantity > $lockedType->quantity) {
                    throw new \Exception('Not enough tickets available.');
                }

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

                $tickets = [];
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
                        'seat_number' => 'General Admission', // Or iterate seat assignment if needed
                    ]);
                    
                    // Link to Payment
                    $payment->tickets()->attach($ticket->id); // Payment model needs tickets relationship

                    $tickets[] = $ticket;
                }

                $lockedType->sold += $quantity;
                $lockedType->save();

                return $tickets[0];
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
