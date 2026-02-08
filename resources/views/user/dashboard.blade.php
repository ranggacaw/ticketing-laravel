@extends('user.layouts.app')

@section('header', 'My Dashboard')
@section('subheader', 'Welcome back, ' . auth()->user()->name)

@section('content')
<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Active Tickets -->
    <div class="bg-slate-800/50 backdrop-blur-md border border-white/5 rounded-2xl p-6 relative overflow-hidden group hover:border-indigo-500/50 transition-all duration-300">
        <div class="absolute -right-6 -top-6 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl group-hover:bg-indigo-500/20 transition-all"></div>
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-slate-400 font-medium">Active Tickets</h3>
            <div class="p-2 bg-indigo-500/20 rounded-lg text-indigo-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
            </div>
        </div>
        <div class="text-3xl font-bold text-white mb-1">{{ $activeTicketsCount }}</div>
        <div class="text-sm text-slate-500">Ready to use</div>
    </div>

    <!-- Pending Payments -->
    <div class="bg-slate-800/50 backdrop-blur-md border border-white/5 rounded-2xl p-6 relative overflow-hidden group hover:border-yellow-500/50 transition-all duration-300">
        <div class="absolute -right-6 -top-6 w-32 h-32 bg-yellow-500/10 rounded-full blur-2xl group-hover:bg-yellow-500/20 transition-all"></div>
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-slate-400 font-medium">Pending Payments</h3>
            <div class="p-2 bg-yellow-500/20 rounded-lg text-yellow-400">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <div class="text-3xl font-bold text-white mb-1">{{ $pendingPaymentsCount }}</div>
        <div class="text-sm text-slate-500">Action needed</div>
    </div>
</div>

<!-- Recent Tickets -->
<div class="mb-8">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-bold text-white">Recent Tickets</h3>
        <a href="{{ route('user.tickets.index') }}" class="text-sm text-indigo-400 hover:text-indigo-300">View All</a>
    </div>
    
    @if($recentTickets->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($recentTickets as $ticket)
                <div class="bg-slate-800/30 backdrop-blur border border-white/5 rounded-xl p-5 hover:bg-slate-800/50 transition-colors">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <div class="text-xs font-bold text-indigo-400 tracking-wider uppercase mb-1">{{ $ticket->type }}</div>
                            <h4 class="text-lg font-bold text-white">{{ $ticket->seat_number }}</h4>
                        </div>
                        <div class="px-2 py-1 bg-green-500/20 text-green-400 text-xs rounded-full">
                            {{ $ticket->scanned_at ? 'Used' : 'Active' }}
                        </div>
                    </div>
                    <div class="border-t border-white/5 pt-4 flex justify-between items-center">
                        <div class="text-sm text-slate-400">Price: ${{ number_format($ticket->price, 2) }}</div>
                        <a href="{{ route('user.tickets.show', $ticket) }}" class="text-sm font-medium text-white hover:underline">Details &rarr;</a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-10 bg-slate-800/30 rounded-xl border border-white/5 border-dashed">
            <p class="text-slate-400">No tickets found yet.</p>
        </div>
    @endif
</div>
@endsection
