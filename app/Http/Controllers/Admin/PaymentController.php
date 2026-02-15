<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['user', 'bank'])
            ->orderByRaw("CASE WHEN status = 'pending' THEN 1 ELSE 2 END")
            ->latest()
            ->paginate(15);
            
        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['user', 'bank', 'tickets.ticketType', 'tickets.event']);
        return view('admin.payments.show', compact('payment'));
    }

    public function approve(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return back()->with('error', 'Payment is not pending.');
        }

        DB::transaction(function () use ($payment) {
            $payment->update([
                'status' => 'confirmed',
                'confirmed_at' => now(),
                'confirmed_by' => auth()->id(),
            ]);

            // Update associated tickets
            $payment->tickets()->update(['payment_status' => 'confirmed']);
        });

        return back()->with('success', 'Payment approved successfully.');
    }

    public function reject(Request $request, Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return back()->with('error', 'Payment is not pending.');
        }

        $request->validate([
            'rejection_reason' => 'required',
        ]);

        DB::transaction(function () use ($request, $payment) {
            $payment->update([
                'status' => 'cancelled',
                'rejection_reason' => $request->rejection_reason,
            ]);

            // Update associated tickets
            $payment->tickets()->update(['payment_status' => 'cancelled', 'status' => 'cancelled']);

            // Restore inventory
            foreach ($payment->tickets as $ticket) {
                // Assuming ticket type has inventory
                if($ticket->ticketType) {
                    $ticket->ticketType->decrement('sold');
                }
            }
        });

        return back()->with('success', 'Payment rejected and tickets cancelled.');
    }
}
