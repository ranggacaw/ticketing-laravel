@extends('layouts.admin')

@section('content')
<div class="space-y-8 animate-in fade-in duration-700">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 sm:gap-6">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">User <span class="gradient-text">History</span></h2>
            <p class="text-slate-400 mt-1 font-light text-sm">Track and monitor all user activities and system events.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.history.export', request()->all()) }}" class="glass-card px-4 sm:px-6 py-2.5 rounded-xl border-indigo-500/20 flex items-center gap-2 text-indigo-500 text-sm font-medium hover:bg-indigo-500/10 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Export CSV
            </a>
        </div>
    </div>

    @include('admin.history._filters')

    <div class="glass-card rounded-3xl overflow-hidden border-black/5  shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-black/5  bg-black/5 ">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Timestamp</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">User</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Action</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Description</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest text-right">Details</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5 ">
                    @forelse($activities as $activity)
                    <tr class="hover:bg-black/5  transition-colors duration-200 group">
                        <td class="px-6 py-5 whitespace-nowrap">
                            <div class="flex flex-col">
                                <span class="text-slate-900  font-medium text-sm">{{ $activity->created_at->format('M d, Y') }}</span>
                                <span class="text-xs text-slate-500">{{ $activity->created_at->format('H:i:s') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-500/20 flex items-center justify-center text-indigo-500 font-bold text-xs">
                                    {{ substr($activity->user->name ?? 'System', 0, 1) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-slate-900  font-medium text-sm">{{ $activity->user->name ?? 'System' }}</span>
                                    <span class="text-xs text-slate-500">{{ $activity->user->email ?? '-' }}</span>
                                </div>
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
                                    'LOGIN_FAILED' => 'bg-red-500/10 text-red-500 border-red-500/20',
                                    'SCAN' => 'bg-violet-500/10 text-violet-500 border-violet-500/20',
                                    default => 'bg-slate-500/10 text-slate-500 border-slate-500/20',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border {{ $actionClasses }}">
                                {{ $activity->action }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-slate-600  text-sm truncate max-w-xs" title="{{ $activity->description }}">
                                {{ $activity->description }}
                            </p>
                            @if($activity->resource_type)
                                <p class="text-xs text-slate-400 mt-1">
                                    {{ class_basename($activity->resource_type) }} #{{ $activity->resource_id }}
                                </p>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-right">
                            <a href="{{ route('admin.history.show', $activity->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 text-slate-400 hover:text-white transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-black/5  rounded-2xl flex items-center justify-center text-slate-500 mb-4 glass">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-slate-900 ">No activities found</h3>
                                <p class="text-slate-500 mt-1">Try adjusting your filters or search criteria.</p>
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
