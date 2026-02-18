<div>
    <h1>{{ $event->name }}</h1>
    <p>{{ $event->description }}</p>
    <div>
        @foreach($event->ticketTypes as $ticketType)
            <div>{{ $ticketType->name }} - Rp {{ number_format($ticketType->price, 0, ',', '.') }}</div>
        @endforeach
    </div>
</div>