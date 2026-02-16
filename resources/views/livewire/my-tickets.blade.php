<div>
    <h1>My Tickets</h1>
    @foreach($tickets as $ticket)
        <div>
            <h3>{{ $ticket->event->name }} - {{ $ticket->uuid }}</h3>
            <p>{{ $ticket->event->start_time }}</p>
        </div>
    @endforeach
</div>
