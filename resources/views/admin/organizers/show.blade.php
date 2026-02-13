@extends('layouts.admin')

@section('content')
    <div class="space-y-8 animate-in fade-in duration-700">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 sm:gap-6">
            <div>
                <a href="{{ route('admin.organizers.index') }}"
                    class="group inline-flex items-center text-sm text-slate-500 hover:text-indigo-400 mb-2 transition-colors">
                    <svg class="w-4 h-4 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Organizers
                </a>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">{{ $organizer->name }}</h2>
                @if($organizer->website)
                    <a href="{{ $organizer->website }}" target="_blank"
                        class="flex items-center gap-2 text-slate-400 mt-1 font-light text-sm hover:text-indigo-400 transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                        </svg>
                        <span>{{ parse_url($organizer->website, PHP_URL_HOST) ?? $organizer->website }}</span>
                    </a>
                @endif
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.organizers.edit', $organizer) }}"
                    class="inline-flex items-center justify-center gap-2 bg-slate-100 hover:bg-slate-200   text-slate-700  font-semibold py-2.5 px-5 rounded-xl transition-all duration-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Edit Profile</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Organizer Details -->
            <div class="lg:col-span-1 space-y-8">
                <div class="glass-card p-6 rounded-3xl border-black/5  shadow-sm">
                    <h3 class="text-lg font-semibold text-slate-900  mb-4">Contact Info</h3>

                    <div class="space-y-4">
                        <div>
                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Email</span>
                            <p class="text-slate-700  mt-1 break-all">{{ $organizer->email }}</p>
                        </div>

                        @if($organizer->phone)
                            <div class="pt-4 border-t border-black/5 ">
                                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Phone</span>
                                <p class="text-slate-700  mt-1">{{ $organizer->phone }}</p>
                            </div>
                        @endif

                        @if($organizer->description)
                            <div class="pt-4 border-t border-black/5 ">
                                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">About</span>
                                <p class="text-slate-600  mt-1 text-sm leading-relaxed">
                                    {{ $organizer->description }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Events List -->
            <div class="lg:col-span-2 space-y-8">
                <h3 class="text-xl font-bold text-slate-900 ">Events ({{ $organizer->events->count() }})</h3>

                <div class="glass-card rounded-3xl overflow-hidden border-black/5  shadow-sm">
                    @if($organizer->events->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-black/5  bg-black/5 ">
                                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">
                                            Event</th>
                                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">
                                            Date</th>
                                        <th
                                            class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest text-right">
                                            Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-black/5 ">
                                    @foreach($organizer->events as $event)
                                        <tr class="hover:bg-black/5  transition-colors duration-200">
                                            <td class="px-6 py-4">
                                                <a href="{{ route('events.show', $event) }}"
                                                    class="font-medium text-slate-900  hover:text-indigo-500 transition-colors">
                                                    {{ $event->title }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="text-slate-500 text-sm">{{ $event->start_time }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800  ">
                                                    Active
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-16 text-center">
                            <div
                                class="w-12 h-12 bg-slate-100  rounded-full flex items-center justify-center text-slate-400 mb-3">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <p class="text-slate-900  font-medium">No events yet</p>
                            <p class="text-slate-500 text-sm mt-1">This organizer hasn't created any events.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection