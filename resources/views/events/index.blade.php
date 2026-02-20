@extends('user.layouts.app')

@section('content')
    <div class="min-h-screen pb-24 bg-white text-slate-900 font-display -mx-4 md:-mx-8 px-6">

        <!-- Header -->
        <x-page-header title="Events" subtitle="Your necessary events">
            <x-slot:action>
                <form action="{{ route('events.index') }}" method="GET" class="flex items-center gap-2">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="material-symbols-outlined text-gray-400 text-lg">search</span>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search events..."
                            class="pl-9 pr-4 py-2 bg-slate-100 rounded-lg text-sm text-slate-900 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary-ref focus:bg-white transition-all w-48 focus:w-64">
                    </div>
                </form>
            </x-slot:action>

            <x-slot:bottom>
                <div
                    class="flex gap-2 overflow-x-auto pb-2 -mb-2 scrollbar-hide md:flex-wrap md:overflow-visible md:pb-0 md:mb-0">
                    <a href="{{ route('events.index', request()->except(['category', 'page'])) }}"
                        class="whitespace-nowrap px-4 py-2 text-sm font-medium rounded-full transition-all {{ !request('category') ? 'bg-primary-ref text-white shadow-sm shadow-red-200' : 'bg-slate-100 text-slate-600 border border-transparent hover:bg-slate-200' }}">
                        All Events
                    </a>

                    @foreach($categories as $category)
                        <a href="{{ route('events.index', array_merge(request()->except('page'), ['category' => $category])) }}"
                            class="whitespace-nowrap px-4 py-2 text-sm font-medium rounded-full transition-all {{ request('category') == $category ? 'bg-primary-ref text-white shadow-sm shadow-red-200' : 'bg-slate-100 text-slate-600 border border-transparent hover:bg-slate-200' }}">
                            {{ $category }}
                        </a>
                    @endforeach
                </div>
            </x-slot:bottom>
        </x-page-header>


        <main class="space-y-6 md:space-y-0 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-6">
            @forelse($events as $event)
                <x-event-card :event="$event" />
            @empty
                <div class="text-center py-20 col-span-full">
                    <span class="material-symbols-outlined text-6xl text-slate-300  mb-4">event_busy</span>
                    <h3 class="text-xl font-bold text-slate-500">No events found</h3>
                </div>
            @endforelse

            <div class="mt-8 px-4 col-span-full">
                {{ $events->links() }}
            </div>
        </main>

        <x-bottom-navigation />

    </div>
@endsection