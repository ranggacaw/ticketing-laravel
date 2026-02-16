<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;

class TicketDetail extends Component
{
    public Event $event;

    public function mount(string $slug)
    {
        $this->event = Event::where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.ticket-detail');
    }
}
