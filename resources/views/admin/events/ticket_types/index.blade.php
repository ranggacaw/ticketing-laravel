@extends('layouts.admin')

@section('content')
    <div class="space-y-8 animate-in fade-in duration-700">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 sm:gap-6">
            <div>
                <a href="{{ route('admin.events.show', $event) }}"
                    class="group inline-flex items-center text-sm text-slate-500 hover:text-indigo-400 mb-2 transition-colors">
                    <svg class="w-4 h-4 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to {{ $event->name }}
                </a>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">Ticket <span class="gradient-text">Types</span>
                </h2>
                <p class="text-slate-400 mt-1 font-light text-sm">Manage ticket tiers and pricing for this event.</p>
            </div>
            <a href="{{ route('admin.events.ticket-types.create', $event) }}"
                class="group relative inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-3 px-6 rounded-2xl transition-all duration-300 transform hover:scale-[1.02] active:scale-95 shadow-lg shadow-indigo-600/20">
                <svg class="h-5 w-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span>Add Ticket Type</span>
            </a>
        </div>

        <div class="glass-card rounded-3xl overflow-hidden border-black/5 dark:border-white/10 shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-black/5 dark:border-white/5 bg-black/5 dark:bg-white/5">
                            <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Name</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Price</th>
                            <th
                                class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest text-center">
                                Availability</th>
                            <th
                                class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest text-center">
                                Sales</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Sale Period
                            </th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5 dark:divide-white/5">
                        @forelse($ticketTypes as $ticketType)
                            <tr class="hover:bg-black/5 dark:hover:bg-white/5 transition-colors duration-200 group">
                                <td class="px-6 py-5">
                                    <span class="text-slate-900 dark:text-slate-200 font-medium">{{ $ticketType->name }}</span>
                                    @if($ticketType->description)
                                        <p class="text-xs text-slate-500 mt-0.5 truncate max-w-xs">
                                            {{Str::limit($ticketType->description, 50)}}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-5">
                                    <span class="text-slate-700 dark:text-slate-300 font-bold">Rp
                                        {{ number_format($ticketType->price, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @if($ticketType->is_available)
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">
                                            Available
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-rose-500/10 text-rose-500 border border-rose-500/20">
                                            Unavailable
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <div class="flex flex-col items-center">
                                        <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">
                                            {{ $ticketType->sold }} / {{ $ticketType->quantity }}
                                        </span>
                                        <div
                                            class="w-24 h-1.5 bg-slate-200 dark:bg-slate-700 rounded-full mt-1 overflow-hidden">
                                            @php
                                                $percentage = $ticketType->quantity > 0 ? ($ticketType->sold / $ticketType->quantity) * 100 : 0;
                                            @endphp
                                            <div class="h-full bg-indigo-500 rounded-full" style="width: {{ $percentage }}%">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col text-xs text-slate-500">
                                        <span>Start:
                                            {{ $ticketType->sale_start_date ? $ticketType->sale_start_date->format('M d, H:i') : 'Now' }}</span>
                                        <span>End:
                                            {{ $ticketType->sale_end_date ? $ticketType->sale_end_date->format('M d, H:i') : 'Forever' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('admin.events.ticket-types.edit', [$event, $ticketType]) }}"
                                            class="p-2 text-slate-400 hover:text-indigo-400 hover:bg-indigo-400/10 rounded-xl transition-all duration-200"
                                            title="Edit Ticket Type">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.events.ticket-types.destroy', [$event, $ticketType]) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-slate-400 hover:text-rose-400 hover:bg-rose-400/10 rounded-xl transition-all duration-200 cursor-pointer"
                                                onclick="return confirm('Delete this ticket type?')" title="Delete Ticket Type">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-16 h-16 bg-black/5 dark:bg-white/5 rounded-2xl flex items-center justify-center text-slate-500 mb-4 glass">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-medium text-slate-900 dark:text-slate-300">No ticket types found
                                        </h3>
                                        <p class="text-slate-500 mt-1">Add ticket types to start selling tickets.</p>
                                        <a href="{{ route('admin.events.ticket-types.create', $event) }}"
                                            class="mt-4 text-indigo-400 hover:text-indigo-300 font-medium">Add Ticket Type
                                            &rarr;</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($ticketTypes->hasPages())
            <div class="mt-6 flex justify-center">
                <div class="glass px-4 py-2 rounded-2xl border-white/5">
                    {{ $ticketTypes->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection