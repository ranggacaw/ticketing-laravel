<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use Carbon\Carbon;
use Filament\Notifications\Notification;

class TicketScanner extends Component
{
    public $barcode_input = '';
    public $scan_result = null; // { 'status' => 'success'|'error', 'message' => '...', 'ticket' => ... }
    public $recent_scans = [];

    public function mount()
    {
        // Load recent scans from session if desired, or keep it per-component lifecycle
    }

    public function scan()
    {
        $this->validate([
            'barcode_input' => 'required|string|min:3',
        ]);

        $code = trim($this->barcode_input);
        
        // Find ticket
        $ticket = Ticket::where('uuid', $code)
            ->orWhere('barcode_data', $code)
            ->orWhere('secure_token', $code)
            ->first();

        if (!$ticket) {
            $this->scan_result = [
                'status' => 'error',
                'message' => 'Ticket not found.',
                'code' => $code,
            ];
            $this->notifyError("Ticket not found: $code");
            $this->barcode_input = '';
            return;
        }

        // Check already scanned
        if ($ticket->status === 'scanned' || $ticket->scanned_at) {
            $scannedAt = $ticket->scanned_at ? $ticket->scanned_at->format('H:i:s d/m') : 'Unknown';
            $this->scan_result = [
                'status' => 'error',
                'message' => "Already scanned at $scannedAt",
                'ticket' => $ticket,
            ];
            $this->notifyError("Already scanned!");
            
            // Add to history even if failed
            array_unshift($this->recent_scans, [
                'time' => now()->format('H:i:s'),
                'code' => $code,
                'status' => 'error',
                'message' => 'Duplicate Scan',
                'ticket_id' => $ticket->id,
            ]);
            
            $this->barcode_input = '';
            return;
        }
        
        // Is ticket valid otherwise? (e.g. cancelled)
        if ($ticket->payment_status !== 'paid' && $ticket->payment_status !== 'free') {
             $this->scan_result = [
                'status' => 'error',
                'message' => "Payment Status: {$ticket->payment_status}",
                'ticket' => $ticket,
            ];
            $this->notifyError("Payment invalid: {$ticket->payment_status}");
             array_unshift($this->recent_scans, [
                'time' => now()->format('H:i:s'),
                'code' => $code,
                'status' => 'error',
                'message' => 'Payment Invalid',
                'ticket_id' => $ticket->id,
            ]);
            $this->barcode_input = '';
            return;
        }

        // Valid scan
        $ticket->update([
            'status' => 'scanned',
            'scanned_at' => now(),
        ]);

        $this->scan_result = [
            'status' => 'success',
            'message' => 'Valid Ticket',
            'ticket' => $ticket,
        ];
        
        $this->notifySuccess("Valid Ticket: {$ticket->ticketType->name}");

        array_unshift($this->recent_scans, [
            'time' => now()->format('H:i:s'),
            'code' => $code,
            'status' => 'success',
            'message' => 'Valid Scan',
            'ticket_id' => $ticket->id,
            'attendee' => $ticket->user->name ?? $ticket->user_name,
            'type' => $ticket->ticketType->name ?? 'N/A',
        ]);

        // Keep only last 10
        $this->recent_scans = array_slice($this->recent_scans, 0, 10);
        
        $this->barcode_input = '';
    }

    protected function notifyError($message)
    {
        // Use Filament notification if available, or session flash
        // Since we are in Livewire context, we can emit or dispatch event.
        // Assuming we have Filament installed, let's try using its notification
        if (class_exists(Notification::class)) {
            Notification::make()
                ->title('Scan Error')
                ->body($message)
                ->danger()
                ->send();
        } else {
            session()->flash('error', $message);
        }
    }

    protected function notifySuccess($message)
    {
        if (class_exists(Notification::class)) {
            Notification::make()
                ->title('Scan Successful')
                ->body($message)
                ->success()
                ->send();
        } else {
             session()->flash('success', $message);
        }
    }

    public function render()
    {
        return view('livewire.ticket-scanner');
    }
}
