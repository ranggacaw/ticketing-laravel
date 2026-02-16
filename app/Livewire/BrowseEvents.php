<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;

class BrowseEvents extends Component
{
    public $search = '';

    public function render()
    {
        $events = Event::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->where('status', 'published')
            ->get();

        return view('livewire.browse-events', compact('events'));
    }
}
