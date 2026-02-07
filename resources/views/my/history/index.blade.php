@extends('layouts.admin')

@section('content')
<div class="space-y-8 animate-in fade-in duration-700">
    <div>
        <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">My <span class="gradient-text">Activity</span></h2>
        <p class="text-slate-400 mt-1 font-light text-sm">A personal record of your actions within the system.</p>
    </div>

    <!-- Filters -->
    <form action="{{ route('my.history') }}" method="GET" class="glass-card p-6 rounded-3xl border-black/5 dark:border-white/5">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Action Types -->
            <div class="space-y-2">
                <label for="action" class="text-xs font-semibold text-slate-400 uppercase tracking-widest">Action</label>
                <select name="action" id="action" class="w-full bg-black/5 dark:bg-white/5 border border-black/10 dark:border-white/10 rounded-xl px-4 py-2.5 text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition-all appearance-none cursor-pointer">
                    <option value="">All Actions</option>
                    @foreach($actions as $act)
                        <option value="{{ $act }}" {{ request('action') == $act ? 'selected' : '' }}>{{ $act }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Date Range -->
            <div class="space-y-2 lg:col-span-2">
                <label class="text-xs font-semibold text-slate-400 uppercase tracking-widest">Date Range</label>
                <div class="flex items-center gap-2">
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full bg-black/5 dark:bg-white/5 border border-black/10 dark:border-white/10 rounded-xl px-4 py-2.5 text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition-all">
                    <span class="text-slate-400">-</span>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full bg-black/5 dark:bg-white/5 border border-black/10 dark:border-white/10 rounded-xl px-4 py-2.5 text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition-all">
                </div>
            </div>
        </div>
        
        <div class="flex justify-end gap-3 pt-4 border-t border-black/5 dark:border-white/5 mt-6">
            <a href="{{ route('my.history') }}" class="px-6 py-2.5 rounded-xl border border-black/10 dark:border-white/10 text-slate-600 dark:text-slate-300 font-medium hover:bg-black/5 dark:hover:bg-white/5 transition-all">
                Clear
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white font-medium hover:bg-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all shadow-lg shadow-indigo-500/30">
                Update
            </button>
        </div>
    </form>

    <div class="glass-card rounded-3xl overflow-hidden border-black/5 dark:border-white/10 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-black/5 dark:border-white/5 bg-black/5 dark:bg-white/5">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Timestamp</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Action</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Description</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Resource</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5 dark:divide-white/5">
                    @forelse($activities as $activity)
                    <tr class="hover:bg-black/5 dark:hover:bg-white/5 transition-colors duration-200 group">
                        <td class="px-6 py-5 whitespace-nowrap">
                            <div class="flex flex-col">
                                <span class="text-slate-900 dark:text-slate-200 font-medium text-sm">{{ $activity->created_at->format('M d, Y') }}</span>
                                <span class="text-xs text-slate-500">{{ $activity->created_at->format('H:i:s') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            @php
                                $actionClasses = match($activity->action) {
                                    'CREATE' => 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20',
                                    'UPDATE' => 'bg-amber-500/10 text-amber-500 border-amber-500/20',
                                    'DELETE' => 'bg-rose-500/10 text-rose-500 border-rose-500/20',
                                    'LOGIN' => 'bg-blue-500/10 text-blue-500 border-blue-500/20',
                                    'LOGOUT' => 'bg-slate-500/10 text-slate-500 border-slate-500/20',
                                    'SCAN' => 'bg-violet-500/10 text-violet-500 border-violet-500/20',
                                    default => 'bg-slate-500/10 text-slate-500 border-slate-500/20',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border {{ $actionClasses }}">
                                {{ $activity->action }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-slate-600 dark:text-slate-300 text-sm truncate max-w-md" title="{{ $activity->description }}">
                                {{ $activity->description }}
                            </p>
                        </td>
                        <td class="px-6 py-5">
                             @if($activity->resource_type)
                                <span class="px-2 py-1 rounded bg-black/5 dark:bg-white/5 text-xs font-mono text-slate-500 border border-black/5 dark:border-white/5">
                                    {{ class_basename($activity->resource_type) }} #{{ $activity->resource_id }}
                                </span>
                            @else
                                <span class="text-slate-400 text-xs">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-black/5 dark:bg-white/5 rounded-2xl flex items-center justify-center text-slate-500 mb-4 glass">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-slate-900 dark:text-slate-300">No history found</h3>
                                <p class="text-slate-500 mt-1">Activities will appear here as you use the system.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($activities->hasPages())
    <div class="flex justify-center">
        <div class="glass px-4 py-2 rounded-2xl border-white/5">
            {{ $activities->links() }}
        </div>
    </div>
    @endif
</div>
@endsection
