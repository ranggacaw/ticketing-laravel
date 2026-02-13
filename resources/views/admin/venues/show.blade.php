@extends('layouts.admin')

@section('content')
    <div class="space-y-8 animate-in fade-in duration-700">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 sm:gap-6">
            <div>
                <a href="{{ route('admin.venues.index') }}"
                    class="group inline-flex items-center text-sm text-slate-500 hover:text-indigo-400 mb-2 transition-colors">
                    <svg class="w-4 h-4 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Venues
                </a>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">{{ $venue->name }}</h2>
                <div class="flex items-center gap-2 text-slate-400 mt-1 font-light text-sm">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>{{ $venue->city }}, {{ $venue->country }}</span>
                </div>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.venues.edit', $venue) }}"
                    class="inline-flex items-center justify-center gap-2 bg-slate-100 hover:bg-slate-200   text-slate-700  font-semibold py-2.5 px-5 rounded-xl transition-all duration-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Edit</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Venue Details -->
            <div class="lg:col-span-1 space-y-8">
                <div class="glass-card p-6 rounded-3xl border-black/5  shadow-sm">
                    <h3 class="text-lg font-semibold text-slate-900  mb-4">Venue Details</h3>

                    <div class="space-y-4">
                        <div>
                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Address</span>
                            <p class="text-slate-700  mt-1">{{ $venue->address }}</p>
                            <p class="text-slate-700 ">{{ $venue->city }}, {{ $venue->state }}
                                {{ $venue->postal_code }}
                            </p>
                            <p class="text-slate-700 ">{{ $venue->country }}</p>
                        </div>

                        <div class="pt-4 border-t border-black/5 ">
                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Capacity</span>
                            <p class="text-2xl font-bold text-indigo-500 mt-1">
                                {{ $venue->capacity ? number_format($venue->capacity) : 'N/A' }} <span
                                    class="text-sm font-normal text-slate-400">seats</span>
                            </p>
                        </div>

                        @if($venue->description)
                            <div class="pt-4 border-t border-black/5 ">
                                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">About</span>
                                <p class="text-slate-600  mt-1 text-sm leading-relaxed">
                                    {{ $venue->description }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Placeholder for Seats or Events -->
            <div class="lg:col-span-2 space-y-8">
                <div
                    class="glass-card p-6 rounded-3xl border-black/5  shadow-sm flex flex-col items-center justify-center min-h-[300px] text-center">
                    <div
                        class="w-16 h-16 bg-slate-100  rounded-full flex items-center justify-center text-slate-400 mb-4">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-slate-900 ">Seat Management</h3>
                    <p class="text-slate-500 max-w-sm mt-2">Manage seating layouts, sections, and individual seat
                        availability.</p>
                    <a href="{{ route('admin.venues.seats.index', $venue) }}"
                        class="mt-6 px-5 py-2.5 bg-indigo-50 text-indigo-600   rounded-xl font-medium text-sm hover:bg-indigo-100  transition-colors inline-block">
                        Manage Seats
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection