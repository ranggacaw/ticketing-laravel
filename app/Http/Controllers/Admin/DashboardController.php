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
    public function index(Request $request)
    {
        $query = Ticket::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('user_name', 'like', '%' . $request->search . '%')
                  ->orWhere('user_email', 'like', '%' . $request->search . '%')
                  ->orWhere('uuid', 'like', '%' . $request->search . '%')
                  ->orWhere('barcode_data', 'like', '%' . $request->search . '%');
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

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $tickets = $query->latest()->paginate(10)->withQueryString();

        $totalTickets = Ticket::count();
        $validatedTickets = Ticket::whereNotNull('scanned_at')->count();
        $unvalidatedTickets = Ticket::whereNull('scanned_at')->count();
        $vvipTickets = Ticket::where('type', 'VVIP')->count();
        $vipTickets = Ticket::where('type', 'VIP')->count();
        $festivalTickets = Ticket::where('type', 'Festival')->count();
        $gaTickets = Ticket::where('type', 'General Admission')->count();
        $totalSales = Ticket::sum('price');

        $recentActivities = \App\Models\ActivityLog::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'tickets',
            'totalTickets',
            'validatedTickets',
            'unvalidatedTickets',
            'vvipTickets',
            'vipTickets',
            'festivalTickets',
            'gaTickets',
            'totalSales',
            'recentActivities'
        ));
    }
}
