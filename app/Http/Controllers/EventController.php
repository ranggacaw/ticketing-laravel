<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Event::published()->latest();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category != 'All Events') {
            $query->where('category', $request->category);
        }

        $events = $query->paginate(9);

        $categories = \App\Models\Event::published()
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        return view('events.index', compact('events', 'categories'));
    }

    public function show(\App\Models\Event $event)
    {
        // Redirect admin/staff to admin area if they try to access user-side page
        if (auth()->check() && in_array(auth()->user()->role, ['admin', 'staff'])) {
            return redirect()->route('admin.events.show', $event);
        }

        abort_unless($event->status === 'published', 404);

        $event->load(['venue', 'ticketTypes', 'organizer']);
        $banks = \App\Models\Bank::active()->get();
        return view('events.show', compact('event', 'banks'));
    }
}
