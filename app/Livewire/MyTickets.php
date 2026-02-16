<?php

namespace App\Livewire;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyTickets extends Component
{
    public function render()
    {
        $tickets = Ticket::where('user_id', Auth::id())->with('event')->get();

        return view('livewire.my-tickets', compact('tickets'));
    }
}
