@extends('user.layouts.app')

@section('content')
    <div class="min-h-screen -mx-4 md:mx-0 font-display">
        <!-- Header -->
        <x-page-header title="My Tickets" subtitle="All your upcoming and past events">
            <x-slot:bottom>
                <a href="{{ route('user.tickets.index', ['tab' => 'upcoming']) }}"
                    class="whitespace-nowrap px-4 py-2 {{ request('tab', 'upcoming') === 'upcoming' ? 'bg-primary-ref text-white shadow-sm shadow-red-100' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} text-sm font-medium rounded-full transition-all">
                    Upcoming
                </a>
                <a href="{{ route('user.tickets.index', ['tab' => 'past']) }}"
                    class="whitespace-nowrap px-4 py-2 {{ request('tab') === 'past' ? 'bg-primary-ref text-white shadow-sm shadow-red-100' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} text-sm font-medium rounded-full transition-all">
                    Past
                </a>
                <a href="{{ route('user.tickets.index', ['tab' => 'all']) }}"
                    class="whitespace-nowrap px-4 py-2 {{ request('tab') === 'all' ? 'bg-primary-ref text-white shadow-sm shadow-red-100' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} text-sm font-medium rounded-full transition-all">
                    All Tickets
                </a>
            </x-slot:bottom>
        </x-page-header>

        <main class="p-6 md:px-0">
            @if ($tickets->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($tickets as $ticket)
                        <div
                            class="group bg-white rounded-3xl overflow-hidden shadow-lg shadow-slate-200/50 hover:shadow-xl transition-all duration-300 border border-slate-100">
                            <!-- Ticket Header -->
                            <div class="relative h-32">
                                <div class="w-full h-full bg-slate-900 relative overflow-hidden">
                                    @if ($ticket->event?->banner_url)
                                        <img src="{{ $ticket->event->banner_url }}" alt="{{ $ticket->event->name }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="absolute inset-0 opacity-40 bg-gradient-to-br from-primary-ref to-slate-900">
                                        </div>
                                        <div class="absolute inset-0 flex items-center justify-center opacity-10">
                                            <span class="material-symbols-outlined text-8xl text-white">confirmation_number</span>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                </div>

                                <!-- Badge Type -->
                                <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full">
                                    <span class="text-[10px] font-bold text-primary-ref uppercase tracking-wider">{{ $ticket->type }}</span>
                                </div>

                                <!-- Date Tag -->
                                <div class="absolute bottom-4 left-4">
                                    <span class="text-white font-bold text-xs bg-primary-ref px-2 py-1 rounded shadow-sm">
                                        {{ $ticket->event?->start_time?->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-5">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex-1 pr-2">
                                        <h3 class="text-lg font-bold text-slate-900 leading-tight mb-1">
                                            {{ $ticket->event?->name }}
                                        </h3>
                                        <p class="text-sm text-slate-500 flex items-center">
                                            <span class="material-symbols-outlined text-sm mr-1">chair</span>
                                            Seat {{ $ticket->seat_number ?? 'General Admission' }}
                                        </p>
                                    </div>
                                    <div>
                                        @if ($ticket->scanned_at)
                                            <span class="px-3 py-1 bg-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider rounded-full border border-slate-200">Used</span>
                                        @elseif($ticket->payment_status === 'pending')
                                            <span class="px-3 py-1 bg-amber-50 text-amber-600 text-[10px] font-bold uppercase tracking-wider rounded-full border border-amber-100">Pending</span>
                                        @else
                                            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-wider rounded-full border border-emerald-100">Valid</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-center justify-between mb-6 pt-4 border-t border-slate-50">
                                    <div class="flex items-center text-xs text-slate-500 font-medium">
                                        <span class="material-symbols-outlined text-lg mr-1.5 text-primary-ref">fingerprint</span>
                                        <span class="font-mono text-[10px] opacity-70">{{ substr($ticket->uuid, 0, 8) }}...</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-lg font-black text-slate-900">
                                            Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>

                                <a href="{{ route('user.tickets.show', $ticket) }}"
                                    class="w-full py-4 bg-primary-ref text-white font-bold rounded-2xl hover:bg-red-700 transition-colors flex items-center justify-center space-x-2 shadow-lg shadow-red-100">
                                    <span>View Details</span>
                                    <span class="material-symbols-outlined text-sm">confirmation_number</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 px-4">
                    {{ $tickets->links() }}
                </div>
            @else
                <div class="text-center py-24 bg-white rounded-3xl border border-dashed border-slate-200">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-50 mb-6 group">
                        <span class="material-symbols-outlined text-4xl text-slate-300 group-hover:scale-110 transition-transform">confirmation_number_off</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">No tickets found</h3>
                    <p class="text-slate-500 mb-8 max-w-xs mx-auto">You haven't purchased any tickets yet. Catch the latest events before they're gone!</p>
                    <a href="{{ route('events.index') }}" 
                        class="inline-flex items-center space-x-3 px-8 py-4 bg-primary-ref text-white font-bold rounded-2xl hover:bg-red-700 transition-colors shadow-lg shadow-red-200">
                        <span>Browse Events</span>
                        <span class="material-symbols-outlined text-sm">explore</span>
                    </a>
                </div>
            @endif
        </main>
    </div>
@endsection