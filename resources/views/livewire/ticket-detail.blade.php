<div>
    <h1>{{ $event->name }}</h1>
    <p>{{ $event->description }}</p>
    <div>
        @foreach($event->ticketTypes as $ticketType)
            <div>{{ $ticketType->name }} - {{ $ticketType->price }}</div>
        @endforeach
    </div>
</div>
