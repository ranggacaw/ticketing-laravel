<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Venue;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with(['venue', 'organizer'])->latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $venues = Venue::orderBy('name')->get();
        $organizers = Organizer::orderBy('name')->get();
        return view('admin.events.create', compact('venues', 'organizers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'venue_id' => 'required|exists:venues,id',
            'organizer_id' => 'required|exists:organizers,id',
            'status' => 'required|in:draft,published,cancelled,completed',
            'location' => 'nullable|string|max:255', // Fallback or override
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(6);

        // If location is not provided but venue is, maybe we can use venue name?
        // But let's leave location nullable as per schema if not filled.
        if (empty($validated['location']) && !empty($validated['venue_id'])) {
            $venue = Venue::find($validated['venue_id']);
            if ($venue) {
                $validated['location'] = $venue->city . ', ' . $venue->country;
            }
        }

        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        $event->load(['venue', 'organizer', 'ticketTypes']);
        return view('admin.events.show', compact('event'));
    }

    public function participants(Request $request, Event $event)
    {
        $query = $event->tickets()->with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('user_name', 'like', '%' . $search . '%')
                  ->orWhere('user_email', 'like', '%' . $search . '%')
                  ->orWhere('uuid', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'scanned') {
                $query->whereNotNull('scanned_at');
            } elseif ($request->status === 'unscanned') {
                $query->whereNull('scanned_at');
            }
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $participants = $query->latest()->paginate(20)->withQueryString();

        return view('admin.events.participants', compact('event', 'participants'));
    }

    public function edit(Event $event)
    {
        $venues = Venue::orderBy('name')->get();
        $organizers = Organizer::orderBy('name')->get();
        return view('admin.events.edit', compact('event', 'venues', 'organizers'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'venue_id' => 'required|exists:venues,id',
            'organizer_id' => 'required|exists:organizers,id',
            'status' => 'required|in:draft,published,cancelled,completed',
            'location' => 'nullable|string|max:255',
        ]);

        // Only update slug if name changes? Or keep it stable?
        // Usually slug should be stable, but if we want to allow updating it:
        if ($event->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(6);
        }

        if (empty($validated['location']) && !empty($validated['venue_id'])) {
            $venue = Venue::find($validated['venue_id']);
            if ($venue) {
                $validated['location'] = $venue->city . ', ' . $venue->country;
            }
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }
}
