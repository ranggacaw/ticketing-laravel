@extends('user.layouts.app')

@section('content')
    <div class="min-h-screen -mx-4 md:-mx-8 bg-white font-display px-6">
        <!-- Header -->
        <x-page-header title="Ticket Details" subtitle="Event confirmation and your entry pass">
            <x-slot:action>
                <button onclick="window.print()"
                    class="p-2 bg-slate-50 rounded-full border border-slate-100 text-slate-400 hover:text-primary-ref transition-colors">
                    <span class="material-symbols-outlined">print</span>
                </button>
            </x-slot:action>
        </x-page-header>

        <main class="py-4 md:p-8">
            <div class="max-w-4xl mx-auto space-y-8">

                <!-- Ticket Card -->
                <div
                    class="bg-white rounded-[2.5rem] overflow-hidden shadow-2xl shadow-slate-200/60 border border-slate-100">
                    <!-- Event Header -->
                    <div class="relative h-48 md:h-64">
                        <div class="absolute inset-0 bg-slate-900">
                            <div class="absolute inset-0 opacity-40 bg-gradient-to-br from-primary-ref to-slate-900"></div>
                            <div class="absolute inset-0 flex items-center justify-center opacity-10">
                                <span class="material-symbols-outlined text-[12rem] text-white">confirmation_number</span>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                        </div>

                        <div class="absolute bottom-0 left-0 right-0 p-8">
                            @if($ticket->scanned_at || $ticket->status === 'used')
                                <span
                                    class="inline-block px-3 py-1 bg-slate-500 text-white text-[10px] font-black uppercase tracking-widest rounded-full mb-3 shadow-lg shadow-slate-500/20">
                                    Ticket Used
                                </span>
                            @elseif($ticket->status === 'cancelled')
                                <span
                                    class="inline-block px-3 py-1 bg-red-500 text-white text-[10px] font-black uppercase tracking-widest rounded-full mb-3 shadow-lg shadow-red-500/20">
                                    Ticket Cancelled
                                </span>
                            @elseif($ticket->payment_status === 'pending')
                                <span
                                    class="inline-block px-3 py-1 bg-amber-500 text-white text-[10px] font-black uppercase tracking-widest rounded-full mb-3 shadow-lg shadow-amber-500/20">
                                    Waiting for Payment
                                </span>
                            @else
                                <span
                                    class="inline-block px-3 py-1 bg-emerald-500 text-white text-[10px] font-black uppercase tracking-widest rounded-full mb-3 shadow-lg shadow-emerald-500/10">
                                    Ticket Pending
                                </span>
                            @endif
                            <h2 class="text-3xl md:text-4xl font-black text-white leading-tight">
                                {{ $ticket->event->name }}
                            </h2>
                        </div>
                    </div>

                    <div class="p-8">
                        <!-- Details Grid -->
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                            <div class="space-y-1">
                                <p class="text-[10px] uppercase font-black text-slate-400 tracking-widest">Date</p>
                                <p class="text-base font-bold text-slate-900">
                                    {{ $ticket->event->start_time->format('d M, Y') }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] uppercase font-black text-slate-400 tracking-widest">Time</p>
                                <p class="text-base font-bold text-slate-900">
                                    {{ $ticket->event->start_time->format('h:i A') }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] uppercase font-black text-slate-400 tracking-widest">Seat</p>
                                <p class="text-base font-bold text-slate-900">
                                    {{ $ticket->seat_number ?? 'General Admission' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] uppercase font-black text-slate-400 tracking-widest">Location</p>
                                <p class="text-base font-bold text-slate-900 break-word">
                                    {{ $ticket->event->location }}</p>
                            </div>
                        </div>

                        <!-- Tear Line -->
                        <div class="relative flex items-center mb-12 -mx-8 px-8">
                            <div class="w-10 h-10 rounded-full bg-white border border-slate-100 -ml-13 shadow-inner"></div>
                            <div class="flex-1 border-t-2 border-dashed border-slate-100"></div>
                            <div class="w-10 h-10 rounded-full bg-white border border-slate-100 -mr-13 shadow-inner"></div>
                        </div>

                        <!-- QR Code Section -->
                        <div class="flex flex-col md:flex-row items-center justify-between gap-12">
                            <div class="flex-1 space-y-6">
                                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-100">
                                    <h3 class="text-sm font-black text-slate-900 mb-4 flex items-center">
                                        <span class="material-symbols-outlined text-primary-ref mr-2 text-lg">info</span>
                                        Important Information
                                    </h3>
                                    <p class="text-sm text-slate-500 leading-relaxed font-medium">
                                        Please arrive at the venue at least <span class="text-slate-900 font-bold">45
                                            minutes</span> before the event starts. Present this QR code at the entrance for
                                        scanning.
                                    </p>
                                </div>

                                <div class="flex flex-col sm:flex-row gap-4">
                                    <button
                                        class="flex-1 py-4 px-6 bg-primary-ref text-white border-2 border-primary-ref rounded-2xl flex items-center justify-center space-x-2 font-black shadow-lg shadow-red-100 hover:bg-red-700 hover:border-red-700 transition-all active:scale-[0.98]">
                                        <span class="material-symbols-outlined">account_balance_wallet</span>
                                        <span>Add to Apple Wallet</span>
                                    </button>
                                    <button onclick="window.print()"
                                        class="flex-1 py-4 px-6 bg-white text-slate-600 border-2 border-slate-100 rounded-2xl flex items-center justify-center space-x-2 font-bold hover:bg-slate-50 hover:border-slate-200 transition-all active:scale-[0.98]">
                                        <span class="material-symbols-outlined">receipt_long</span>
                                        <span>View Receipt</span>
                                    </button>
                                </div>
                            </div>

                            <div class="shrink-0 text-center">
                                <div
                                    class="bg-white p-6 rounded-[2rem] border-4 border-slate-50 shadow-2xl shadow-slate-200/50 {{ ($ticket->scanned_at || $ticket->status === 'used') ? 'opacity-50 grayscale' : '' }}">
                                    <img class="w-48 h-48 md:w-56 md:h-56"
                                        src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ $ticket->uuid }}"
                                        alt="Ticket QR Code" />
                                </div>
                                <p class="mt-4 text-[10px] font-black text-slate-400 tracking-widest uppercase">
                                    {{ ($ticket->scanned_at || $ticket->status === 'used') ? 'Ticket Already Used' : 'Scan at Entrance' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Info & Stats -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-xl shadow-slate-200/40">
                        <div class="flex items-center space-x-3 mb-8">
                            <div class="w-10 h-10 rounded-2xl bg-primary-ref/10 flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary-ref">analytics</span>
                            </div>
                            <h3 class="text-xl font-black text-slate-900">Transaction Details</h3>
                        </div>

                        <div class="space-y-6">
                            <div class="flex justify-between items-center text-sm py-1 border-b border-slate-50 pb-3">
                                <span class="text-slate-500 font-bold uppercase text-[10px] tracking-widest">Holder</span>
                                <span class="font-bold text-slate-900">{{ auth()->user()->name }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm py-1 border-b border-slate-50 pb-3">
                                <span class="text-slate-500 font-bold uppercase text-[10px] tracking-widest">Ticket ID</span>
                                <span
                                    class="font-mono text-xs font-bold text-slate-900 bg-slate-50 px-2 py-1 rounded">{{ $ticket->uuid }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm py-1 border-b border-slate-50 pb-3">
                                <span class="text-slate-500 font-bold uppercase text-[10px] tracking-widest">Event
                                    Type</span>
                                <span
                                    class="font-bold text-primary-ref px-2 py-1 bg-red-50 rounded-full text-xs">{{ $ticket->type }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm py-1 border-b border-slate-50 pb-3">
                                <span class="text-slate-500 font-bold uppercase text-[10px] tracking-widest">Status</span>
                                @if($ticket->scanned_at || $ticket->status === 'used')
                                    <span class="font-bold text-slate-600 px-2 py-1 bg-slate-50 rounded-full text-xs">Used</span>
                                @elseif($ticket->status === 'cancelled')
                                    <span class="font-bold text-red-600 px-2 py-1 bg-red-50 rounded-full text-xs">Cancelled</span>
                                @elseif($ticket->payment_status === 'pending')
                                    <span class="font-bold text-amber-600 px-2 py-1 bg-amber-50 rounded-full text-xs">Pending</span>
                                @else
                                    <span class="font-bold text-emerald-600 px-2 py-1 bg-emerald-50 rounded-full text-xs">Pending</span>
                                @endif
                            </div>
                            <div class="flex justify-between items-center text-lg pt-2">
                                <span class="text-slate-900 font-black uppercase text-xs tracking-widest">Total Paid</span>
                                <span class="font-black text-slate-900">Rp
                                    {{ number_format($ticket->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    @if($ticket->event->end_time->isPast())
                        <div
                            class="bg-slate-900 rounded-[2rem] p-8 border border-slate-800 shadow-xl shadow-slate-900/40 text-white">
                            <div class="flex items-center space-x-3 mb-8">
                                <div class="w-10 h-10 rounded-2xl bg-primary-ref flex items-center justify-center">
                                    <span class="material-symbols-outlined text-white">grade</span>
                                </div>
                                <h3 class="text-xl font-black">Experience Review</h3>
                            </div>

                            @if($ticket->testimonial)
                                <div class="space-y-6">
                                    <div class="flex gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span
                                                class="material-symbols-outlined text-2xl {{ $i <= $ticket->testimonial->rating ? 'text-amber-400' : 'text-slate-700' }}"
                                                style="font-variation-settings: 'FILL' 1">star</span>
                                        @endfor
                                    </div>
                                    <p class="text-slate-300 italic text-lg leading-relaxed">
                                        "{{ $ticket->testimonial->comment }}"
                                    </p>
                                    <div class="pt-4 border-t border-slate-800">
                                        <p class="text-xs text-slate-500 font-bold uppercase tracking-widest">Submitted on</p>
                                        <p class="text-sm font-bold text-slate-400">
                                            {{ $ticket->testimonial->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            @else
                                <form action="{{ route('user.testimonials.store') }}" method="POST" class="space-y-6">
                                    @csrf
                                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                    <input type="hidden" name="rating" id="rating" value="5">

                                    <div class="flex gap-2" x-data="{ rating: 5 }">
                                        <template x-for="i in 5">
                                            <button type="button" @click="rating = i; document.getElementById('rating').value = i"
                                                class="focus:outline-none transition-transform hover:scale-110">
                                                <span class="material-symbols-outlined text-4xl cursor-pointer"
                                                    :class="i <= rating ? 'text-amber-400' : 'text-slate-700'"
                                                    style="font-variation-settings: 'FILL' 1">star</span>
                                            </button>
                                        </template>
                                    </div>

                                    <div>
                                        <textarea name="comment" rows="3"
                                            class="w-full rounded-2xl border-slate-800 bg-slate-800/50 text-white placeholder-slate-500 focus:border-primary-ref focus:ring-primary-ref text-sm p-4"
                                            placeholder="How was the event? Share your thoughts..."></textarea>
                                    </div>

                                    <button type="submit"
                                        class="w-full bg-primary-ref text-white font-black py-4 rounded-2xl hover:bg-red-700 transition-all active:scale-[0.98] shadow-lg shadow-red-900/20">
                                        Submit Feedback
                                    </button>
                                </form>
                            @endif
                        </div>
                    @else
                        <div
                            class="bg-gradient-to-br from-indigo-600 to-indigo-900 rounded-[2rem] p-8 text-white flex flex-col justify-between">
                            <div>
                                <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center mb-6">
                                    <span class="material-symbols-outlined text-white">auto_awesome</span>
                                </div>
                                <h3 class="text-2xl font-black mb-4">Ready for the Show?</h3>
                                <p class="text-indigo-100/80 font-medium leading-relaxed">
                                    Get excited! You're going to <span
                                        class="text-white font-bold">{{ $ticket->event->name }}</span>.
                                    Don't forget to charge your phone before you go.
                                </p>
                            </div>
                            <div class="mt-8 pt-8 border-t border-white/10">
                                <div class="flex items-center space-x-3">
                                    <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                                    <span class="text-xs font-bold uppercase tracking-widest text-indigo-200">Upcoming
                                        Event</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </main>
    </div>
@endsection