<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tickets = Ticket::latest()->paginate(10);
        $totalTickets = Ticket::count();
        $validatedTickets = Ticket::whereNotNull('scanned_at')->count();
        $unvalidatedTickets = Ticket::whereNull('scanned_at')->count();
        $vvipTickets = Ticket::where('type', 'VVIP')->count();
        $vipTickets = Ticket::where('type', 'VIP')->count();
        $festivalTickets = Ticket::where('type', 'Festival')->count();
        $gaTickets = Ticket::where('type', 'General Admission')->count();
        $totalSales = Ticket::sum('price');
        
        return view('admin.dashboard', compact(
            'tickets', 
            'totalTickets', 
            'validatedTickets', 
            'unvalidatedTickets', 
            'vvipTickets', 
            'vipTickets', 
            'festivalTickets', 
            'gaTickets', 
            'totalSales'
        ));
    }
}
