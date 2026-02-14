<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Count of active tickets (not scanned)
        $activeTicketsCount = $user->tickets()->whereNull('scanned_at')->count();

        // Count of pending payments
        $pendingPaymentsCount = $user->payments()->where('status', 'pending')->count();

        // Recent tickets
        $recentTickets = $user->tickets()->latest()->take(3)->get();

        // Recent payments
        $recentPayments = $user->payments()->latest()->take(3)->get();

        // Loyalty Points
        $loyaltyPoints = $user->loyaltyPoints()->sum('points');

        // Latest Published Events
        $latestEvents = \App\Models\Event::published()->with(['venue', 'organizer'])->latest()->take(5)->get();

        return view('user.dashboard', compact('activeTicketsCount', 'pendingPaymentsCount', 'recentTickets', 'recentPayments', 'loyaltyPoints', 'latestEvents'));
    }
}
