@extends('layouts.app')

@section('content')
<div x-data="{ mode: 'scan', loading: false }" class="space-y-6">
    <div class="flex items-center justify-between mb-8">
        <a href="{{ route('home') }}" class="p-2 -ml-2 text-slate-400 hover:text-white transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h2 class="text-lg font-semibold uppercase tracking-widest text-slate-500">Gate A1</h2>
        <div class="w-10"></div>
    </div>

    <!-- Mode Switcher -->
    <div class="glass p-1 rounded-2xl flex">
        <button @click="mode = 'scan'" :class="mode === 'scan' ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400'" class="flex-1 py-2 rounded-xl text-sm font-semibold transition-all duration-300">
            Scanner UI
        </button>
        <button @click="mode = 'manual'" :class="mode === 'manual' ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400'" class="flex-1 py-2 rounded-xl text-sm font-semibold transition-all duration-300">
            Manual IO
        </button>
    </div>

    <!-- Scanner View -->
    <div x-show="mode === 'scan'" x-transition class="space-y-8 py-4">
        <div class="relative aspect-square w-full glass rounded-[3rem] overflow-hidden flex items-center justify-center">
            <!-- Simulated Camera Feed -->
            <div class="absolute inset-4 border-2 border-indigo-500/30 rounded-[2.5rem]"></div>
            <div class="absolute top-1/2 left-0 w-full h-[2px] bg-indigo-500/50 shadow-[0_0_15px_rgba(99,102,241,0.5)] animate-scan-line"></div>
            
            <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32 text-indigo-500/20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1V5a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1V5a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2" />
            </svg>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <form action="{{ route('validate') }}" method="POST">
                @csrf
                <input type="hidden" name="code" value="TICKET-123">
                <button type="submit" class="w-full glass hover:bg-white/10 text-emerald-400 border-emerald-500/30 font-medium py-4 rounded-2xl transition-all">
                    Test Success
                </button>
            </form>
            <form action="{{ route('validate') }}" method="POST">
                @csrf
                <input type="hidden" name="code" value="BAD-CODE">
                <button type="submit" class="w-full glass hover:bg-white/10 text-rose-400 border-rose-500/30 font-medium py-4 rounded-2xl transition-all">
                    Test Failure
                </button>
            </form>
            <form action="{{ route('validate') }}" method="POST" class="col-span-2">
                @csrf
                <input type="hidden" name="code" value="TICKET-456">
                <button type="submit" class="w-full glass hover:bg-white/10 text-amber-400 border-amber-500/30 font-medium py-4 rounded-2xl transition-all">
                    Test Duplicate
                </button>
            </form>
        </div>
    </div>

    <!-- Manual View -->
    <div x-show="mode === 'manual'" x-transition class="glass rounded-3xl p-8 space-y-6">
        <form action="{{ route('validate') }}" method="POST" class="space-y-6">
            @csrf
            <div class="space-y-2">
                <label class="text-sm font-medium text-slate-400">Barcode / Ticket ID</label>
                <input type="text" name="code" placeholder="XXX-XXX-XXX" required class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-4 text-center text-2xl font-bold tracking-widest focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all placeholder:text-slate-700">
            </div>
            
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-4 rounded-2xl transition-all flex items-center justify-center gap-2">
                Validate Code
            </button>
        </form>

        <div class="text-center">
            <p class="text-xs text-slate-500">Hint: Try <code class="text-indigo-400">TICKET-123</code> or <code class="text-indigo-400">TICKET-789</code></p>
        </div>
    </div>
</div>

<style>
    @keyframes scan {
        0% { top: 10%; }
        50% { top: 90%; }
        100% { top: 10%; }
    }
    .animate-scan-line {
        animation: scan 3s linear infinite;
    }
</style>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                const method = form.querySelector('input[name="code"]').type === 'hidden' ? 'camera' : 'manual';
                console.log('📊 Analytics: [scan_attempt]', {
                    method: method,
                    timestamp: new Date().toISOString()
                });
            });
        });
    });
</script>
@endsection

