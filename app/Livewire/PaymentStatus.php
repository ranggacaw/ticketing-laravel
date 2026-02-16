<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use Filament\Notifications\Notification;

class PaymentStatus extends Component
{
    public $ticketUuid;
    public $status = 'pending';
    public $message = 'Waiting for payment confirmation...';
    public $ticket;

    public function mount($ticketUuid)
    {
        $this->ticketUuid = $ticketUuid;
        $this->checkStatus();
    }
    
    public function checkStatus()
    {
        $this->ticket = Ticket::where('uuid', $this->ticketUuid)->with(['event', 'ticketType'])->first();
        
        if (!$this->ticket) {
            $this->status = 'error';
            $this->message = 'Ticket record not found.';
            return;
        }

        $this->status = $this->ticket->payment_status; // pending, paid, failed, cancelled

        if ($this->status === 'paid' || $this->status === 'confirmed') {
            $this->message = 'Payment Successful! Your tickets are ready.';
       
        } elseif ($this->status === 'failed') {
            $this->message = 'Payment Failed. Please try again.';
        } elseif ($this->status === 'cancelled') {
             $this->message = 'Payment Cancelled.';
        }
    }

    public function render()
    {
        return view('livewire.payment-status');
    }
}
