@extends('layouts.admin')

@section('content')
    <div class="space-y-8 animate-in fade-in duration-700">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 sm:gap-6">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">Organizer <span
                        class="gradient-text">Management</span></h2>
                <p class="text-slate-400 mt-1 font-light text-sm">Manage event organizers and their profiles.</p>
            </div>
            <a href="{{ route('admin.organizers.create') }}"
                class="group relative inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-3 px-6 rounded-2xl transition-all duration-300 transform hover:scale-[1.02] active:scale-95 shadow-lg shadow-indigo-600/20">
                <svg class="h-5 w-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span>Add Organizer</span>
            </a>
        </div>

        <div class="glass-card rounded-3xl overflow-hidden border-black/5 dark:border-white/10 shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-black/5 dark:border-white/5 bg-black/5 dark:bg-white/5">
                            <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Name</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Contact
                            </th>
                            <th
                                class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest text-center">
                                Events</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5 dark:divide-white/5">
                        @forelse($organizers as $organizer)
                            <tr class="hover:bg-black/5 dark:hover:bg-white/5 transition-colors duration-200 group">
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-10 h-10 rounded-full bg-indigo-500/10 flex items-center justify-center text-indigo-500 font-bold text-sm">
                                            {{ substr($organizer->name, 0, 2) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span
                                                class="text-slate-900 dark:text-slate-200 font-medium">{{ $organizer->name }}</span>
                                            <span
                                                class="text-xs text-slate-500 mt-0.5 truncate max-w-xs">{{ $organizer->website }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-slate-700 dark:text-slate-300 text-sm">{{ $organizer->email }}</span>
                                        <span class="text-xs text-slate-500">{{ $organizer->phone }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span
                                        class="inline-flex items-center justify-center px-3 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold text-xs border border-black/5 dark:border-white/5">
                                        {{ $organizer->events_count ?? 0 }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('admin.organizers.show', $organizer) }}"
                                            class="p-2 text-slate-400 hover:text-sky-400 hover:bg-sky-400/10 rounded-xl transition-all duration-200"
                                            title="View Profile">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.organizers.edit', $organizer) }}"
                                            class="p-2 text-slate-400 hover:text-indigo-400 hover:bg-indigo-400/10 rounded-xl transition-all duration-200"
                                            title="Edit Profile">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.organizers.destroy', $organizer) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-slate-400 hover:text-rose-400 hover:bg-rose-400/10 rounded-xl transition-all duration-200 cursor-pointer"
                                                onclick="return confirm('Delete this organizer?')" title="Delete Profile">
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
                                            class="w-16 h-16 bg-black/5 dark:bg-white/5 rounded-2xl flex items-center justify-center text-slate-500 mb-4 glass">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-medium text-slate-900 dark:text-slate-300">No organizers found
                                        </h3>
                                        <p class="text-slate-500 mt-1">Get started by adding an organizer profile.</p>
                                        <a href="{{ route('admin.organizers.create') }}"
                                            class="mt-4 text-indigo-400 hover:text-indigo-300 font-medium">Add Organizer
                                            &rarr;</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($organizers->hasPages())
            <div class="mt-6 flex justify-center">
                <div class="glass px-4 py-2 rounded-2xl border-white/5">
                    {{ $organizers->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection