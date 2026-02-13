@extends('layouts.public')

@section('content')
    <div class="min-h-screen pb-24 bg-white  text-slate-900  font-display">

        <!-- Header -->
        <x-page-header title="Events" subtitle="Your necessary events">
            <x-slot:action>
                <button
                    class="w-10 h-10 flex items-center justify-center bg-slate-100  rounded-full hover:bg-slate-200  transition-colors">
                    <span class="material-symbols-outlined text-xl text-slate-900 ">tune</span>
                </button>
            </x-slot:action>

            <x-slot:bottom>
                <button
                    class="whitespace-nowrap px-4 py-2 bg-primary-ref text-white text-sm font-medium rounded-full shadow-sm shadow-red-200 ">
                    All Events
                </button>
                <button
                    class="whitespace-nowrap px-4 py-2 bg-slate-100  text-slate-600  text-sm font-medium rounded-full border border-transparent hover:bg-slate-200 ">
                    Music
                </button>
                <button
                    class="whitespace-nowrap px-4 py-2 bg-slate-100  text-slate-600  text-sm font-medium rounded-full border border-transparent hover:bg-slate-200 ">
                    Comedy
                </button>
                <button
                    class="whitespace-nowrap px-4 py-2 bg-slate-100  text-slate-600  text-sm font-medium rounded-full border border-transparent hover:bg-slate-200 ">
                    Sports
                </button>
            </x-slot:bottom>
        </x-page-header>


        <main class="p-6 space-y-6">
            @forelse($events as $event)
                <div
                    class="group bg-white  rounded-3xl overflow-hidden shadow-lg shadow-slate-200/50  hover:shadow-xl transition-all duration-300 border border-slate-100 ">
                    <div class="relative h-56">
                        <!-- Image -->
                        <div class="w-full h-full bg-slate-200  relative overflow-hidden">
                            <!-- Using a placeholder pattern if no image URL property (adjust based on actual model) -->
                            <div class="absolute inset-0 flex items-center justify-center text-slate-400  bg-slate-800">
                                <span class="material-symbols-outlined text-6xl opacity-20">event</span>
                                <span class="absolute text-xl font-bold opacity-30">{{ $event->name }}</span>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        </div>

                        <!-- Top Right Badge -->
                        <div
                            class="absolute top-4 right-4 bg-white/90  backdrop-blur-md px-3 py-1 rounded-full flex items-center space-x-1">
                            <span class="text-xs font-bold text-primary-ref">SELLING FAST</span>
                        </div>

                        <!-- Favorite Button -->
                        <button
                            class="absolute top-4 left-4 bg-white/20 backdrop-blur-md p-2 rounded-full text-white hover:bg-white/30 transition-colors">
                            <span class="material-symbols-outlined text-xl">favorite</span>
                        </button>

                        <!-- Date Tag -->
                        <div
                            class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent h-24 p-5 flex items-end">
                            <span class="text-white font-bold text-sm bg-primary-ref px-2 py-0.5 rounded">
                                {{ $event->start_time ? $event->start_time->format('M d') : 'TBA' }}
                            </span>
                        </div>
                    </div>

                    <div class="p-5">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex-1 pr-2">
                                <h3 class="text-xl font-bold mb-1 text-slate-900  leading-tight">
                                    <a href="{{ route('events.show', $event) }}">
                                        {{ $event->name }}
                                    </a>
                                </h3>
                                <p class="text-sm text-slate-500  flex items-center">
                                    <span class="material-symbols-outlined text-sm mr-1">location_on</span>
                                    {{ $event->venue ? $event->venue->name : 'Unknown Venue' }}
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl font-black text-slate-900 ">
                                    ${{ rand(50, 150) }}
                                </span>
                                <p class="text-[10px] uppercase tracking-wider text-slate-400">per ticket</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-6 mb-5 pt-2 border-t border-slate-100  mt-3">
                            <div class="flex items-center text-xs text-slate-500 font-medium">
                                <span class="material-symbols-outlined text-lg mr-1.5 text-primary-ref">schedule</span>
                                {{ $event->start_time ? $event->start_time->format('h:i A') : '--:--' }}
                            </div>
                            <div class="flex items-center text-xs text-slate-500 font-medium">
                                <span class="material-symbols-outlined text-lg mr-1.5 text-primary-ref">groups</span>
                                All Ages
                            </div>
                        </div>

                        <button onclick="window.location='{{ route('events.show', $event) }}'"
                            class="w-full py-4 bg-primary-ref text-white font-bold rounded-2xl hover:bg-red-700 transition-colors flex items-center justify-center space-x-2 shadow-lg shadow-red-200  cursor-pointer">
                            <span>Get Tickets</span>
                            <span class="material-symbols-outlined text-sm">confirmation_number</span>
                        </button>
                    </div>
                </div>
            @empty
                <div class="text-center py-20">
                    <span class="material-symbols-outlined text-6xl text-slate-300  mb-4">event_busy</span>
                    <h3 class="text-xl font-bold text-slate-500">No events found</h3>
                </div>
            @endforelse

            <div class="mt-8 px-4">
                {{ $events->links() }}
            </div>
        </main>

        <x-bottom-navigation />

    </div>
@endsection