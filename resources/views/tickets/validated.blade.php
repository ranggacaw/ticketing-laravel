@extends('layouts.app')

@section('content')
<div class="space-y-6 animate-in fade-in duration-700">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold tracking-tight">Validated <span class="gradient-text">Tickets</span></h2>
        <div class="flex items-center gap-1">
            <a href="{{ route('scan') }}" class="p-2 text-slate-400 hover:text-white transition-colors" title="Back to Scanner">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="p-2 text-slate-400 hover:text-rose-400 transition-colors" title="Sign Out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <div class="glass rounded-3xl overflow-hidden p-1">
        @if($tickets->count() > 0)
            <ul class="divide-y divide-white/10">
                @foreach($tickets as $ticket)
                <li class="p-4 hover:bg-white/5 transition-colors">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-medium text-white">{{ $ticket->user_name }}</p>
                            <p class="text-xs text-slate-400 mt-1">{{ $ticket->seat_number }} • {{ $ticket->type }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                Validated
                            </span>
                            <p class="text-xs text-slate-500 mt-1">{{ $ticket->scanned_at ? $ticket->scanned_at->format('H:i') : '' }}</p>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            <div class="p-4 border-t border-white/10">
                {{ $tickets->links('pagination::simple-tailwind') }}
            </div>
        @else
            <div class="p-8 text-center text-slate-500">
                No tickets scanned yet.
            </div>
        @endif
    </div>
</div>
@endsection
