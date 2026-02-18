@extends('user.layouts.app')

@section('content')
    <div class="min-h-screen pb-24 bg-white text-slate-900 font-display -mx-4 md:-mx-8 px-6">

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


        <main class="space-y-6">
            @forelse($events as $event)
                <x-event-card :event="$event" />
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