<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Http\Request;

class TicketTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        $ticketTypes = $event->ticketTypes()->latest()->paginate(10);
        return view('admin.events.ticket_types.index', compact('event', 'ticketTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Event $event)
    {
        return view('admin.events.ticket_types.create', compact('event'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\App\Http\Requests\StoreTicketPriceRequest $request, Event $event)
    {
        $event->ticketTypes()->create($request->validated());

        return redirect()->route('admin.events.ticket-types.index', $event)
            ->with('success', 'Ticket type created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event, TicketType $ticketType)
    {
        // Not really needed as index shows list, but for completeness or details view
        return view('admin.events.ticket_types.show', compact('event', 'ticketType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event, TicketType $ticketType)
    {
        return view('admin.events.ticket_types.edit', compact('event', 'ticketType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\App\Http\Requests\UpdateTicketPriceRequest $request, Event $event, TicketType $ticketType)
    {
        $ticketType->update($request->validated());

        return redirect()->route('admin.events.ticket-types.index', $event)
            ->with('success', 'Ticket type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, TicketType $ticketType)
    {
        if ($ticketType->sold > 0) {
            return back()->with('error', 'Cannot delete ticket type that has sold tickets.');
        }

        $ticketType->delete();

        return redirect()->route('admin.events.ticket-types.index', $event)
            ->with('success', 'Ticket type deleted successfully.');
    }
}
