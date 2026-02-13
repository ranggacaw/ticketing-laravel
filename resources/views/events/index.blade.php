@extends('layouts.public')

@section('content')
    <div class="min-h-screen pb-24 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 font-display">
        
        <!-- Header -->
        <header class="bg-white dark:bg-slate-900 px-6 pb-4 border-b border-slate-100 dark:border-slate-800 sticky top-0 z-40 transition-colors">
            <div class="flex items-center space-x-4 mb-4 pt-4">
                <button class="p-2 -ml-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors">
                    <span class="material-symbols-outlined block text-slate-900 dark:text-white">arrow_back_ios_new</span>
                </button>
                <div class="flex-1">
                    <h1 class="text-lg font-bold leading-tight text-slate-900 dark:text-white">Events</h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Discover & Book</p>
                </div>
                <button class="w-10 h-10 flex items-center justify-center bg-slate-100 dark:bg-slate-800 rounded-full hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                    <span class="material-symbols-outlined text-xl text-slate-900 dark:text-white">tune</span>
                </button>
            </div>
            <div class="flex space-x-2 overflow-x-auto no-scrollbar py-1">
                <button class="whitespace-nowrap px-4 py-2 bg-primary-ref text-white text-sm font-medium rounded-full shadow-sm shadow-red-200 dark:shadow-none">
                    All Events
                </button>
                <button class="whitespace-nowrap px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-sm font-medium rounded-full border border-transparent hover:bg-slate-200 dark:hover:bg-slate-700">
                    Music
                </button>
                <button class="whitespace-nowrap px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-sm font-medium rounded-full border border-transparent hover:bg-slate-200 dark:hover:bg-slate-700">
                    Comedy
                </button>
                <button class="whitespace-nowrap px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-sm font-medium rounded-full border border-transparent hover:bg-slate-200 dark:hover:bg-slate-700">
                    Sports
                </button>
            </div>
        </header>

        <main class="p-6 space-y-6">
            @forelse($events as $event)
                <div class="group bg-white dark:bg-slate-800/50 rounded-3xl overflow-hidden shadow-lg shadow-slate-200/50 dark:shadow-none hover:shadow-xl transition-all duration-300 border border-slate-100 dark:border-slate-800">
                    <div class="relative h-56">
                        <!-- Image -->
                        <div class="w-full h-full bg-slate-200 dark:bg-slate-700 relative overflow-hidden">
                             <!-- Using a placeholder pattern if no image URL property (adjust based on actual model) -->
                             <div class="absolute inset-0 flex items-center justify-center text-slate-400 dark:text-slate-600 bg-slate-800">
                                <span class="material-symbols-outlined text-6xl opacity-20">event</span>
                                <span class="absolute text-xl font-bold opacity-30">{{ $event->name }}</span>
                             </div>
                             <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        </div>

                        <!-- Top Right Badge -->
                        <div class="absolute top-4 right-4 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md px-3 py-1 rounded-full flex items-center space-x-1">
                            <span class="text-xs font-bold text-primary-ref">SELLING FAST</span>
                        </div>

                        <!-- Favorite Button -->
                        <button class="absolute top-4 left-4 bg-white/20 backdrop-blur-md p-2 rounded-full text-white hover:bg-white/30 transition-colors">
                            <span class="material-symbols-outlined text-xl">favorite</span>
                        </button>

                        <!-- Date Tag -->
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent h-24 p-5 flex items-end">
                            <span class="text-white font-bold text-sm bg-primary-ref px-2 py-0.5 rounded">
                                {{ $event->start_time ? $event->start_time->format('M d') : 'TBA' }}
                            </span>
                        </div>
                    </div>

                    <div class="p-5">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex-1 pr-2">
                                <h3 class="text-xl font-bold mb-1 text-slate-900 dark:text-white leading-tight">
                                    <a href="{{ route('events.show', $event) }}">
                                        {{ $event->name }}
                                    </a>
                                </h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 flex items-center">
                                    <span class="material-symbols-outlined text-sm mr-1">location_on</span>
                                    {{ $event->venue ? $event->venue->name : 'Unknown Venue' }}
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl font-black text-slate-900 dark:text-white">
                                    ${{ rand(50, 150) }}
                                </span>
                                <p class="text-[10px] uppercase tracking-wider text-slate-400">per ticket</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-6 mb-5 pt-2 border-t border-slate-100 dark:border-slate-700 mt-3">
                            <div class="flex items-center text-xs text-slate-500 font-medium">
                                <span class="material-symbols-outlined text-lg mr-1.5 text-primary-ref">schedule</span>
                                {{ $event->start_time ? $event->start_time->format('h:i A') : '--:--' }}
                            </div>
                            <div class="flex items-center text-xs text-slate-500 font-medium">
                                <span class="material-symbols-outlined text-lg mr-1.5 text-primary-ref">groups</span>
                                All Ages
                            </div>
                        </div>

                        <button onclick="window.location='{{ route('events.show', $event) }}'" class="w-full py-4 bg-primary-ref text-white font-bold rounded-2xl hover:bg-red-700 transition-colors flex items-center justify-center space-x-2 shadow-lg shadow-red-200 dark:shadow-none cursor-pointer">
                            <span>Get Tickets</span>
                            <span class="material-symbols-outlined text-sm">confirmation_number</span>
                        </button>
                    </div>
                </div>
            @empty
                 <div class="text-center py-20">
                    <span class="material-symbols-outlined text-6xl text-slate-300 dark:text-slate-700 mb-4">event_busy</span>
                    <h3 class="text-xl font-bold text-slate-500">No events found</h3>
                </div>
            @endforelse
            
            <div class="mt-8 px-4">
                 {{ $events->links() }}
            </div>
        </main>

        <!-- Fixed Bottom Navigation -->
        <nav class="fixed bottom-0 left-0 right-0 glass-card border-t border-slate-100 dark:border-slate-800 px-8 py-4 z-50 rounded-t-[2rem]">
            <div class="flex justify-between items-center max-w-md mx-auto relative">
                <button class="flex flex-col items-center text-primary-ref w-16">
                    <span class="material-symbols-outlined fill-current">explore</span>
                    <span class="text-[10px] font-bold mt-1">Explore</span>
                </button>
                <button class="flex flex-col items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 w-16 transition-colors">
                    <span class="material-symbols-outlined">favorite</span>
                    <span class="text-[10px] font-medium mt-1">Saved</span>
                </button>
                <div class="relative -top-10">
                    <button class="w-16 h-16 bg-primary-ref text-white rounded-full shadow-xl shadow-red-500/30 flex items-center justify-center ring-4 ring-white dark:ring-slate-900 hover:bg-red-700 transition-colors transform active:scale-95">
                        <span class="material-symbols-outlined text-3xl">search</span>
                    </button>
                </div>
                <button class="flex flex-col items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 w-16 transition-colors">
                    <span class="material-symbols-outlined">local_activity</span>
                    <span class="text-[10px] font-medium mt-1">My Tickets</span>
                </button>
                <button class="flex flex-col items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 w-16 transition-colors">
                    <span class="material-symbols-outlined">person</span>
                    <span class="text-[10px] font-medium mt-1">Profile</span>
                </button>
            </div>
            <div class="w-32 h-1 bg-slate-300 dark:bg-slate-700 rounded-full mx-auto mt-2"></div>
        </nav>
    </div>
@endsection