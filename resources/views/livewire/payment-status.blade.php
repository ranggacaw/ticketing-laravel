<div wire:poll.5s="checkStatus" class="flex flex-col items-center justify-center min-h-[70vh] py-12 font-display relative w-full">
    @if(!$ticket)
        <div class="text-rose-500">Error: Ticket not loaded.</div>
    @else
        <!-- Animation/Icon Container -->
        <div class="relative mb-10">
            @if($status === 'pending')
                <div class="absolute inset-0 bg-amber-200 blur-3xl opacity-20 rounded-full animate-pulse"></div>
                <div class="relative w-24 h-24 bg-amber-50 rounded-[2.5rem] flex items-center justify-center shadow-2xl shadow-amber-100 border border-amber-100 transform -rotate-6">
                    <span class="material-symbols-outlined text-amber-500 text-5xl">pending_actions</span>
                </div>
            @elseif($status === 'paid' || $status === 'issued')
                <div class="absolute inset-0 bg-emerald-200 blur-3xl opacity-20 rounded-full animate-pulse"></div>
                <div class="relative w-24 h-24 bg-emerald-50 rounded-[2.5rem] flex items-center justify-center shadow-2xl shadow-emerald-100 border border-emerald-100 transform -rotate-6">
                    <span class="material-symbols-outlined text-emerald-500 text-5xl">check_circle</span>
                </div>
            @else
                <div class="absolute inset-0 bg-rose-200 blur-3xl opacity-20 rounded-full animate-pulse"></div>
                <div class="relative w-24 h-24 bg-rose-50 rounded-[2.5rem] flex items-center justify-center shadow-2xl shadow-rose-100 border border-rose-100 transform -rotate-6">
                    <span class="material-symbols-outlined text-rose-500 text-5xl">cancel</span>
                </div>
            @endif
        </div>

        <!-- Message -->
        <div class="text-center mb-12 px-4 transition-all duration-500">
            @if($status === 'pending')
                <h1 class="text-4xl md:text-5xl font-black text-slate-900 mb-4 tracking-tighter">
                    Payment Under Review
                </h1>
                <p class="text-slate-500 text-lg font-medium max-w-lg mx-auto leading-relaxed">
                    We have received your payment proof. Please wait while our team verifies your transaction.
                    <br>This page will update automatically.
                </p>
                <div class="mt-4 flex justify-center">
                     <svg class="animate-spin h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            @elseif($status === 'paid' || $status === 'issued')
                <h1 class="text-4xl md:text-5xl font-black text-slate-900 mb-4 tracking-tighter">
                    Payment Confirmed!
                </h1>
                <p class="text-emerald-600 text-lg font-medium max-w-lg mx-auto leading-relaxed">
                    Your tickets have been issued and sent to your email.
                </p>
            @else
                 <h1 class="text-4xl md:text-5xl font-black text-slate-900 mb-4 tracking-tighter">
                    Payment {{ ucfirst($status) }}
                </h1>
                <p class="text-rose-500 text-lg font-medium max-w-lg mx-auto leading-relaxed">
                    There was an issue with your payment. Please contact support.
                </p>
            @endif
        </div>

        <!-- Ticket Summary Card -->
        <div class="w-full max-w-md bg-white rounded-[3rem] p-8 shadow-2xl shadow-slate-200/60 border border-slate-100 relative overflow-hidden group transition-all duration-500">
            <!-- Decorative Background Elements -->
            <div class="absolute -right-12 -top-12 w-40 h-40 bg-indigo-500/5 rounded-full blur-3xl group-hover:bg-indigo-500/10 transition-colors"></div>

            <div class="relative z-10">
                <!-- Header Info -->
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <span class="text-[9px] font-black text-indigo-500 uppercase tracking-[0.2em] mb-2 block">Official Ticket</span>
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
                        <span class="text-[9px] text-slate-400 font-bold uppercase tracking-widest block mb-1">Pass Type</span>
                        <span class="font-black text-slate-900">{{ $ticket->ticketType->name }}</span>
                    </div>
                    <div class="text-right">
                        <span class="text-[9px] text-slate-400 font-bold uppercase tracking-widest block mb-1">Amount</span>
                        <span class="font-black text-slate-900 text-lg">
                            Rp {{ number_format($ticket->price, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <!-- Ticket Stub Cutout Design -->
                <div class="relative flex items-center justify-center py-6 border-t border-slate-50">
                    <div class="absolute -left-12 w-8 h-8 rounded-full bg-slate-50 border-r border-slate-100"></div>
                    <div class="absolute -right-12 w-8 h-8 rounded-full bg-slate-50 border-l border-slate-100"></div>

                    <!-- Stylized QR Placeholder -->
                    <div class="flex flex-col items-center">
                        <div class="p-4 bg-slate-50 rounded-3xl border border-slate-100 mb-3 group-hover:scale-105 transition-transform">
                             <!-- Show QR only if paid/issued -->
                             @if($status === 'paid' || $status === 'issued')
                                 <div class="w-20 h-20 bg-white shadow-inner flex items-center justify-center relative overflow-hidden rounded-xl border border-slate-100">
                                     {!! QrCode::size(70)->generate($ticket->uuid) !!}
                                 </div>
                             @else
                                <div class="w-20 h-20 bg-slate-100 shadow-inner flex items-center justify-center relative overflow-hidden rounded-xl border border-slate-200 opacity-50">
                                    <span class="material-symbols-outlined text-slate-300 text-4xl">lock</span>
                                </div>
                             @endif
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
               class="w-full py-5 bg-indigo-600 text-white font-black rounded-3xl shadow-2xl shadow-indigo-200 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-3 uppercase tracking-[0.2em] text-xs">
                View My Tickets
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>

            <a href="{{ route('home') }}"
               class="w-full py-5 bg-white text-slate-900 border-2 border-slate-100 font-black rounded-3xl hover:bg-slate-50 transition-all flex items-center justify-center gap-2 uppercase tracking-[0.2em] text-xs">
                Back Home
            </a>
        </div>
    @endif
</div>
