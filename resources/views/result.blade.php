@extends('layouts.app')

@section('content')
<div class="space-y-8 text-center animate-in zoom-in-95 duration-500">
    @if($status === 'valid')
        <!-- SUCCESS STATE -->
        <div class="flex flex-col items-center">
            <div class="w-24 h-24 bg-emerald-500 rounded-full flex items-center justify-center shadow-2xl shadow-emerald-500/40 mb-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            
            <h1 class="text-4xl font-black text-emerald-400">ENTRY GRANTED</h1>
            <p class="text-slate-400 mt-2 font-medium">Ticket code: <span class="text-white">{{ $code }}</span></p>
        </div>

        <div class="glass rounded-[2.5rem] p-8 space-y-8 text-left relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 -mr-12 -mt-12 rounded-full"></div>
            
            <div class="grid grid-cols-2 gap-8">
                <div class="space-y-1">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-slate-500 font-bold">Attendee Name</p>
                    <p class="text-lg font-bold">{{ $ticket->user_name }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-slate-500 font-bold">Ticket Type</p>
                    <p class="text-lg font-bold">{{ $ticket->type }}</p>
                </div>
                <div class="col-span-2 space-y-1">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-slate-500 font-bold">Allocated Seat</p>
                    <p class="text-lg font-bold">{{ $ticket->seat_number }}</p>
                </div>
            </div>

            <div class="border-t border-white/10 pt-6">
                <div class="flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    <p class="text-sm font-medium text-emerald-400 uppercase tracking-widest">Active Session Verified</p>
                </div>
            </div>
        </div>

    @elseif($status === 'duplicate')
        <!-- DUPLICATE STATE -->
        <div class="flex flex-col items-center">
            <div class="w-24 h-24 bg-amber-500 rounded-full flex items-center justify-center shadow-2xl shadow-amber-500/40 mb-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            
            <h1 class="text-4xl font-black text-amber-500 uppercase tracking-tight leading-none">Already<br>Scanned</h1>
            <p class="text-slate-400 mt-4 font-medium">Code: <span class="text-white">{{ $code }}</span></p>
        </div>

        <div class="glass rounded-[2rem] p-6 text-sm text-amber-200/60 bg-amber-500/10 border-amber-500/20">
            This ticket was validated at <span class="text-amber-300 font-bold">{{ $ticket->scanned_at->format('M d, Y h:i A') }}</span>. Please refer the attendee to the information desk.
        </div>

    @else
        <!-- INVALID STATE -->
        <div class="flex flex-col items-center">
            <div class="w-24 h-24 bg-rose-500 rounded-full flex items-center justify-center shadow-2xl shadow-rose-500/40 mb-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
            
            <h1 class="text-4xl font-black text-rose-500">INVALID CODE</h1>
            <p class="text-slate-400 mt-2 font-medium">Entered: <span class="text-white">{{ $code ?: 'N/A' }}</span></p>
        </div>

        <div class="glass rounded-[2rem] p-6 text-sm text-rose-200/60 bg-rose-500/10 border-rose-500/20">
            The provided ticket code was not found in our database. Ensure the code is entered correctly or try scanning again.
        </div>
    @endif

    <div class="pt-8 space-y-4">
        <a href="{{ route('scan') }}" class="block w-full bg-white/10 hover:bg-white/20 text-white font-bold py-4 rounded-2xl transition-all border border-white/10">
            Scan Next Ticket
        </a>
        <p class="text-xs text-slate-500">Redirecting in <span id="timer">3</span> seconds...</p>
    </div>
</div>

<script>
    let timeLeft = 3;
    const timerElement = document.getElementById('timer');
    
    const interval = setInterval(() => {
        timeLeft--;
        if (timerElement) timerElement.textContent = timeLeft;
        if (timeLeft <= 0) {
            clearInterval(interval);
            window.location.href = "{{ route('scan') }}";
        }
    }, 1000);

    // Simulated Analytics
    console.log('📊 Analytics: [validation_result]', {
        status: "{{ $status }}",
        code: "{{ $code }}",
        timestamp: new Date().toISOString(),
        mock_latency_ms: Math.floor(Math.random() * 200) + 100
    });
</script>
@endsection
