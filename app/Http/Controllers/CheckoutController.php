<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function store(\Illuminate\Http\Request $request, \App\Models\Event $event)
    {
        $validated = $request->validate([
            'ticket_type_id' => [
                'required',
                'exists:ticket_types,id',
                function ($attribute, $value, $fail) use ($event) {
                    $type = \App\Models\TicketType::find($value);
                    if ($type->event_id !== $event->id) {
                        $fail('The selected ticket type does not belong to this event.');
                    }
                    if (!$type->isAvailable()) {
                        $fail('This ticket type is no longer available.');
                    }
                },
            ],
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        try {
            $ticketType = \App\Models\TicketType::findOrFail($validated['ticket_type_id']);
            $quantity = $validated['quantity'];

            $firstTicket = \Illuminate\Support\Facades\DB::transaction(function () use ($ticketType, $quantity, $event) {
                // Lock the ticket type row
                $lockedType = \App\Models\TicketType::where('id', $ticketType->id)->lockForUpdate()->first();

                if ($lockedType->sold + $quantity > $lockedType->quantity) {
                    throw new \Exception('Not enough tickets available.');
                }

                $tickets = [];
                for ($i = 0; $i < $quantity; $i++) {
                    $ticket = \App\Models\Ticket::create([
                        'event_id' => $event->id,
                        'ticket_type_id' => $lockedType->id,
                        'user_id' => auth()->id(),
                        'price' => $lockedType->price,
                        'status' => 'issued', // Assume immediate success for MVP
                        'payment_status' => 'confirmed',
                        'user_name' => auth()->user()->name,
                        'user_email' => auth()->user()->email,
                        'type' => $lockedType->name,
                        'seat_number' => 'General Admission',
                    ]);
                    $tickets[] = $ticket;
                }

                $lockedType->sold += $quantity;
                $lockedType->save();

                return $tickets[0];
            });

            return redirect()->route('checkout.success', ['ticket' => $firstTicket->uuid])
                ->with('success', 'Tickets purchased successfully!');

        } catch (\Exception $e) {
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
