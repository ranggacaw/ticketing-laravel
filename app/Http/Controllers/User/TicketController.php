<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function index()
    {
        $tab = request('tab', 'upcoming');
        $query = Auth::user()->tickets()->with('event');

        if ($tab === 'upcoming') {
            $query->whereHas('event', function ($q) {
                $q->where('start_time', '>=', now());
            });
        } elseif ($tab === 'past') {
            $query->whereHas('event', function ($q) {
                $q->where('start_time', '<', now());
            });
        }

        $tickets = $query->latest()->paginate(12)->withQueryString();
        return view('user.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        if (Auth::user()->cannot('view', $ticket)) {
            abort(403);
        }
        return view('user.tickets.show', compact('ticket'));
    }
}
