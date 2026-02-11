@extends('layouts.public')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row justify-between items-end gap-4 border-b border-white/5 pb-6">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-white">Upcoming Events</h1>
                <p class="text-slate-400 mt-2">Discover and book tickets for the latest events.</p>
            </div>
            <!-- Search/Filter could go here -->
        </div>

        @if($events->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($events as $event)
                    <div
                        class="bg-slate-800/40 backdrop-blur-md border border-white/5 rounded-2xl overflow-hidden group hover:border-indigo-500/50 transition-all duration-300 shadow-xl">
                        <figure class="h-48 bg-slate-900 relative overflow-hidden">
                            <!-- Placeholder for event image until we have media support -->
                            <div
                                class="absolute inset-0 flex items-center justify-center text-white/5 bg-gradient-to-br from-indigo-500/10 to-cyan-500/10 group-hover:from-indigo-500/20 group-hover:to-cyan-500/20 transition-all duration-500">
                                <span
                                    class="text-6xl font-bold opacity-20 group-hover:scale-110 transition-transform duration-700">{{ \Illuminate\Support\Str::limit($event->name, 2, '') }}</span>
                            </div>
                        </figure>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-3">
                                <h2 class="text-xl font-bold text-white group-hover:text-indigo-400 transition-colors">
                                    <a href="{{ route('events.show', $event) }}">
                                        {{ $event->name }}
                                    </a>
                                </h2>
                                @if($event->start_time)
                                    <div
                                        class="px-2 py-1 bg-indigo-500/10 border border-indigo-500/20 rounded text-[10px] font-bold text-indigo-400 uppercase tracking-wider whitespace-nowrap">
                                        {{ $event->start_time->format('M d') }}
                                    </div>
                                @endif
                            </div>

                            <div class="text-sm text-slate-400 space-y-2 mb-4">
                                @if($event->venue)
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-400" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span>{{ $event->venue->name }}</span>
                                    </div>
                                @endif

                                @if($event->start_time)
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-400" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>{{ $event->start_time->format('h:i A') }}</span>
                                    </div>
                                @endif
                            </div>

                            <p class="text-sm text-slate-400 line-clamp-2 mb-6 h-10">
                                {{ \Illuminate\Support\Str::limit($event->description, 100) }}</p>

                            <div class="flex items-center justify-between pt-4 border-t border-white/5">
                                <div class="text-xs text-slate-500">
                                    {{ $event->ticketTypes->count() }} Ticket Types
                                </div>
                                <a href="{{ route('events.show', $event) }}"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-4 py-2 rounded-lg transition-all shadow-lg shadow-indigo-500/20">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $events->links() }}
            </div>
        @else
            <div class="hero min-h-[50vh] bg-base-200 rounded-box">
                <div class="hero-content text-center">
                    <div class="max-w-md">
                        <h1 class="text-2xl font-bold opacity-50">No Events Found</h1>
                        <p class="py-6 opacity-70">Check back later for upcoming events.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection