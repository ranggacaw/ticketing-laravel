<div class="flex flex-col items-center gap-6 p-4">
    <div class="w-full bg-slate-50 dark:bg-slate-950/40 rounded-3xl p-6 border border-slate-200 dark:border-white/5">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest">Attendee</h4>
                <p class="text-lg font-bold text-slate-900 dark:text-white">{{ $ticket->user_name }}</p>
            </div>
            <div class="text-right">
                <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest">Seat</h4>
                <p class="text-lg font-black text-indigo-500 font-mono">{{ $ticket->seat_number }}</p>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-slate-200 dark:border-white/5">
            <div>
                <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest">Category</h4>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase border border-indigo-500/20 bg-indigo-500/10 text-indigo-400">
                    {{ $ticket->type }}
                </span>
            </div>
            <div class="text-right">
                <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest">Price</h4>
                <p class="text-sm font-bold text-slate-900 dark:text-white">Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
        <!-- QR Code -->
        <div class="bg-white p-6 rounded-2xl shadow-xl shadow-black/5 border border-slate-100 flex flex-col items-center">
            <h5 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">QR System</h5>
            <div class="qr-container">
                {!! $qrCode !!}
            </div>
        </div>

        <!-- Barcode -->
        <div class="bg-white p-6 rounded-2xl shadow-xl shadow-black/5 border border-slate-100 flex flex-col items-center">
            <h5 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">Linear 1D</h5>
            <div class="barcode-container w-full flex flex-col items-center">
                <div class="barcode-svg-wrapper w-full h-12 flex items-center justify-center">
                    {!! $barcode128 !!}
                </div>
                <p class="text-[10px] font-mono text-slate-400 mt-2 tracking-widest">{{ $ticket->barcode_data }}</p>
            </div>
        </div>
    </div>

    <div class="w-full mt-2 space-y-3">
        @if(!$ticket->scanned_at)
        <form action="{{ route('validate') }}" method="POST" target="_blank" class="w-full">
            @csrf
            <input type="hidden" name="code" value="{{ $ticket->barcode_data }}">
            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3 px-6 rounded-2xl transition-all duration-300 flex items-center justify-center gap-2 shadow-lg shadow-emerald-600/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Simulate External Scan
            </button>
        </form>
        @else
        <div class="w-full bg-emerald-500/10 border border-emerald-500/20 rounded-2xl p-4 flex items-center gap-4 text-emerald-600 dark:text-emerald-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <p class="text-xs font-bold uppercase tracking-wider">Ticket already validated</p>
        </div>
        @endif

        <div class="bg-indigo-500/5 border border-indigo-500/10 rounded-2xl p-4 flex items-center gap-4 text-indigo-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
            </svg>
            <p class="text-xs leading-tight">This is a real-time preview of the barcode that will be printed. Ensure the 1D barcode is at least 3cm wide for optimal scanning.</p>
        </div>
    </div>
</div>

<style>
    .qr-container svg {
        width: 120px !important;
        height: 120px !important;
    }
    .barcode-svg-wrapper svg {
        width: 100% !important;
        height: 48px !important;
    }
</style>
