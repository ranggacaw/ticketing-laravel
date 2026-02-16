<div>
    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search events...">
    
    @foreach($events as $event)
        <div>
            <h2>{{ $event->name }}</h2>
            <a href="{{ route('events.show', $event->slug) }}">View</a>
        </div>
    @endforeach
</div>
