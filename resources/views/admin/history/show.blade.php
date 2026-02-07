@extends('layouts.admin')

@section('content')
<div class="space-y-8 animate-in fade-in duration-700 max-w-4xl mx-auto">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.history.index') }}" class="p-2 rounded-xl bg-white/5 hover:bg-white/10 text-slate-400 hover:text-white transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold tracking-tight">Activity <span class="gradient-text">Details</span></h2>
            <p class="text-slate-400 font-light text-sm">View complete information about this event.</p>
        </div>
    </div>

    <!-- Main Activity Info -->
    <div class="glass-card p-6 md:p-8 rounded-3xl border-black/5 dark:border-white/5 space-y-8">
        <!-- Header Info -->
        <div class="flex flex-col md:flex-row md:items-start justify-between gap-6 pb-6 border-b border-black/5 dark:border-white/5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-indigo-500/20 flex items-center justify-center text-indigo-500 font-bold text-lg">
                    {{ substr($activityLog->user->name ?? 'S', 0, 1) }}
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-slate-100">{{ $activityLog->user->name ?? 'System' }}</h3>
                    <p class="text-sm text-slate-500">{{ $activityLog->user->email ?? 'System Action' }}</p>
                </div>
            </div>
            <div class="flex flex-col items-end">
                <span class="text-2xl font-mono font-bold text-slate-700 dark:text-slate-300">{{ $activityLog->created_at->format('H:i:s') }}</span>
                <span class="text-sm text-slate-500">{{ $activityLog->created_at->format('F d, Y') }}</span>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-1">
                <label class="text-xs font-semibold text-slate-400 uppercase tracking-widest">Action Type</label>
                <div>
                     @php
                        $actionClasses = match($activityLog->action) {
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
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold border {{ $actionClasses }}">
                        {{ $activityLog->action }}
                    </span>
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-xs font-semibold text-slate-400 uppercase tracking-widest">IP Address</label>
                <p class="text-base font-mono text-slate-700 dark:text-slate-300">{{ $activityLog->ip_address ?? 'N/A' }}</p>
            </div>

            <div class="space-y-1 md:col-span-2">
                <label class="text-xs font-semibold text-slate-400 uppercase tracking-widest">Description</label>
                <p class="text-base text-slate-700 dark:text-slate-300">{{ $activityLog->description }}</p>
            </div>

            @if($activityLog->resource_type)
            <div class="space-y-1 md:col-span-2">
                <label class="text-xs font-semibold text-slate-400 uppercase tracking-widest">Target Resource</label>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-lg bg-black/5 dark:bg-white/5 border border-black/10 dark:border-white/10 font-mono text-sm text-slate-600 dark:text-slate-400">
                        {{ $activityLog->resource_type }} #{{ $activityLog->resource_id }}
                    </span>
                </div>
            </div>
            @endif
             
             <div class="space-y-1 md:col-span-2">
                <label class="text-xs font-semibold text-slate-400 uppercase tracking-widest">User Agent</label>
                <p class="text-sm font-mono text-slate-500 break-all">{{ $activityLog->user_agent ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- Metadata -->
        @if(!empty($activityLog->metadata))
        <div class="pt-6 border-t border-black/5 dark:border-white/5">
            <label class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-3 block">Metadata Payload</label>
            <div class="bg-slate-900 rounded-2xl p-4 overflow-x-auto shadow-inner border border-white/5">
<pre class="text-xs md:text-sm font-mono text-emerald-400 leading-relaxed">
{{ json_encode($activityLog->metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}
</pre>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
