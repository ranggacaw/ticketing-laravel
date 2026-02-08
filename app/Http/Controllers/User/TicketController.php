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
        $tickets = Auth::user()->tickets()->latest()->paginate(12);
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
