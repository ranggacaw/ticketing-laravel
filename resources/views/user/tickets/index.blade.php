@extends('user.layouts.app')

@section('header', 'My Tickets')
@section('subheader', 'All your upcoming and past events')

@section('content')
    <div class="tabs tabs-boxed bg-base-100 mb-6 w-fit">
        <a href="{{ route('user.tickets.index', ['tab' => 'upcoming']) }}"
            class="tab {{ request('tab', 'upcoming') === 'upcoming' ? 'tab-active bg-primary text-white' : 'text-base-content/60' }}">Upcoming</a>
        <a href="{{ route('user.tickets.index', ['tab' => 'past']) }}"
            class="tab {{ request('tab') === 'past' ? 'tab-active bg-primary text-white' : 'text-base-content/60' }}">Past</a>
        <a href="{{ route('user.tickets.index', ['tab' => 'all']) }}"
            class="tab {{ request('tab') === 'all' ? 'tab-active bg-primary text-white' : 'text-base-content/60' }}">All
            Tickets</a>
    </div>

    @if($tickets->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($tickets as $ticket)
                <div
                    class="bg-base-100 border border-base-300 rounded-xl overflow-hidden group hover:shadow-lg transition-all duration-300">
                    <!-- Ticket Header/Image placeholder -->
                    <div class="h-24 bg-gradient-to-br from-red-600 to-red-800 relative p-4 flex flex-col justify-end">
                        <div
                            class="absolute top-0 left-0 w-full h-full opacity-30 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-white via-transparent to-transparent">
                        </div>
                        <span
                            class="relative z-10 text-xs font-bold text-white uppercase tracking-wider bg-black/30 px-2 py-1 rounded w-max backdrop-blur-sm border border-white/10">{{ $ticket->type }}</span>
                        <h4 class="relative z-10 text-white font-bold mt-2">{{ $ticket->event?->name }}</h4>
                        <p class="relative z-10 text-red-100 text-xs">{{ $ticket->event?->start_time?->format('M d, Y') }}</p>
                    </div>

                    <div class="p-5">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-base-content mb-1">Seat {{ $ticket->seat_number }}</h3>
                                <p class="text-sm text-base-content/60">UUID: {{ substr($ticket->uuid, 0, 8) }}...</p>
                            </div>
                            @if($ticket->scanned_at)
                                <span class="px-2 py-1 bg-base-200 text-base-content/60 text-xs rounded-full">Used</span>
                            @elseif($ticket->payment_status === 'pending')
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Payment Pending</span>
                            @else
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Valid</span>
                            @endif
                        </div>

                        <div class="space-y-3 mb-6">
                            <div class="flex items-center text-sm text-base-content/70">
                                <svg class="w-4 h-4 mr-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                                Rp {{ number_format($ticket->price, 0, ',', '.') }}
                            </div>
                        </div>

                        <a href="{{ route('user.tickets.show', $ticket) }}"
                            class="block w-full py-2 text-center rounded-lg bg-base-200 hover:bg-base-300 text-base-content font-medium transition-colors">
                            View Ticket
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $tickets->links() }}
        </div>
    @else
        <div class="text-center py-20">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-base-200 mb-4">
                <svg class="w-8 h-8 text-base-content/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                    </path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-base-content mb-2">No tickets found</h3>
            <p class="text-base-content/60 mb-6">You haven't purchased any tickets yet.</p>
            <a href="{{ route('events.index') }}" class="btn btn-primary">
                Browse Events
            </a>
        </div>
    @endif
@endsection