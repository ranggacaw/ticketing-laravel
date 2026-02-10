<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $ticket = Ticket::findOrFail($validated['ticket_id']);

        // Check ownership
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if event is past (optional, but good practice per spec)
        if ($ticket->event && $ticket->event->start_time > now()) {
            return back()->with('error', 'You can only review past events.');
        }

        // Check if already reviewed (testimonial exists for this ticket)
        if ($ticket->testimonial) {
            return back()->with('error', 'You have already reviewed this ticket.');
        }

        Testimonial::create([
            'user_id' => Auth::id(),
            'ticket_id' => $ticket->id,
            'event_id' => $ticket->event_id, // Assuming ticket has event_id (which I added)
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        // Award Loyalty Points
        \App\Models\LoyaltyPoint::create([
            'user_id' => Auth::id(),
            'points' => 10,
            'reason' => 'Wrote a review for ticket #' . $ticket->id,
        ]);

        return back()->with('status', 'testimonial-submitted');
    }
}
