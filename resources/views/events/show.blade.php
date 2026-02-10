@extends('layouts.public')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Event Details (Left Column) -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Hero / Image -->
            <div
                class="rounded-2xl overflow-hidden bg-slate-900 h-64 md:h-96 relative flex items-center justify-center border border-white/5 shadow-2xl group">
                <!-- Placeholder -->
                <div
                    class="bg-gradient-to-br from-indigo-500/10 to-purple-500/10 absolute inset-0 group-hover:from-indigo-500/20 group-hover:to-purple-500/20 transition-all duration-700">
                </div>
                <h1
                    class="text-4xl md:text-5xl font-bold text-white/5 select-none z-10 group-hover:scale-110 transition-transform duration-1000">
                    {{ $event->name }}</h1>
                @if($event->start_time)
                    <div
                        class="absolute top-6 left-6 px-4 py-2 bg-slate-900/80 backdrop-blur-md border border-white/10 rounded-xl text-xs font-bold text-white uppercase tracking-[0.2em]">
                        {{ $event->start_time->format('M d, Y') }}
                    </div>
                @endif
            </div>

            <!-- Title & Basic Info -->
            <div class="space-y-4">
                <h1 class="text-3xl md:text-5xl font-bold text-white tracking-tight">{{ $event->name }}</h1>
                <div class="flex flex-wrap gap-6 text-slate-400">
                    @if($event->start_time)
                        <div class="flex items-center gap-2">
                            <div class="p-2 bg-indigo-500/10 rounded-lg text-indigo-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="font-medium">{{ $event->start_time->format('l, F j, Y • h:i A') }}</span>
                        </div>
                    @endif
                    @if($event->venue)
                        <div class="flex items-center gap-2">
                            <div class="p-2 bg-cyan-500/10 rounded-lg text-cyan-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <span class="font-medium">{{ $event->venue->name }} - {{ $event->venue->city }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Description -->
            <div class="bg-slate-800/30 backdrop-blur-md border border-white/5 rounded-2xl p-8">
                <h3 class="text-xl font-bold text-white mb-4">About this Event</h3>
                <div class="text-slate-400 leading-relaxed whitespace-pre-line">
                    {{ $event->description }}
                </div>
            </div>

            <!-- Organizer Info -->
            @if($event->organizer)
                <div
                    class="bg-slate-800/20 border border-white/5 rounded-2xl p-6 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-2xl flex items-center justify-center text-white text-xl font-bold shadow-lg">
                            {{ substr($event->organizer->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-widest font-bold mb-1">Organized by</p>
                            <p class="text-lg font-bold text-white">{{ $event->organizer->name }}</p>
                        </div>
                    </div>
                    <button
                        class="px-6 py-2 bg-white/5 hover:bg-white/10 text-white rounded-xl text-sm font-bold transition-all border border-white/5">
                        Follow Organizer
                    </button>
                </div>
            @endif
        </div>

        <!-- Ticket Selection (Right Column / Sticky Sidebar) -->
        <div class="lg:col-span-1">
            <div
                class="bg-slate-800/50 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl sticky top-28 overflow-hidden">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-white mb-6">Get Tickets</h2>

                    @if($event->ticketTypes->isEmpty())
                        <div class="bg-amber-500/10 border border-amber-500/20 rounded-xl p-4 flex gap-3 text-amber-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <span class="text-sm font-medium">No tickets available yet.</span>
                        </div>
                    @else
                        <form action="{{ route('events.checkout', $event) }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="space-y-3">
                                @foreach($event->ticketTypes as $ticketType)
                                    <label class="block relative cursor-pointer group">
                                        <input type="radio" name="ticket_type_id" value="{{ $ticketType->id }}" class="peer sr-only"
                                            {{ !$ticketType->isAvailable() ? 'disabled' : '' }} required />
                                        <div
                                            class="p-4 bg-slate-900/50 border border-white/5 rounded-xl transition-all peer-checked:border-indigo-500 peer-checked:bg-indigo-500/10 hover:bg-slate-900 {{ !$ticketType->isAvailable() ? 'opacity-50 grayscale' : '' }}">
                                            <div class="flex justify-between items-baseline mb-1">
                                                <span class="font-bold text-white">{{ $ticketType->name }}</span>
                                                <span
                                                    class="font-bold text-indigo-400">${{ number_format($ticketType->price, 2) }}</span>
                                            </div>
                                            <p
                                                class="text-xs text-slate-500 line-clamp-1 group-hover:line-clamp-none transition-all">
                                                {{ $ticketType->description }}</p>
                                            @if(!$ticketType->isAvailable())
                                                <div class="mt-2 text-[10px] uppercase font-bold text-red-400">Sold Out</div>
                                            @endif

                                            <!-- Checkmark icon for selected state -->
                                            <div
                                                class="absolute top-4 right-4 text-indigo-500 opacity-0 peer-checked:opacity-100 transition-opacity">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-400 block ml-1">Quantity</label>
                                <select
                                    class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all appearance-none"
                                    name="quantity">
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}">{{ $i }} {{ $i > 1 ? 'Tickets' : 'Ticket' }}</option>
                                    @endfor
                                </select>
                            </div>

                            <button type="submit"
                                class="w-full py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/25 transition-all transform active:scale-[0.98]">
                                Buy Tickets Now
                            </button>

                            <p class="text-[10px] text-center text-slate-500">
                                Secure checkout with encrypted payment processing.
                            </p>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection