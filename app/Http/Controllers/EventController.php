<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = \App\Models\Event::published()->latest()->paginate(9);
        return view('events.index', compact('events'));
    }

    public function show(\App\Models\Event $event)
    {
        abort_unless($event->status === 'published', 404);
        $event->load(['venue', 'ticketTypes', 'organizer']);
        return view('events.show', compact('event'));
    }
}
