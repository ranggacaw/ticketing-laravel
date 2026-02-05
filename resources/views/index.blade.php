@extends('layouts.app')

@section('content')
<div class="text-center space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="flex flex-col items-center">
        <div class="w-20 h-20 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/20 mb-6 glass">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
            </svg>
        </div>
        <h1 class="text-4xl font-bold tracking-tight">Ticket<span class="gradient-text">Scan</span></h1>
        <p class="text-slate-400 mt-2 font-light">Event Staff Access Point</p>
    </div>

    <div class="glass rounded-3xl p-8 space-y-6">
        <div class="space-y-2">
            <h2 class="text-xl font-semibold">Ready to scan?</h2>
            <p class="text-slate-400 text-sm">Please ensure you are at the correct gate before beginning the validation process.</p>
        </div>

        <a href="{{ route('scan') }}" class="group relative block w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-4 px-6 rounded-2xl transition-all duration-300 transform hover:scale-[1.02] active:scale-95 shadow-lg shadow-indigo-600/20 text-center">
            <span class="relative z-10 flex items-center justify-center gap-2">
               Start Scanning
               <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
               </svg>
            </span>
        </a>
    </div>

    <div class="pt-4 px-6">
        <div class="flex items-center justify-between text-xs text-slate-500 uppercase tracking-widest font-medium">
            <span>Gate: Platinum A</span>
            <span>Staff ID: #302</span>
        </div>
    </div>
</div>
@endsection
