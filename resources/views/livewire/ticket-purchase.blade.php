<div>
    <h2>Purchase Tickets for {{ $event->name }}</h2>
    <form wire:submit.prevent="submit">
        @foreach($event->ticketTypes as $type)
            <div key="{{ $type->id }}">
                <label>{{ $type->name }} (${{ $type->price }})</label>
                <input type="number" wire:model.live="quantities.{{ $type->id }}" min="0">
            </div>
        @endforeach
        <div>Total: ${{ $total }}</div>
        <button type="submit">Buy Now</button>
    </form>
</div>
