@extends('layouts.admin')

@section('content')
    <div class="space-y-8 animate-in fade-in duration-700">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.users.index') }}"
                    class="group inline-flex items-center text-sm text-slate-500 hover:text-indigo-400 mb-2 transition-colors">
                    <svg class="w-4 h-4 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Users
                </a>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">User <span class="gradient-text">Profile</span>
                </h2>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.users.edit', $user) }}"
                    class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-2.5 px-5 rounded-xl shadow-lg shadow-indigo-600/20 transition-all duration-300 transform hover:scale-[1.02] active:scale-95">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Edit User</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- User Info Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <div
                    class="glass-card p-6 sm:p-8 rounded-3xl border-black/5 dark:border-white/10 shadow-sm flex flex-col items-center text-center">
                    <div
                        class="w-24 h-24 rounded-full bg-indigo-500/10 flex items-center justify-center text-indigo-500 font-bold text-3xl ring-4 ring-white dark:ring-slate-800 mb-4">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $user->name }}</h3>
                    <p class="text-slate-500 text-sm">{{ $user->email }}</p>
                    <div class="mt-4">
                        @php
                            $roleClasses = match ($user->role) {
                                'admin' => 'bg-rose-500/10 text-rose-500 border-rose-500/20',
                                'staff' => 'bg-amber-500/10 text-amber-500 border-amber-500/20',
                                'volunteer' => 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20',
                                default => 'bg-indigo-500/10 text-indigo-500 border-indigo-500/20',
                            };
                        @endphp
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border {{ $roleClasses }} uppercase tracking-wider">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                </div>

                <div class="glass-card p-6 rounded-3xl border-black/5 dark:border-white/10 shadow-sm">
                    <h4 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-4">Details</h4>
                    <div class="space-y-4">
                        <div>
                            <span class="text-xs text-slate-500 block mb-0.5">Joined</span>
                            <p class="font-medium text-slate-900 dark:text-slate-200">
                                {{ $user->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <span class="text-xs text-slate-500 block mb-0.5">Verified</span>
                            <p class="font-medium text-slate-900 dark:text-slate-200">
                                @if($user->email_verified_at)
                                    <span class="text-emerald-500">Yes ({{ $user->email_verified_at->format('M d, Y') }})</span>
                                @else
                                    <span class="text-slate-400">No</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div
                    class="glass-card rounded-3xl overflow-hidden border-black/5 dark:border-white/10 shadow-sm flex flex-col max-h-[500px]">
                    <div class="p-6 border-b border-black/5 dark:border-white/5 shrink-0">
                        <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Recent Activity</h3>
                    </div>
                    <div class="overflow-y-auto flex-1">
                        <ul role="list" class="divide-y divide-black/5 dark:divide-white/5">
                            @forelse($activities as $activity)
                                <li class="p-4 hover:bg-black/5 dark:hover:bg-white/5 transition-colors duration-200">
                                    <div class="flex-1 space-y-1">
                                        <div class="flex items-center justify-between">
                                            <span
                                                class="text-xs font-bold text-indigo-500 truncate">{{ $activity->action }}</span>
                                            <span
                                                class="text-[10px] text-slate-400">{{ $activity->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-xs text-slate-600 dark:text-slate-300 line-clamp-2">
                                            {{ $activity->description }}</p>
                                    </div>
                                </li>
                            @empty
                                <li class="p-4 text-center text-slate-500 text-sm">No recent activity.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Content (Tickets) -->
            <div class="lg:col-span-2 space-y-8">
                <div class="glass-card rounded-3xl overflow-hidden border-black/5 dark:border-white/10 shadow-sm">
                    <div class="p-6 border-b border-black/5 dark:border-white/5 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-200">Ticket History</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-black/5 dark:border-white/5 bg-black/5 dark:bg-white/5">
                                    <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">
                                        Event</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">
                                        Type</th>
                                    <th
                                        class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest text-center">
                                        Seat</th>
                                    <th
                                        class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest text-center">
                                        Status</th>
                                    <th
                                        class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest text-right">
                                        Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-black/5 dark:divide-white/5">
                                @forelse($tickets as $ticket)
                                    <tr class="hover:bg-black/5 dark:hover:bg-white/5 transition-colors duration-200 group">
                                        <td class="px-6 py-5">
                                            <div class="flex flex-col">
                                                <span
                                                    class="text-slate-900 dark:text-slate-200 font-medium">{{ $ticket->event ? $ticket->event->name : 'Deleted Event' }}</span>
                                                <span
                                                    class="text-xs text-indigo-400 font-mono mt-0.5">#{{ strtoupper(substr($ticket->uuid, 0, 8)) }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <span class="text-sm text-slate-600 dark:text-slate-300">{{ $ticket->type }}</span>
                                        </td>
                                        <td class="px-6 py-5 text-center">
                                            <span
                                                class="inline-flex items-center justify-center px-2 py-1 rounded bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold text-xs">
                                                {{ $ticket->seat_number }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 text-center">
                                            @if($ticket->scanned_at)
                                                <span
                                                    class="text-emerald-500 text-xs font-bold uppercase tracking-wider">Scanned</span>
                                            @else
                                                <span
                                                    class="text-slate-400 text-xs font-bold uppercase tracking-wider">Pending</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-5 text-right">
                                            <span
                                                class="text-xs text-slate-500">{{ $ticket->created_at->format('M d, Y') }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                            No tickets found for this user.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($tickets->hasPages())
                        <div class="p-6 border-t border-black/5 dark:border-white/5 flex justify-center">
                            <div class="glass px-4 py-2 rounded-2xl border-white/5">
                                {{ $tickets->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection