<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\TicketType;
use Livewire\Component;

class TicketPurchase extends Component
{
    public Event $event;
    public array $quantities = [];
    public float $total = 0;

    public function mount(int $eventId)
    {
        $this->event = Event::findOrFail($eventId);
        foreach ($this->event->ticketTypes as $type) {
            $this->quantities[$type->id] = 0;
        }
    }

    public function updatedQuantities()
    {
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total = 0;
        foreach ($this->quantities as $typeId => $qty) {
            $type = TicketType::find($typeId);
            if ($type) {
                $this->total += $type->price * (int)$qty;
            }
        }
    }

    public function render()
    {
        return view('livewire.ticket-purchase');
    }
}
