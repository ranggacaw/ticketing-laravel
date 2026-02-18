@props(['event', 'showPrice' => true])

<div {{ $attributes->merge(['class' => 'group bg-white rounded-3xl overflow-hidden shadow-lg shadow-slate-200/50 hover:shadow-xl transition-all duration-300 border border-slate-100']) }}>
    <div class="relative h-56">
        <!-- Image -->
        <div class="w-full h-full bg-slate-200 relative overflow-hidden">
            @if($event->banner)
                <img src="{{ \Illuminate\Support\Facades\Storage::url($event->banner) }}" alt="{{ $event->name }}"
                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
            @else
                <div class="absolute inset-0 flex items-center justify-center text-slate-400 bg-slate-800">
                    <span class="material-symbols-outlined text-6xl opacity-20">event</span>
                    <span class="absolute text-xl font-bold opacity-30">{{ $event->name }}</span>
                </div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
        </div>

        <!-- Top Right Badge -->
        <div
            class="absolute top-4 right-4 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full flex items-center space-x-1">
            <span class="text-xs font-bold text-primary-ref">SELLING FAST</span>
        </div>

        <!-- Favorite Button -->
        <button
            class="absolute top-4 left-4 bg-white/20 backdrop-blur-md p-2 rounded-full text-white hover:bg-white/30 transition-colors">
            <span class="material-symbols-outlined text-xl">favorite</span>
        </button>

        <!-- Date Tag -->
        <div
            class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent h-24 p-5 flex items-end">
            <span class="text-white font-bold text-sm bg-primary-ref px-2 py-0.5 rounded">
                {{ $event->start_time ? $event->start_time->format('M d') : 'TBA' }}
            </span>
        </div>
    </div>

    <div class="p-5">
        <div class="flex justify-between items-start mb-2">
            <div class="flex-1 pr-2">
                <h3 class="text-xl font-bold mb-1 text-slate-900 leading-tight">
                    <a href="{{ route('events.show', $event) }}">
                        {{ $event->name }}
                    </a>
                </h3>
                <p class="text-sm text-slate-500 flex items-center">
                    <span class="material-symbols-outlined text-sm mr-1">location_on</span>
                    {{ $event->venue ? $event->venue->name : 'Unknown Venue' }}
                </p>
            </div>
            @if($showPrice)
                <div class="text-right">
                    <span class="text-lg font-black text-slate-900">
                        @if($event->ticketTypes->isNotEmpty())
                            Rp {{ number_format($event->ticketTypes->min('price'), 0, ',', '.') }}
                        @else
                            Free
                        @endif
                    </span>
                    <p class="text-[10px] uppercase tracking-wider text-slate-400">
                        {{ $event->ticketTypes->isNotEmpty() ? 'starts at' : 'entry' }}
                    </p>
                </div>
            @endif
        </div>

        <div class="flex items-center space-x-6 mb-5 pt-2 border-t border-slate-100 mt-3">
            <div class="flex items-center text-xs text-slate-500 font-medium">
                <span class="material-symbols-outlined text-lg mr-1.5 text-primary-ref">schedule</span>
                {{ $event->start_time ? $event->start_time->format('h:i A') : '--:--' }}
            </div>
            <div class="flex items-center text-xs text-slate-500 font-medium">
                <span class="material-symbols-outlined text-lg mr-1.5 text-primary-ref">groups</span>
                {{ number_format($event->ticketTypes->sum('quantity') - $event->ticketTypes->sum('sold')) }}
                Tickets Left
            </div>
        </div>

        <button onclick="window.location='{{ route('events.show', $event) }}'"
            class="w-full py-4 bg-primary-ref text-white font-bold rounded-2xl hover:bg-red-700 transition-colors flex items-center justify-center space-x-2 shadow-lg shadow-red-200 cursor-pointer">
            <span>Get Tickets</span>
            <span class="material-symbols-outlined text-sm">confirmation_number</span>
        </button>
    </div>
</div>