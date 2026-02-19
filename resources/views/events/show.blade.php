@extends('user.layouts.app')

@section('content-full')
    <div class="relative h-[45vh] md:h-[55vh] w-full overflow-hidden -mt-24 font-display text-slate-900">
        <!-- Event Image Background -->
        <div class="absolute inset-0 bg-slate-900 border-b border-slate-100">
            @if($event->banner_url)
                <img src="{{ $event->banner_url }}" alt="{{ $event->name }}" class="w-full h-full object-cover">
            @else
                <div
                    class="w-full h-full bg-gradient-to-br from-primary-ref to-slate-900 flex items-center justify-center opacity-80">
                    <span class="material-symbols-outlined text-9xl text-white/10">confirmation_number</span>
                </div>
            @endif
            <!-- Immersive Gradient Overlay - white-ish for the user portal feel -->
            <div class="absolute inset-0 bg-gradient-to-t from-white via-white/10 to-transparent"></div>
        </div>

        <!-- Hero Content Overlay -->
        <div class="absolute bottom-0 left-0 right-0 p-6 md:p-12">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center gap-2 mb-4">
                    <span
                        class="px-3 py-1 bg-primary-ref text-white text-[10px] font-bold uppercase tracking-wider rounded-full shadow-lg shadow-red-200">
                        {{ $event->category ?? 'Event' }}
                    </span>
                    <div
                        class="flex items-center gap-1.5 px-3 py-1 bg-white/90 backdrop-blur-md rounded-full shadow-sm border border-slate-100">
                        <span class="material-symbols-outlined text-amber-500 text-sm">stars</span>
                        <span class="text-xs font-black text-slate-800">4.9 (2.4k)</span>
                    </div>
                </div>
                <h1 class="text-4xl md:text-6xl text-slate-900 mb-3 font-bold leading-tight tracking-tighter">
                    {{ $event->name }}
                </h1>
                <div class="flex items-center gap-2 text-slate-500 font-bold">
                    <div class="w-8 h-8 rounded-full bg-primary-ref/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary-ref text-lg">location_on</span>
                    </div>
                    <span class="text-lg">{{ $event->venue ? $event->venue->name : $event->location }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="mt-12 pb-32 font-display text-slate-900">
        <!-- Info Cards Grid - Matching User Dashboard Style -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Date -->
            <div
                class="bg-white rounded-3xl p-6 shadow-lg shadow-slate-200/50 border border-slate-100 flex flex-col items-center justify-center text-center group hover:shadow-xl transition-all">
                <div
                    class="w-12 h-12 bg-primary-ref/10 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-primary-ref">calendar_today</span>
                </div>
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Date</span>
                <span
                    class="font-black text-slate-900 text-sm">{{ $event->start_time ? $event->start_time->format('M d, Y') : 'TBA' }}</span>
            </div>

            <!-- Time -->
            <div
                class="bg-white rounded-3xl p-6 shadow-lg shadow-slate-200/50 border border-slate-100 flex flex-col items-center justify-center text-center group hover:shadow-xl transition-all">
                <div
                    class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-indigo-500">schedule</span>
                </div>
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Time</span>
                <span
                    class="font-black text-slate-900 text-sm">{{ $event->start_time ? $event->start_time->format('h:i A') : 'TBA' }}</span>
            </div>

            <!-- Weather -->
            <div
                class="bg-white rounded-3xl p-6 shadow-lg shadow-slate-200/50 border border-slate-100 flex flex-col items-center justify-center text-center group hover:shadow-xl transition-all">
                <div
                    class="w-12 h-12 bg-cyan-50 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-cyan-500">thermostat</span>
                </div>
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Weather</span>
                <span class="font-black text-slate-900 text-sm">26°C</span>
            </div>

            <!-- Price -->
            <div
                class="bg-white rounded-3xl p-6 shadow-lg shadow-slate-200/50 border border-slate-100 flex flex-col items-center justify-center text-center group hover:shadow-xl transition-all">
                <div
                    class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-emerald-500">payments</span>
                </div>
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Starting At</span>
                <span class="font-black text-slate-900 text-sm">
                    @if(!$event->ticketTypes->isEmpty())
                        Rp {{ number_format($event->ticketTypes->min('price'), 0, ',', '.') }}
                    @else
                        -
                    @endif
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 mt-12 pb-12">
            <!-- Main Details -->
            <div class="lg:col-span-2 space-y-12">
                <!-- About Event -->
                <section>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-slate-900 rounded-xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-xl">description</span>
                        </div>
                        <h2 class="text-2xl font-black text-slate-900">About Event</h2>
                    </div>
                    <div x-data="{ expanded: false }"
                        class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-lg shadow-slate-200/30 overflow-hidden group">
                        <p class="text-slate-600 leading-relaxed text-lg font-medium"
                            :class="expanded ? '' : 'line-clamp-6'">
                            {!! $event->description !!}
                        </p>
                        <button @click="expanded = !expanded"
                            class="text-primary-ref font-black mt-6 flex items-center gap-1 hover:gap-2 transition-all uppercase tracking-widest text-xs">
                            <span x-text="expanded ? 'Read Less' : 'Read Full Description'"></span>
                            <span class="material-symbols-outlined text-xs">arrow_forward</span>
                        </button>
                    </div>
                </section>

                <!-- Location & Map -->
                <section>
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-slate-900 rounded-xl flex items-center justify-center">
                                <span class="material-symbols-outlined text-white text-xl">map</span>
                            </div>
                            <h2 class="text-2xl font-black text-slate-900">Location</h2>
                        </div>
                        <a href="{{ $event->latitude && $event->longitude ? 'https://www.google.com/maps/search/?api=1&query=' . $event->latitude . ',' . $event->longitude : 'https://maps.google.com/?q=' . urlencode($event->location) }}" target="_blank"
                            class="text-xs font-bold text-primary-ref uppercase tracking-wider hover:underline flex items-center gap-1">
                            Open Maps <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                        </a>
                    </div>
                    <div class="bg-white rounded-[2.5rem] p-4 border border-slate-100 shadow-lg shadow-slate-200/30">
                        <div class="relative h-72 rounded-[2rem] overflow-hidden group">
                            @if($event->latitude && $event->longitude)
                                <div id="event-map" class="w-full h-full z-0"></div>
                                <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
                                <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var map = L.map('event-map', {
                                            zoomControl: false,
                                            scrollWheelZoom: false,
                                            dragging: false
                                        }).setView([{{ $event->latitude }}, {{ $event->longitude }}], 15);

                                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                            attribution: '&copy; OpenStreetMap contributors'
                                        }).addTo(map);

                                        L.marker([{{ $event->latitude }}, {{ $event->longitude }}]).addTo(map);
                                    });
                                </script>
                            @else
                                <div class="absolute inset-0 bg-slate-50 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-8xl text-primary-ref/10 animate-pulse">map_search</span>
                                </div>
                            @endif
                            <!-- Location Detail Overlay -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div
                                    class="bg-white/90 backdrop-blur-xl p-6 rounded-3xl shadow-2xl border border-white flex items-center gap-5 max-w-[85%] transform group-hover:scale-105 transition-transform duration-500">
                                    <div
                                        class="w-14 h-14 bg-primary-ref rounded-2xl flex items-center justify-center shadow-lg shadow-red-200">
                                        <span class="material-symbols-outlined text-white text-2xl">location_on</span>
                                    </div>
                                    <div class="overflow-hidden">
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">
                                            Official Venue</p>
                                        <p class="font-black text-slate-900 text-lg leading-tight">
                                            {{ $event->venue ? $event->venue->name : $event->location }}</p>
                                        <p class="text-xs text-slate-500 mt-1 truncate">
                                            {{ $event->venue->address ?? $event->location }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Gallery Carousel Style -->
                <!-- <section>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-black text-slate-900">Gallery</h2>
                        <button class="text-xs font-bold text-primary-ref uppercase tracking-wider">View All</button>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-5">
                        @for($i = 1; $i <= 3; $i++)
                            <div
                                class="aspect-square rounded-[2rem] bg-slate-100 border border-slate-100 overflow-hidden group relative">
                                <div
                                    class="w-full h-full bg-slate-100 flex items-center justify-center group-hover:scale-110 transition-all duration-700">
                                    <span class="material-symbols-outlined text-slate-300 text-4xl">image</span>
                                </div>
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-slate-900/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-5">
                                    <span class="text-[10px] text-white font-bold uppercase tracking-wider">Event Photo
                                        {{ $i }}</span>
                                </div>
                            </div>
                        @endfor
                    </div>
                </section> -->
            </div>

            <!-- Sidebar Actions -->
            <div class="lg:col-span-1">
                <div class="sticky top-32 space-y-6">
                    <!-- Ticket Selection Card -->
                    <div
                        class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/50 border border-slate-100 relative overflow-hidden">
                        <div class="absolute -right-12 -top-12 w-32 h-32 bg-primary-ref/5 rounded-full blur-2xl"></div>

                        <div class="flex items-center gap-3 mb-8 relative z-10">
                            <div class="w-10 h-10 bg-primary-ref/10 rounded-xl flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary-ref">confirmation_number</span>
                            </div>
                            <h3 class="text-xl font-black text-slate-900">Select Tickets</h3>
                        </div>

                        @if($event->ticketTypes->isEmpty())
                            <div class="bg-amber-50 rounded-2xl p-6 text-amber-700 font-bold text-sm flex items-center gap-3 border border-amber-100">
                                <span class="material-symbols-outlined">event_busy</span>
                                No tickets currently listed.
                            </div>
                        @else
                            <form action="{{ route('events.checkout', $event->slug) }}" method="POST" id="ticketForm" enctype="multipart/form-data" class="space-y-6">
                                @csrf
                                <div class="space-y-4">
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Select Tickets</label>
                                    @foreach($event->ticketTypes as $ticketType)
                                        <div class="p-5 rounded-3xl border-2 border-slate-100 hover:bg-slate-50 transition-all relative flex flex-col gap-3">
                                            <div class="flex justify-between items-start">
                                                <span class="font-black text-slate-900 text-lg">{{ $ticketType->name }}</span>
                                                @if(!$ticketType->isAvailable())
                                                    <span class="text-[10px] font-bold text-red-500 bg-red-50 px-2 py-0.5 rounded uppercase tracking-wider">
                                                        Waitlist Only
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <div class="flex justify-between items-center">
                                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">
                                                    {{ $ticketType->description }}
                                                </p>
                                                <span class="text-primary-ref font-black">
                                                    Rp {{ number_format($ticketType->price, 0, ',', '.') }}
                                                </span>
                                            </div>

                                            @if($ticketType->isAvailable())
                                                <div class="flex items-center justify-between border-t border-slate-100 pt-3 mt-1">
                                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Quantity</span>
                                                    <div class="flex items-center gap-3">
                                                        <button type="button" 
                                                            onclick="adjustQuantity('{{ $ticketType->id }}', -1)"
                                                            class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition-colors">
                                                            <span class="material-symbols-outlined text-sm">remove</span>
                                                        </button>
                                                        
                                                        <input type="number" 
                                                            name="tickets[{{ $ticketType->id }}]" 
                                                            id="ticket_{{ $ticketType->id }}"
                                                            value="0" 
                                                            min="0" 
                                                            max="{{ min($ticketType->quantity - $ticketType->sold, 10) }}" 
                                                            data-price="{{ $ticketType->price }}"
                                                            class="w-12 text-center bg-transparent font-black text-slate-900 outline-none"
                                                            readonly>

                                                        <button type="button" 
                                                            onclick="adjustQuantity('{{ $ticketType->id }}', 1)"
                                                            class="w-8 h-8 rounded-xl bg-primary-ref/10 hover:bg-primary-ref/20 text-primary-ref flex items-center justify-center transition-colors">
                                                            <span class="material-symbols-outlined text-sm">add</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Payment Details Section -->
                                <div class="pt-6 border-t border-slate-100 space-y-6">
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center">
                                            <span class="material-symbols-outlined text-slate-400 text-sm">payments</span>
                                        </div>
                                        <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest">Payment Details</h4>
                                    </div>

                                    <!-- Bank Selection -->
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Transfer To</label>
                                        <div class="relative group">
                                            <select name="bank_id" required class="w-full appearance-none bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 font-bold text-sm text-slate-900 focus:border-primary-ref outline-none transition-all cursor-pointer hover:bg-slate-100">
                                                <option value="" disabled selected>Select Bank Destination</option>
                                                @foreach($banks as $bank)
                                                    <option value="{{ $bank->id }}">{{ $bank->name }} - {{ $bank->account_number }} ({{ $bank->account_name }})</option>
                                                @endforeach
                                            </select>
                                            <span class="material-symbols-outlined absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-sm">account_balance</span>
                                        </div>
                                    </div>

                                    <!-- Sender Info -->
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Sender Name</label>
                                            <input type="text" name="sender_account_name" required placeholder="Your Name" 
                                                class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 font-bold text-sm text-slate-900 focus:border-primary-ref outline-none transition-all placeholder:text-slate-300 pointer-events-auto">
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Account No.</label>
                                            <input type="text" name="sender_account_number" required placeholder="Your Account No." 
                                                class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 font-bold text-sm text-slate-900 focus:border-primary-ref outline-none transition-all placeholder:text-slate-300 pointer-events-auto">
                                        </div>
                                    </div>

                                    <!-- Proof Upload -->
                                    <div class="space-y-2">
                                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-1">Payment Proof</label>
                                        <div class="relative group">
                                            <input type="file" name="payment_proof" required accept=".jpg,.jpeg,.png,.pdf"
                                                class="w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-5 file:rounded-xl file:border-0 file:text-xs file:font-black file:uppercase file:tracking-widest file:bg-slate-100 file:text-slate-500 hover:file:bg-slate-200 transition-all cursor-pointer border-2 border-slate-100 rounded-2xl bg-slate-50 p-1">
                                            <p class="text-[9px] text-slate-400 mt-2 ml-1">* Max 2MB (JPG, PNG, PDF)</p>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>

                    <!-- Host Details - Dark Style matching VIP card -->
                    @if($event->organizer)
                        <div
                            class="bg-slate-900 rounded-[2.5rem] p-8 text-white group cursor-pointer relative overflow-hidden border border-white/5">
                            <div
                                class="absolute -right-8 -bottom-8 w-40 h-40 bg-primary-ref/20 rounded-full blur-3xl group-hover:bg-primary-ref/40 transition-all duration-700">
                            </div>
                            <div class="relative z-10">
                                <div class="flex items-center gap-5 mb-6">
                                    <div
                                        class="w-16 h-16 bg-white/10 backdrop-blur-xl rounded-2xl flex items-center justify-center text-2xl font-black border border-white/10 group-hover:scale-110 transition-transform shadow-2xl">
                                        {{ substr($event->organizer->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-primary-ref uppercase tracking-wider mb-1">
                                            Official Host</p>
                                        <p class="font-black text-xl group-hover:text-primary-ref transition-colors">
                                            {{ $event->organizer->name }}</p>
                                    </div>
                                </div>
                                <button
                                    class="w-full py-4 bg-white/5 border border-white/10 rounded-2xl text-[10px] font-bold uppercase tracking-wider hover:bg-white/10 transition-all">Support
                                    Organizer</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Sticky Checkout Bar (Matching user dashboard buttons) -->
    <div class="fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-2xl border-t border-slate-100 pb-32 p-6 z-50 font-display text-slate-900">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-8">
            <div class="hidden md:block">
                <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Total to Pay</h4>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-black text-slate-900" id="desktopTotalPrice">
                        Rp 0
                    </span>
                    <span class="text-xs font-black text-primary-ref/60 italic tracking-tighter">no hidden fees</span>
                </div>
            </div>

            <div class="flex-1 flex items-center gap-8">
                <div class="md:hidden flex flex-col justify-center">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Payable Amount</span>
                    <span class="text-xl font-black text-slate-900" id="bottomTotalPrice">
                        Rp 0
                    </span>
                </div>

                @if(($event->end_time && $event->end_time->isPast()) || in_array($event->status, ['completed', 'cancelled']))
                    <div
                        class="flex-1 py-5 bg-slate-50 text-slate-300 font-black rounded-3xl flex items-center justify-center gap-3 border border-slate-100 cursor-not-allowed">
                        <span class="material-symbols-outlined text-lg">event_busy</span>
                        <span class="uppercase tracking-widest text-xs">Event Unavailable</span>
                    </div>
                @else
                    <button onclick="document.getElementById('ticketForm').submit()"
                        class="flex-1 py-2 bg-primary-ref text-white font-black rounded-3xl shadow-2xl shadow-red-200 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-3 uppercase tracking-widest text-sm group">
                        Book Now
                        <span
                            class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </button>
                @endif
            </div>
        </div>
    </div>

    <script>
        function adjustQuantity(ticketTypeId, change) {
            const input = document.getElementById('ticket_' + ticketTypeId);
            if (!input) return;

            let newValue = parseInt(input.value) + change;
            const max = parseInt(input.getAttribute('max'));
            const min = parseInt(input.getAttribute('min'));

            if (newValue >= min && newValue <= max) {
                input.value = newValue;
                updateTotalPrice();
            }
        }

        function updateTotalPrice() {
            const inputs = document.querySelectorAll('input[name^="tickets["]');
            let total = 0;

            inputs.forEach(input => {
                const quantity = parseInt(input.value) || 0;
                const price = parseFloat(input.dataset.price) || 0;
                total += quantity * price;
            });

            const formatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(total).replace('Rp', 'Rp ');

            document.getElementById('bottomTotalPrice').innerText = formatted;
            document.getElementById('desktopTotalPrice').innerText = formatted;
        }

        document.addEventListener('DOMContentLoaded', updateTotalPrice);
    </script>

    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
@endsection