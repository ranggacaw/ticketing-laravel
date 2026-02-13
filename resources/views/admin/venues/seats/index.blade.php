@extends('layouts.admin')

@section('content')
    <div class="space-y-8 animate-in fade-in duration-700">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 sm:gap-6">
            <div>
                <a href="{{ route('admin.venues.show', $venue) }}"
                    class="group inline-flex items-center text-sm text-slate-500 hover:text-indigo-400 mb-2 transition-colors">
                    <svg class="w-4 h-4 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to {{ $venue->name }}
                </a>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">Seat <span class="gradient-text">Management</span>
                </h2>
                <p class="text-slate-400 mt-1 font-light text-sm">Configure seating layouts, sections, and availability.</p>
            </div>
            <a href="{{ route('admin.venues.seats.create', $venue) }}"
                class="group relative inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-3 px-6 rounded-2xl transition-all duration-300 transform hover:scale-[1.02] active:scale-95 shadow-lg shadow-indigo-600/20">
                <svg class="h-5 w-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span>Add Seats</span>
            </a>
        </div>

        <!-- Stats or Summary -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="glass-card p-4 rounded-2xl border-black/5 ">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Seats</span>
                <p class="text-2xl font-bold text-slate-900  mt-1">
                    {{ number_format($venue->seats()->count()) }}</p>
            </div>
            <div class="glass-card p-4 rounded-2xl border-black/5 ">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">VIP</span>
                <p class="text-2xl font-bold text-amber-500 mt-1">
                    {{ number_format($venue->seats()->where('type', 'vip')->count()) }}</p>
            </div>
            <div class="glass-card p-4 rounded-2xl border-black/5 ">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Available</span>
                <p class="text-2xl font-bold text-emerald-500 mt-1">
                    {{ number_format($venue->seats()->where('status', 'available')->count()) }}</p>
            </div>
            <div class="glass-card p-4 rounded-2xl border-black/5 ">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Blocked</span>
                <p class="text-2xl font-bold text-rose-500 mt-1">
                    {{ number_format($venue->seats()->where('status', 'blocked')->count()) }}</p>
            </div>
        </div>

        <div class="glass-card rounded-3xl overflow-hidden border-black/5  shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-black/5  bg-black/5 ">
                            <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Section
                            </th>
                            <th
                                class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest text-center">
                                Row</th>
                            <th
                                class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest text-center">
                                Number</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Type</th>
                            <th
                                class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest text-center">
                                Status</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5 ">
                        @forelse($seats as $seat)
                            <tr class="hover:bg-black/5  transition-colors duration-200 group">
                                <td class="px-6 py-4">
                                    <span
                                        class="text-slate-900  font-medium">{{ $seat->section ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-slate-700 ">{{ $seat->row ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100  text-slate-700  font-bold border border-black/5 ">
                                        {{ $seat->number }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $typeClasses = match ($seat->type) {
                                            'vip' => 'bg-amber-500/10 text-amber-500 border-amber-500/20',
                                            'accessible' => 'bg-sky-500/10 text-sky-500 border-sky-500/20',
                                            default => 'bg-slate-500/10 text-slate-500 border-slate-500/20', // standard
                                        };
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium border {{ $typeClasses }}">
                                        {{ ucfirst($seat->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($seat->status === 'available')
                                        <span class="text-emerald-500 text-xs font-medium uppercase tracking-wider">Available</span>
                                    @elseif($seat->status === 'blocked')
                                        <span class="text-rose-500 text-xs font-medium uppercase tracking-wider">Blocked</span>
                                    @else
                                        <span
                                            class="text-slate-500 text-xs font-medium uppercase tracking-wider">{{ ucfirst($seat->status) }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('admin.venues.seats.edit', [$venue, $seat]) }}"
                                            class="p-2 text-slate-400 hover:text-indigo-400 hover:bg-indigo-400/10 rounded-xl transition-all duration-200"
                                            title="Edit Seat">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.venues.seats.destroy', [$venue, $seat]) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-slate-400 hover:text-rose-400 hover:bg-rose-400/10 rounded-xl transition-all duration-200 cursor-pointer"
                                                onclick="return confirm('Delete this seat?')" title="Delete Seat">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
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
                                            class="w-16 h-16 bg-black/5  rounded-2xl flex items-center justify-center text-slate-500 mb-4 glass">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-medium text-slate-900 ">No seats defined</h3>
                                        <p class="text-slate-500 mt-1">Start by adding individual seats or bulk generating rows.
                                        </p>
                                        <a href="{{ route('admin.venues.seats.create', $venue) }}"
                                            class="mt-4 text-indigo-400 hover:text-indigo-300 font-medium">Add Seats &rarr;</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($seats->hasPages())
            <div class="mt-6 flex justify-center">
                <div class="glass px-4 py-2 rounded-2xl border-white/5">
                    {{ $seats->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection