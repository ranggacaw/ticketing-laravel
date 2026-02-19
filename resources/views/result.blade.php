@extends('layouts.admin')

@section('content')
    <div class="min-h-[80vh] flex flex-col items-center justify-center animate-in fade-in duration-300">
        <div class="w-full max-w-lg">

            <!-- Status Card -->
            <div class="glass-card rounded-3xl overflow-hidden shadow-2xl border-0 ring-1 ring-white/10 relative">
                <div class="absolute inset-0 bg-gradient-to-br opacity-20 pointer-events-none"></div>

                <div class="p-8 sm:p-12 text-center relative z-10 flex flex-col items-center">

                    @if($status === 'valid' && $ticket)
                        <!-- Success Icon -->
                        <div
                            class="w-32 h-32 rounded-full bg-emerald-500 flex items-center justify-center mb-6 shadow-lg shadow-emerald-500/30 animate-bounce-short">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>

                        <h1 class="text-4xl font-black text-emerald-500 tracking-tight mb-2 uppercase">Valid Ticket</h1>
                        <p class="text-slate-500  font-medium mb-8">Access Granted</p>

                        <div class="w-full bg-black/5  rounded-2xl p-6 mb-8 backdrop-blur-sm border border-black/5 ">
                            <div class="flex flex-col gap-1 mb-4">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Guest Name</span>
                                <span class="text-2xl font-bold text-slate-900 ">{{ $ticket->user_name }}</span>
                            </div>

                            <div class="grid grid-cols-2 gap-4 text-left">
                                <div>
                                    <span
                                        class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-1">Type</span>
                                    <span class="text-lg font-semibold text-indigo-500">{{ $ticket->type }}</span>
                                </div>
                                <div>
                                    <span
                                        class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-1">Seat</span>
                                    <span
                                        class="text-lg font-semibold text-slate-700 ">{{ $ticket->seat_number ?? 'General Admission' }}</span>
                                </div>
                            </div>

                            <div class="mt-4 pt-4 border-t border-black/5  flex justify-between items-center">
                                <span
                                    class="text-xs font-mono text-slate-400">#{{ strtoupper(substr($ticket->uuid, 0, 8)) }}</span>
                                <span class="text-xs text-emerald-500 font-bold flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Scanned Just Now
                                </span>
                            </div>
                        </div>

                    @elseif($status === 'duplicate' && $ticket)
                        <!-- Warning Icon -->
                        <div
                            class="w-32 h-32 rounded-full bg-amber-500 flex items-center justify-center mb-6 shadow-lg shadow-amber-500/30 animate-pulse">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                        </div>

                        <h1 class="text-4xl font-black text-amber-500 tracking-tight mb-2 uppercase">Already Scanned</h1>
                        <p class="text-slate-500  font-medium mb-8">Access Warning</p>

                        <div class="w-full bg-black/5  rounded-2xl p-6 mb-8 backdrop-blur-sm border border-amber-500/20">
                            <div class="flex flex-col gap-1 mb-4">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Original Scan</span>
                                <span
                                    class="text-lg font-bold text-slate-900 ">{{ $ticket->scanned_at->format('M d, H:i:s') }}</span>
                                <span class="text-sm text-slate-500">{{ $ticket->scanned_at->diffForHumans() }}</span>
                            </div>

                            <div class="flex flex-col gap-1 mb-4 pt-4 border-t border-black/5 ">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Guest Name</span>
                                <span class="text-xl font-bold text-slate-700 ">{{ $ticket->user_name }}</span>
                            </div>

                            <div class="mt-2 text-xs font-mono text-slate-400">
                                Ticket #{{ strtoupper(substr($ticket->uuid, 0, 8)) }}
                            </div>
                        </div>

                    @else
                        <!-- Error Icon -->
                        <div
                            class="w-32 h-32 rounded-full bg-rose-500 flex items-center justify-center mb-6 shadow-lg shadow-rose-500/30 animate-shake">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M6 18L18 6M6 6l12 12">
                                </path>
                            </svg>
                        </div>

                        <h1 class="text-4xl font-black text-rose-500 tracking-tight mb-2 uppercase">Invalid Ticket</h1>
                        <p class="text-slate-500  font-medium mb-8">Access Denied</p>

                        <div class="w-full bg-black/5  rounded-2xl p-6 mb-8 backdrop-blur-sm border border-rose-500/20">
                            <p class="text-slate-600  font-medium">The scanned code does not match any valid
                                ticket.</p>
                            <p class="text-xs font-mono text-slate-400 mt-2">Code: {{ $code ?? 'N/A' }}</p>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex flex-col w-full gap-3">
                        <a href="{{ route('scan') }}"
                            class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-4 px-6 rounded-2xl shadow-lg shadow-indigo-600/20 transition-all duration-300 transform hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            Scan Next Ticket
                        </a>
                        <a href="{{ route('admin.dashboard') }}"
                            class="w-full bg-white  hover:bg-slate-50  text-slate-700  font-bold py-4 px-6 rounded-2xl border border-slate-200  transition-colors">
                            Return to Dashboard
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes bounce-short {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10%);
            }
        }

        .animate-bounce-short {
            animation: bounce-short 0.5s ease-in-out 1;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        .animate-shake {
            animation: shake 0.4s ease-in-out 1;
        }
    </style>
@endsection