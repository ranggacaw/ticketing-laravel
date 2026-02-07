<div class="flex flex-col gap-6 p-2 sm:p-6 overflow-x-hidden">
    <div class="grid grid-cols-1 gap-6 w-full">
        <!-- Ticket Info Card -->
        <div class="w-full glass border-white/10 rounded-3xl p-6 sm:p-8 relative overflow-hidden">
            <!-- Accent Glow -->
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-indigo-500/10 blur-3xl rounded-full"></div>
            
            <div class="relative z-10">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                    <div>
                        <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-1">Attendee</h4>
                        <p class="text-xl font-bold text-slate-900 dark:text-white leading-tight">{{ $ticket->user_name }}</p>
                        <p class="text-xs text-slate-400 mt-1 font-mono tracking-tighter opacity-70">{{ $ticket->uuid }}</p>
                    </div>
                    <div class="sm:text-right flex sm:flex-col items-center sm:items-end gap-3 sm:gap-0">
                        <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-1">Seat Assignment</h4>
                        <p class="text-2xl font-black text-indigo-500 font-mono tracking-tighter">{{ $ticket->seat_number }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6 pt-6 border-t border-white/5">
                    <div>
                        <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-2">Category</h4>
                        @php
                            $typeClasses = match($ticket->type) {
                                'VVIP' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                'VIP' => 'bg-amber-500/10 text-amber-500 border-amber-500/20',
                                'Festival' => 'bg-sky-500/10 text-sky-400 border-sky-500/20',
                                'General Admission' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                default => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
                            };
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black uppercase border {{ $typeClasses }}">
                            {{ $ticket->type }}
                        </span>
                    </div>
                    <div class="text-right">
                        <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-1">Total Paid</h4>
                        <p class="text-lg font-bold gradient-text">Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- QR Code -->
        <div class="glass-card rounded-3xl p-6 sm:p-8 border-white/5 flex flex-col items-center justify-center group transition-all duration-300 hover:border-indigo-500/20">
            <h3 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-6 self-start">Matrix (QR)</h3>
            <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-2xl shadow-black/10 border-4 border-white/10 transition-transform group-hover:scale-[1.02]">
                <div class="qr-container">
                    {!! $qrCode !!}
                </div>
            </div>
            <p class="mt-6 text-[10px] text-slate-500 text-center font-medium opacity-60">High-density scanning optimization</p>
        </div>
    </div>
    
    <!-- Codes Grid -->
    <div class="grid grid-cols-1 gap-6 w-full">
        <!-- Linear Barcode / Asset Details -->
        <div class="glass-card rounded-[2rem] p-6 sm:p-8 border-white/5 flex flex-col gap-6 group transition-all duration-300 hover:border-indigo-500/20">
            <div class="flex items-center justify-between">
                <h3 class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-0 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Asset Specs
                </h3>
                <span class="text-[9px] font-mono text-indigo-400 bg-indigo-500/10 px-2 py-0.5 rounded border border-indigo-500/20 font-bold uppercase tracking-tighter">Verified</span>
            </div>
            
            <div class="bg-white w-full py-5 px-0 sm:px-0 rounded-2xl shadow-xl shadow-black/10 border-4 border-white/10 flex flex-col items-center justify-center transition-transform group-hover:scale-[1.01] overflow-hidden">
                <div class="barcode-svg-wrapper w-full flex justify-center">
                    {!! $barcode128 !!}
                </div>
                <p class="mt-4 text-[9px] font-mono text-slate-400 tracking-[0.5em] font-black uppercase opacity-60">{{ $ticket->barcode_data }}</p>
            </div>

            <div class="space-y-4 pt-2">
                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-white/5">
                    <div>
                        <dt class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-1">Symbology</dt>
                        <dd class="text-[10px] text-slate-300 font-mono font-bold">CODE-128B</dd>
                    </div>
                    <div class="text-right">
                        <dt class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-1">DPI Opt.</dt>
                        <dd class="text-[10px] text-emerald-400 font-mono font-bold">300x(High)</dd>
                    </div>
                </div>
                <div>
                    <dt class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <span class="w-1 h-1 rounded-full bg-indigo-400"></span>
                        Internal Validation Hash
                    </dt>
                    <dd class="text-[10px] font-mono bg-black/40 p-3.5 rounded-xl border border-white/5 break-all text-slate-500/80 leading-relaxed shadow-inner">
                        {{ $ticket->barcode_data }}
                    </dd>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .qr-container svg {
        width: clamp(100px, 20vw, 140px) !important;
        height: auto !important;
        max-width: 100%;
    }
    .barcode-svg-wrapper svg {
        width: 100% !important;
        height: auto !important;
        min-height: 48px;
        max-height: 80px;
    }
</style>
