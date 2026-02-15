@extends('user.layouts.app')

@section('content')
    <div class="flex flex-col items-center justify-center min-h-[70vh] py-12 font-display">
        <!-- Animation/Icon Container -->
        <div class="relative mb-10">
            @if($ticket->payment_status === 'pending')
                <div class="absolute inset-0 bg-amber-200 blur-3xl opacity-20 rounded-full animate-pulse"></div>
                <div class="relative w-24 h-24 bg-amber-50 rounded-[2.5rem] flex items-center justify-center shadow-2xl shadow-amber-100 border border-amber-100 transform -rotate-6">
                    <span class="material-symbols-outlined text-amber-500 text-5xl">pending_actions</span>
                </div>
            @else
                <div class="absolute inset-0 bg-emerald-200 blur-3xl opacity-20 rounded-full animate-pulse"></div>
                <div class="relative w-24 h-24 bg-emerald-50 rounded-[2.5rem] flex items-center justify-center shadow-2xl shadow-emerald-100 border border-emerald-100 transform -rotate-6">
                    <span class="material-symbols-outlined text-emerald-500 text-5xl">check_circle</span>
                </div>
            @endif
        </div>

        <!-- Message -->
        <div class="text-center mb-12 px-4">
            @if($ticket->payment_status === 'pending')
                <h1 class="text-4xl md:text-5xl font-black text-slate-900 mb-4 tracking-tighter">
                    Payment Under Review
                </h1>
                <p class="text-slate-500 text-lg font-medium max-w-lg mx-auto leading-relaxed">
                    We have received your payment proof. Please wait while our team verifies your transaction. Redirecting to your dashboard...
                </p>
            @else
                <h1 class="text-4xl md:text-5xl font-black text-slate-900 mb-4 tracking-tighter">
                    Payment Success!
                </h1>
                <p class="text-slate-500 text-lg font-medium max-w-md mx-auto leading-relaxed">
                    Thank you for your purchase. We've sent your digital ticket and receipt to
                    <span class="text-primary-ref font-bold">{{ $ticket->user_email }}</span>
                </p>
            @endif
        </div>

        <!-- Ticket Summary Card - Matching Dashboard App Card Style -->
        <div
            class="w-full max-w-md bg-white rounded-[3rem] p-8 shadow-2xl shadow-slate-200/60 border border-slate-100 relative overflow-hidden group">
            <!-- Decorative Background Elements -->
            <div
                class="absolute -right-12 -top-12 w-40 h-40 bg-primary-ref/5 rounded-full blur-3xl group-hover:bg-primary-ref/10 transition-colors">
            </div>

            <div class="relative z-10">
                <!-- Header Info -->
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <span class="text-[9px] font-black text-primary-ref uppercase tracking-[0.2em] mb-2 block">Official
                            Ticket</span>
                        <h2 class="text-2xl font-black text-slate-900 leading-tight">
                            {{ $ticket->event->name }}
                        </h2>
                        <div class="flex items-center gap-1 text-slate-400 mt-1">
                            <span class="material-symbols-outlined text-sm">location_on</span>
                            <span class="text-xs font-bold">{{ $ticket->event->venue->name ?? 'Venue TBD' }}</span>
                        </div>
                    </div>
                    <!-- Stylized Ticket Logo/Icon -->
                    <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center border border-slate-100">
                        <span class="material-symbols-outlined text-slate-400">confirmation_number</span>
                    </div>
                </div>

                <!-- Ticket Details Grid -->
                <div class="grid grid-cols-2 gap-y-6 gap-x-4 mb-8">
                    <div>
                        <span class="text-[9px] text-slate-400 font-bold uppercase tracking-widest block mb-1">Pass
                            Type</span>
                        <span class="font-black text-slate-900">{{ $ticket->ticketType->name }}</span>
                    </div>
                    <div class="text-right">
                        <span class="text-[9px] text-slate-400 font-bold uppercase tracking-widest block mb-1">Amount</span>
                        <span class="font-black text-slate-900 text-lg">
                            Rp {{ number_format($ticket->price, 0, ',', '.') }}
                        </span>
                    </div>
                    <div>
                        <span class="text-[9px] text-slate-400 font-bold uppercase tracking-widest block mb-1">Date</span>
                        <span class="font-black text-slate-900">
                            {{ $ticket->event->start_time ? $ticket->event->start_time->format('M d, Y') : 'TBA' }}
                        </span>
                    </div>
                    <div class="text-right">
                        <span class="text-[9px] text-slate-400 font-bold uppercase tracking-widest block mb-1">Time</span>
                        <span class="font-black text-slate-900">
                            {{ $ticket->event->start_time ? $ticket->event->start_time->format('h:i A') : 'TBA' }}
                        </span>
                    </div>
                </div>

                <!-- Ticket Stub Cutout Design -->
                <div class="relative flex items-center justify-center py-6 border-t border-slate-50">
                    <div class="absolute -left-12 w-8 h-8 rounded-full bg-slate-50 border-r border-slate-100"></div>
                    <div class="absolute -right-12 w-8 h-8 rounded-full bg-slate-50 border-l border-slate-100"></div>

                    <!-- Stylized QR Placeholder -->
                    <div class="flex flex-col items-center">
                        <div
                            class="p-4 bg-slate-50 rounded-3xl border border-slate-100 mb-3 group-hover:scale-105 transition-transform">
                            <div
                                class="w-20 h-20 bg-white shadow-inner flex items-center justify-center relative overflow-hidden rounded-xl border border-slate-100">
                                <span class="material-symbols-outlined text-slate-200 text-5xl">qr_code_2</span>
                                <!-- Small branding in QR -->
                                <div class="absolute inset-0 flex items-center justify-center opacity-10">
                                    <span class="font-black text-[8px] uppercase tracking-tighter">Tiketcaw</span>
                                </div>
                            </div>
                        </div>
                        <span class="text-[10px] font-mono font-bold text-slate-300 tracking-wider">
                            {{ strtoupper(substr($ticket->uuid, 0, 8)) }}...
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feedback & Next Steps -->
        <div class="mt-12 flex flex-col items-center gap-6 w-full max-w-sm px-4">
            <a href="{{ route('user.tickets.index') }}"
                class="w-full py-5 bg-primary-ref text-white font-black rounded-3xl shadow-2xl shadow-red-200 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-3 uppercase tracking-[0.2em] text-xs">
                View My Tickets
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>

            <a href="{{ route('events.index') }}"
                class="w-full py-5 bg-white text-slate-900 border-2 border-slate-100 font-black rounded-3xl hover:bg-slate-50 transition-all flex items-center justify-center gap-2 uppercase tracking-[0.2em] text-xs">
                Browse More Events
            </a>
        </div>
    </div>
@endsection