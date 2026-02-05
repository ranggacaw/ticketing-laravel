<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TicketController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function scan()
    {
        return view('scan');
    }

    public function validateTicket(Request $request)
    {
        $code = strtoupper($request->input('code'));
        
        // Simulate loading/processing latency
        usleep(300000); // 300ms

        $ticket = Ticket::where('barcode_data', $code)
            ->orWhere('uuid', $code)
            ->first();

        if ($ticket) {
            if ($ticket->scanned_at) {
                return redirect()->route('result', ['status' => 'duplicate', 'code' => $code]);
            }
            
            // Mark as scanned
            $ticket->update(['scanned_at' => Carbon::now()]);
            
            return redirect()->route('result', ['status' => 'valid', 'code' => $code]);
        }

        return redirect()->route('result', ['status' => 'invalid', 'code' => $code]);
    }

    public function result(Request $request, $status)
    {
        $code = $request->query('code');
        $ticket = Ticket::where('barcode_data', $code)
            ->orWhere('uuid', $code)
            ->first();

        // If ticket not found but status implies it should be, fallback to invalid
        if (!$ticket && in_array($status, ['valid', 'duplicate'])) {
            $status = 'invalid';
        }

        return view('result', compact('status', 'ticket', 'code'));
    }
}
