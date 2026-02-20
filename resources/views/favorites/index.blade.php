@extends('user.layouts.app')

@section('content')
    <div class="min-h-screen pb-24 bg-white text-slate-900 font-display -mx-4 md:-mx-8 px-6">

        <!-- Header -->
        <x-page-header title="Wishlist" subtitle="Your saved events">
        </x-page-header>


        <main class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($events as $event)
                    <x-event-card :event="$event" />
                @empty
                    <div class="col-span-full text-center py-20">
                        <span class="material-symbols-outlined text-6xl text-slate-300  mb-4">favorite_border</span>
                        <h3 class="text-xl font-bold text-slate-500">No saved events</h3>
                        <p class="text-slate-400 mt-2">Start adding events to your wishlist!</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8 px-4">
                {{ $events->links() }}
            </div>
        </main>

        <x-bottom-navigation />

    </div>
@endsection