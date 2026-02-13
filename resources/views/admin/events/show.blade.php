@extends('layouts.admin')

@section('content')
    <div class="space-y-8 animate-in fade-in duration-700">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 sm:gap-6">
            <div>
                <a href="{{ route('admin.events.index') }}"
                    class="group inline-flex items-center text-sm text-slate-500 hover:text-indigo-400 mb-2 transition-colors">
                    <svg class="w-4 h-4 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Events
                </a>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">{{ $event->name }}</h2>
                <div class="flex items-center gap-4 text-slate-400 mt-1 font-light text-sm">
                    <div class="flex items-center gap-1">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>{{ $event->start_time?->format('M d, Y') ?? 'Not Set' }}</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>{{ $event->venue ? $event->venue->name : $event->location }}</span>
                    </div>
                </div>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('events.show', $event) }}" target="_blank"
                    class="inline-flex items-center justify-center gap-2 bg-slate-100 hover:bg-slate-200   text-slate-700  font-semibold py-2.5 px-5 rounded-xl transition-all duration-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    <span>Preview</span>
                </a>
                <a href="{{ route('admin.events.edit', $event) }}"
                    class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-2.5 px-5 rounded-xl shadow-lg shadow-indigo-600/20 transition-all duration-300 transform hover:scale-[1.02] active:scale-95">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Edit Details</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Details Card -->
                <div class="glass-card p-6 sm:p-8 rounded-3xl border-black/5  shadow-sm">
                    <h3 class="text-lg font-semibold text-slate-900  mb-4">About Event</h3>
                    <div class="prose  max-w-none text-slate-600 ">
                        <p class="whitespace-pre-line">{{ $event->description }}</p>
                    </div>
                </div>

                <!-- Ticket Types Placeholder (Next Task) -->
                <div
                    class="glass-card p-6 sm:p-8 rounded-3xl border-black/5  shadow-sm flex flex-col items-center justify-center min-h-[200px] text-center">
                    <div
                        class="w-12 h-12 bg-indigo-50  rounded-full flex items-center justify-center text-indigo-500 mb-3">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-slate-900 ">Ticket Types</h3>
                    <p class="text-slate-500 text-sm mt-1 max-w-sm">Define pricing tiers and ticket availability.</p>
                    <div class="mt-4">
                        <a href="{{ route('admin.events.ticket-types.index', $event) }}"
                            class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium bg-indigo-50 text-indigo-700   hover:bg-indigo-100  transition-colors">
                            Manage Ticket Types
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Status Card -->
                <div class="glass-card p-6 rounded-3xl border-black/5  shadow-sm">
                    <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-4">Status</h3>
                    @php
                        $statusClasses = match ($event->status) {
                            'published' => 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20',
                            'draft' => 'bg-slate-500/10 text-slate-500 border-slate-500/20',
                            'cancelled' => 'bg-rose-500/10 text-rose-500 border-rose-500/20',
                            'completed' => 'bg-indigo-500/10 text-indigo-500 border-indigo-500/20',
                            default => 'bg-slate-500/10 text-slate-500 border-slate-500/20',
                        };
                    @endphp
                    <div class="flex items-center justify-between">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border {{ $statusClasses }}">
                            {{ ucfirst($event->status) }}
                        </span>
                        <span class="text-xs text-slate-400">Created {{ $event->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                <!-- Organizer Card -->
                <div class="glass-card p-6 rounded-3xl border-black/5  shadow-sm">
                    <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-4">Organizer</h3>
                    @if($event->organizer)
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-indigo-500/10 flex items-center justify-center text-indigo-500 font-bold text-sm ring-2 ring-white ">
                                {{ substr($event->organizer->name, 0, 1) }}
                            </div>
                            <div>
                                <a href="{{ route('admin.organizers.show', $event->organizer) }}"
                                    class="font-medium text-slate-900  hover:text-indigo-500 transition-colors">
                                    {{ $event->organizer->name }}
                                </a>
                                <p class="text-xs text-slate-500 truncate max-w-[150px]">{{ $event->organizer->email }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-slate-500 italic text-sm">No organizer assigned.</p>
                    @endif
                </div>

                <!-- Venue Card -->
                <div class="glass-card p-6 rounded-3xl border-black/5  shadow-sm">
                    <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-4">Venue</h3>
                    @if($event->venue)
                        <div>
                            <a href="{{ route('admin.venues.show', $event->venue) }}"
                                class="font-medium text-slate-900  hover:text-indigo-500 transition-colors block mb-1">
                                {{ $event->venue->name }}
                            </a>
                            <p class="text-sm text-slate-500">{{ $event->venue->address }}</p>
                            <p class="text-sm text-slate-500">{{ $event->venue->city }}, {{ $event->venue->country }}</p>
                        </div>
                    @else
                        <div>
                            <p class="font-medium text-slate-900 ">{{ $event->location }}</p>
                            <p class="text-xs text-slate-500 mt-1">(Custom Location)</p>
                        </div>
                    @endif
                </div>

                <!-- Schedule Card -->
                <div class="glass-card p-6 rounded-3xl border-black/5  shadow-sm">
                    <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-4">Schedule</h3>
                    <div class="space-y-4">
                        <div>
                            <span class="text-xs text-slate-500 block mb-0.5">Start</span>
                            <p class="font-medium text-slate-900 ">
                                {{ $event->start_time?->format('D, M d Y') ?? 'Not Set' }}
                            </p>
                            <p class="text-sm text-slate-500">{{ $event->start_time?->format('h:i A') ?? '' }}</p>
                        </div>
                        <div class="pt-3 border-t border-black/5 ">
                            <span class="text-xs text-slate-500 block mb-0.5">End</span>
                            <p class="font-medium text-slate-900 ">
                                {{ $event->end_time?->format('D, M d Y') ?? 'Not Set' }}
                            </p>
                            <p class="text-sm text-slate-500">{{ $event->end_time?->format('h:i A') ?? '' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection