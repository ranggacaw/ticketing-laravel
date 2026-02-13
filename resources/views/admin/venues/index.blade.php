@extends('layouts.admin')

@section('content')
    <div class="space-y-8 animate-in fade-in duration-700">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 sm:gap-6">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">Venue <span
                        class="gradient-text">Management</span></h2>
                <p class="text-slate-400 mt-1 font-light text-sm">Manage venues, locations, and seating capacities.</p>
            </div>
            <a href="{{ route('admin.venues.create') }}"
                class="group relative inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-3 px-6 rounded-2xl transition-all duration-300 transform hover:scale-[1.02] active:scale-95 shadow-lg shadow-indigo-600/20">
                <svg class="h-5 w-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span>Add New Venue</span>
            </a>
        </div>

        <div class="glass-card rounded-3xl overflow-hidden border-black/5  shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-black/5  bg-black/5 ">
                            <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Name</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Location
                            </th>
                            <th
                                class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest text-center">
                                Capacity</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5 ">
                        @forelse($venues as $venue)
                            <tr class="hover:bg-black/5  transition-colors duration-200 group">
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-slate-900  font-medium">{{ $venue->name }}</span>
                                        <span
                                            class="text-xs text-slate-500 mt-0.5 truncate max-w-xs">{{ $venue->address }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="text-slate-700 ">{{ $venue->city }},
                                        {{ $venue->country }}</span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @if($venue->capacity)
                                        <span
                                            class="inline-flex items-center justify-center px-3 py-1 rounded-lg bg-slate-100  text-slate-600  font-bold text-xs border border-black/5 ">
                                            {{ number_format($venue->capacity) }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-xs italic">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('admin.venues.show', $venue) }}"
                                            class="p-2 text-slate-400 hover:text-sky-400 hover:bg-sky-400/10 rounded-xl transition-all duration-200"
                                            title="View Details">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.venues.edit', $venue) }}"
                                            class="p-2 text-slate-400 hover:text-indigo-400 hover:bg-indigo-400/10 rounded-xl transition-all duration-200"
                                            title="Edit Venue">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.venues.destroy', $venue) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-slate-400 hover:text-rose-400 hover:bg-rose-400/10 rounded-xl transition-all duration-200 cursor-pointer"
                                                onclick="return confirm('Delete this venue?')" title="Delete Venue">
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
                                <td colspan="4" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-16 h-16 bg-black/5  rounded-2xl flex items-center justify-center text-slate-500 mb-4 glass">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-medium text-slate-900 ">No venues found</h3>
                                        <p class="text-slate-500 mt-1">Get started by adding your first venue.</p>
                                        <a href="{{ route('admin.venues.create') }}"
                                            class="mt-4 text-indigo-400 hover:text-indigo-300 font-medium">Add Venue &rarr;</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($venues->hasPages())
            <div class="mt-6 flex justify-center">
                <div class="glass px-4 py-2 rounded-2xl border-white/5">
                    {{ $venues->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection