@extends('layouts.admin')

@section('content')
    <div class="max-w-6xl mx-auto animate-in fade-in duration-700">
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <a href="{{ route('admin.tickets.index') }}"
                    class="flex items-center gap-2 text-slate-400 hover:text-slate-200 transition-colors text-sm font-medium mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to List
                </a>
                <h2 class="text-3xl font-bold tracking-tight">Ticket <span class="gradient-text">Preview</span></h2>
                <p class="text-xs font-mono text-slate-500 mt-1 uppercase tracking-tighter">ID: {{ $ticket->uuid }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.tickets.edit', $ticket) }}"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-xl border border-white/10 text-slate-300 hover:bg-white/5 transition-all text-sm font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.tickets.export', $ticket) }}"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white transition-all text-sm font-bold shadow-lg shadow-indigo-600/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download PDF
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <!-- Details Column -->
            <div class="lg:col-span-1 space-y-6">
                <div class="glass-card rounded-3xl p-8 border-white/10">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-6 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Guest Info
                    </h3>
                    <dl class="space-y-6">
                        <div>
                            <dt class="text-xs text-slate-500 mb-1">Full Name</dt>
                            <dd class="text-lg font-bold text-slate-100">{{ $ticket->user_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-slate-500 mb-1">Email Address</dt>
                            <dd class="text-sm text-slate-300">{{ $ticket->user_email }}</dd>
                        </div>
                        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-white/5">
                            <div>
                                <dt class="text-xs text-slate-500 mb-1">Seat</dt>
                                <dd class="text-lg font-black text-indigo-400 font-mono tracking-tighter">
                                    {{ $ticket->seat_number }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-slate-500 mb-1">Category</dt>
                                <dd class="text-sm">
                                    @php
                                        $typeClasses = match ($ticket->type) {
                                            'VVIP' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                            'VIP' => 'bg-amber-500/10 text-amber-500 border-amber-500/20',
                                            'Festival' => 'bg-sky-500/10 text-sky-400 border-sky-500/20',
                                            'General Admission' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                            default => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
                                        };
                                    @endphp
                                    <span
                                        class="px-2.5 py-1 rounded-full border text-xs font-bold uppercase {{ $typeClasses }}">{{ $ticket->type }}</span>
                                </dd>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-white/5 space-y-4">
                            <div>
                                <dt class="text-xs text-slate-500 mb-1">Validation Status</dt>
                                <dd>
                                    @if($ticket->scanned_at)
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-500/10 text-emerald-400 text-xs font-black uppercase tracking-wider border border-emerald-500/20">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Validated
                                        </span>
                                        <p class="text-[10px] text-slate-500 mt-2">Scanned on:
                                            {{ $ticket->scanned_at->format('M d, Y H:i:s') }}</p>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white/5 text-slate-500 text-xs font-black uppercase tracking-wider border border-white/10">
                                            Pending Scan
                                        </span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs text-slate-500 mb-1">Price Paid</dt>
                                <dd class="text-2xl font-bold gradient-text">Rp
                                    {{ number_format($ticket->price, 0, ',', '.') }}</dd>
                            </div>
                        </div>
                    </dl>
                </div>

                <div class="glass border-white/5 rounded-2xl p-6 relative overflow-hidden group">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Validation Hash</h4>
                    </div>
                    <div class="flex gap-2">
                        <div id="validation-hash-content"
                            class="flex-1 text-[10px] font-mono bg-black/40 p-3 rounded-lg border border-white/5 break-all text-slate-500 select-all">
                            {{ $ticket->barcode_data }}
                        </div>
                        <button onclick="copyValidationHash()"
                            class="shrink-0 flex items-center justify-center w-10 bg-white/5 hover:bg-indigo-500/20 border border-white/5 hover:border-indigo-500/30 rounded-lg transition-all group/btn cursor-pointer"
                            title="Copy Hash">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 text-slate-400 group-hover/btn:text-indigo-400 transition-colors" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </button>
                    </div>
                    <!-- Success Toast Overlay -->
                    <div id="copy-toast"
                        class="absolute inset-0 bg-indigo-600/50 backdrop-blur-sm flex items-center justify-center translate-y-full transition-transform duration-300 rounded-2xl z-10">
                        <p class="text-white font-bold text-xs flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Copied to Clipboard!
                        </p>
                    </div>
                </div>
            </div>

            <!-- Previews Column -->
            <div class="lg:col-span-2 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- QR Code -->
                    <div class="glass-card rounded-3xl p-8 border-white/10 flex flex-col items-center">
                        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-8 self-start">Matrix (QR)
                            Format</h3>
                        <div class="bg-white p-6 rounded-2xl shadow-2xl shadow-white/5 border-4 border-white/10">
                            {!! $qrCode !!}
                        </div>
                        <p class="mt-8 text-xs text-slate-500 text-center font-light leading-relaxed">
                            High-density matrix code optimized for<br />modern camera-based scanners.
                        </p>
                    </div>

                    <!-- 1D Barcode -->
                    <div class="glass-card rounded-3xl p-8 border-white/10 flex flex-col items-center">
                        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-8 self-start">Linear (1D)
                            Format</h3>
                        <div
                            class="barcode-preview bg-white w-full py-10 px-6 rounded-2xl flex flex-col items-center justify-center border-4 border-white/10 shadow-2xl shadow-white/5 overflow-hidden">
                            <div class="barcode-svg-container">
                                {!! $barcode128 !!}
                            </div>
                            <div class="mt-4 text-[10px] font-mono text-slate-500 font-medium tracking-widest">
                                {{ $ticket->barcode_data }}</div>
                        </div>
                        <p class="mt-8 text-xs text-slate-500 text-center font-light leading-relaxed">
                            Legacy-compatible linear barcode for<br />traditional laser scanning hardware.
                        </p>
                    </div>
                </div>

                <!-- Simulation Banner -->
                <div class="glass-card rounded-3xl p-6 border-indigo-500/20 bg-indigo-500/5 flex items-center gap-6">
                    <div
                        class="w-12 h-12 rounded-2xl bg-indigo-500/20 flex items-center justify-center text-indigo-400 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-200">Validation Simulator Ready</h4>
                        <p class="text-xs text-slate-500 mt-1">This ticket can be scanned using the front-end simulation
                            interface to test entry flow.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        function copyValidationHash() {
            const content = document.getElementById('validation-hash-content').innerText.trim();

            // Try modern API
            if (navigator.clipboard) {
                navigator.clipboard.writeText(content).then(() => {
                    showToast();
                }).catch(err => {
                    console.error('Clipboard API failed', err);
                    fallbackCopy(content);
                });
            } else {
                fallbackCopy(content);
            }
        }

        function fallbackCopy(text) {
            const textArea = document.createElement("textarea");
            textArea.value = text;
            textArea.style.position = "fixed";
            textArea.style.opacity = "0";
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            try {
                document.execCommand('copy');
                showToast();
            } catch (err) {
                console.error('Fallback copy failed', err);
                alert('Unable to copy automatically. Please copy manually: ' + text);
            }
            document.body.removeChild(textArea);
        }

        function showToast() {
            const toast = document.getElementById('copy-toast');
            if (toast) {
                toast.classList.remove('translate-y-full');
                setTimeout(() => {
                    toast.classList.add('translate-y-full');
                }, 2000);
            }
        }
    </script>
@endsection