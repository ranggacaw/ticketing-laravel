@extends('layouts.app')

@section('content')
<!-- Wrapper to center the mobile-like view -->
<div class="flex items-center justify-center min-h-[calc(100vh-4rem)] bg-base-200 py-8">
    
    <!-- Phone Container -->
    <div class="max-w-97.5 w-full bg-white min-h-211 shadow-2xl rounded-[3rem] border-8 border-slate-900 overflow-hidden flex flex-col relative">
        
        <!-- Status Bar (Visual only) -->
        <div class="h-11 px-8 flex justify-between items-center bg-transparent select-none pointer-events-none">
            <span class="text-sm font-semibold text-base-content">{{ now()->format('g:i') }}</span>
            <div class="flex items-center space-x-2 text-base-content">
                <span class="material-icons text-xs">signal_cellular_alt</span>
                <span class="material-icons text-xs">wifi</span>
                <span class="material-icons text-xs">battery_full</span>
            </div>
        </div>

        <!-- Header -->
        <header class="px-6 py-4 flex items-center justify-between">
            <a href="{{ route('user.tickets.index') }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-white shadow-sm hover:bg-slate-50 transition-colors">
                <span class="material-icons text-slate-600">chevron_left</span>
            </a>
            <h1 class="text-lg font-bold text-base-content">Ticket Details</h1>
            <button class="w-10 h-10 flex items-center justify-center rounded-full bg-white shadow-sm hover:bg-slate-50 transition-colors">
                <span class="material-icons text-slate-600">ios_share</span>
            </button>
        </header>

        <!-- Main Content -->
        <main class="flex-1 px-6 pb-12 overflow-y-auto scrollbar-hide">
            
            <!-- Ticket Card -->
            <div class="relative mt-4 bg-white rounded-3xl shadow-xl shadow-primary/5 overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <span class="text-[10px] uppercase tracking-widest text-primary font-bold">Booking Confirmed</span>
                            <h2 class="text-2xl font-bold text-base-content mt-1 leading-tight">{{ $ticket->event->name }}</h2>
                        </div>
                        <div class="bg-primary/10 p-2 rounded-lg">
                            <span class="material-icons text-primary">flight_takeoff</span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-y-6">
                        <div>
                            <p class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold mb-1">Date</p>
                            <p class="text-sm font-bold text-slate-800">{{ $ticket->event->start_time->format('d M, Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold mb-1">Location</p>
                            <p class="text-sm font-bold text-slate-800 truncate max-w-[120px] ml-auto" title="{{ $ticket->event->location }}">{{ $ticket->event->location }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold mb-1">Time</p>
                            <p class="text-sm font-bold text-slate-800">{{ $ticket->event->start_time->format('h:i A') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold mb-1">Seat</p>
                            <p class="text-sm font-bold text-slate-800">{{ $ticket->seat_number ?? 'Any' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Tear Line -->
                <div class="relative flex items-center px-2">
                    <div class="w-6 h-6 rounded-full bg-white -ml-5 z-10"></div>
                    <div class="flex-1 border-t-2 border-dashed border-gray-100"></div>
                    <div class="w-6 h-6 rounded-full bg-white -mr-5 z-10"></div>
                </div>

                <!-- QR Code -->
                <div class="p-8 flex flex-col items-center justify-center">
                    <div class="bg-white p-4 rounded-2xl border-2 border-slate-50 shadow-inner">
                        <img class="w-48 h-48"
                             src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ $ticket->uuid }}"
                             alt="Ticket QR Code" />
                    </div>
                    <p class="mt-4 text-[10px] font-medium text-slate-400 tracking-[0.2em] uppercase">Scan at Entrance</p>
                </div>
            </div>

            <!-- Booking Info -->
            <div class="mt-8 space-y-4">
                <h3 class="text-sm font-bold text-base-content px-1">Booking Information</h3>
                <div class="bg-white rounded-2xl p-4 border border-primary/5">
                    <div class="flex justify-between py-2 border-b border-slate-50">
                        <span class="text-sm text-slate-500">Holder</span>
                        <span class="text-sm font-semibold text-base-content">{{ auth()->user()->name }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-50">
                        <span class="text-sm text-slate-500">Ticket ID</span>
                        <span class="text-sm font-semibold text-base-content font-mono text-xs">#{{ \Illuminate\Support\Str::limit($ticket->uuid, 8, '') }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-50">
                        <span class="text-sm text-slate-500">Event Type</span>
                        <span class="text-sm font-semibold text-base-content">{{ $ticket->type }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-sm text-slate-500">Total Paid</span>
                        <span class="text-sm font-bold text-primary">Rp {{ number_format($ticket->price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6 flex flex-col space-y-3">
                <button onclick="window.print()" class="w-full py-4 px-6 rounded-xl border-2 border-slate-100 flex items-center justify-center space-x-2 text-slate-600 font-semibold hover:bg-white transition-colors">
                    <span class="material-icons text-sm">receipt_long</span>
                    <span>View Receipt</span>
                </button>
                <button class="w-full py-4 px-6 rounded-xl bg-primary text-white flex items-center justify-center space-x-2 font-bold shadow-lg shadow-red-200 hover:bg-red-700 transition-colors">
                    <span class="material-icons text-xl">wallet</span>
                    <span>Add to Apple Wallet</span>
                </button>
            </div>

            <!-- Info Box -->
            <div class="mt-8 p-4 bg-primary/5 rounded-2xl border border-primary/10 flex items-start space-x-3">
                <span class="material-icons text-primary text-xl">lightbulb</span>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Please arrive at the venue at least <span class="font-bold text-base-content">45 minutes</span> before the event starts. Your screen brightness will automatically increase for scanning.
                </p>
            </div>

            <!-- Testimonial Section (only if past) -->
            @if($ticket->event->end_time->isPast())
                <div class="mt-8 pt-8 border-t border-slate-200">
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                        <h3 class="text-lg font-bold text-base-content mb-4 text-center">How was the event?</h3>

                        @if($ticket->testimonial)
                            <div class="text-center">
                                <div class="flex justify-center gap-1 mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="material-icons text-xl {{ $i <= $ticket->testimonial->rating ? 'text-amber-400' : 'text-slate-200' }}">star</span>
                                    @endfor
                                </div>
                                <p class="text-slate-600 italic">"{{ $ticket->testimonial->comment }}"</p>
                                <p class="text-xs text-slate-400 mt-2">Submitted on
                                    {{ $ticket->testimonial->created_at->format('M d, Y') }}</p>
                            </div>
                        @else
                            <form action="{{ route('user.testimonials.store') }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                <input type="hidden" name="rating" id="rating" value="5">

                                <div class="flex justify-center gap-2" x-data="{ rating: 5 }">
                                    <template x-for="i in 5">
                                        <button type="button" @click="rating = i; document.getElementById('rating').value = i"
                                            class="focus:outline-none transition-transform hover:scale-110">
                                            <span class="material-icons text-3xl"
                                                :class="i <= rating ? 'text-amber-400' : 'text-slate-200'">star</span>
                                        </button>
                                    </template>
                                </div>

                                <div>
                                    <textarea name="comment" rows="3"
                                        class="w-full rounded-xl border-slate-200 bg-slate-50 focus:border-indigo-500 focus:ring-indigo-500 text-sm p-3"
                                        placeholder="Share your experience..."></textarea>
                                </div>

                                <button type="submit"
                                    class="w-full bg-slate-900 text-white font-bold py-3 rounded-xl hover:opacity-90 transition-opacity">
                                    Submit Review
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif

        </main>

        <!-- Home Indicator Visual -->
        <div class="h-6 flex justify-center items-center pb-2 bg-white">
            <div class="w-32 h-1 bg-slate-200 rounded-full"></div>
        </div>

        <!-- Decorative Blurs -->
        <div class="absolute -top-24 -right-24 w-48 h-48 bg-primary/10 blur-[60px] rounded-full pointer-events-none"></div>
        <div class="absolute top-1/2 -left-24 w-48 h-48 bg-primary/5 blur-[60px] rounded-full pointer-events-none"></div>
    </div>
</div>

<style>
    /* Ensure material icons use the correct font family */
    .material-icons {
        font-family: 'Material Icons';
        font-weight: normal;
        font-style: normal;
        font-size: 24px;
        display: inline-block;
        line-height: 1;
        text-transform: none;
        letter-spacing: normal;
        word-wrap: normal;
        white-space: nowrap;
        direction: ltr;
        /* Support for all WebKit browsers. */
        -webkit-font-smoothing: antialiased;
        /* Support for Safari and Chrome. */
        text-rendering: optimizeLegibility;
        /* Support for Firefox. */
        -moz-osx-font-smoothing: grayscale;
        /* Support for IE. */
        font-feature-settings: 'liga';
    }
</style>
@endsection
