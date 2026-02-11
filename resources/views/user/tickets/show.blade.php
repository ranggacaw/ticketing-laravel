@extends('layouts.app')

@section('content')
    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto">
            <div class="mb-4">
                <a href="{{ route('user.tickets.index') }}"
                    class="inline-flex items-center text-sm text-slate-500 hover:text-slate-200 transition-colors">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    My Tickets
                </a>
            </div>

            <div class="relative bg-white dark:bg-slate-800 rounded-3xl overflow-hidden shadow-2xl ring-1 ring-white/10"
                id="ticket-card">
                <!-- Event Cover (Placeholder color if no image) -->
                <div class="h-32 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 relative">
                    <div class="absolute inset-0 bg-black/20"></div>
                    <div class="absolute bottom-4 left-6 text-white">
                        <p class="text-xs font-semibold uppercase tracking-wider opacity-80 mb-1">
                            {{ $ticket->event->start_time->format('D, M d Y') }} •
                            {{ $ticket->event->start_time->format('h:i A') }}
                        </p>
                        <h2 class="text-xl font-bold leading-tight">{{ $ticket->event->name }}</h2>
                    </div>
                </div>

                <div class="p-6 sm:p-8 flex flex-col items-center text-center bg-white dark:bg-slate-800 relative z-10">
                    <!-- Tear Line visual -->
                    <div class="w-full absolute top-0 left-0 -mt-3 flex items-center justify-between pointer-events-none">
                        <div class="w-6 h-6 rounded-full bg-slate-100 dark:bg-slate-900 -ml-3"></div>
                        <div class="border-t-2 border-dashed border-slate-200 dark:border-slate-700 w-full mx-2"></div>
                        <div class="w-6 h-6 rounded-full bg-slate-100 dark:bg-slate-900 -mr-3"></div>
                    </div>

                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 mb-6">
                        {{ $ticket->type }}
                    </span>

                    <div class="mb-8 p-4 bg-white rounded-2xl shadow-sm border border-slate-200">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ $ticket->uuid }}"
                            alt="Ticket QR" class="w-48 h-48 mx-auto" />
                    </div>

                    <p class="text-xs text-slate-400 font-mono mb-6 uppercase tracking-[0.2em]">{{ $ticket->uuid }}</p>

                    <div class="grid grid-cols-2 gap-4 w-full text-left bg-slate-50 dark:bg-slate-700/50 rounded-2xl p-4">
                        <div>
                            <span
                                class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold block mb-1">Seat</span>
                            <span class="text-lg font-bold text-slate-900 dark:text-white">{{ $ticket->seat_number }}</span>
                        </div>
                        <div>
                            <span
                                class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold block mb-1">Price</span>
                            <span class="text-lg font-bold text-slate-900 dark:text-white">Rp
                                {{ number_format($ticket->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="col-span-2 pt-2 mt-2 border-t border-slate-200 dark:border-slate-600">
                            <span
                                class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold block mb-1">Location</span>
                            <span
                                class="text-sm font-medium text-slate-700 dark:text-slate-200">{{ $ticket->event->location }}</span>
                        </div>
                    </div>
                </div>

                <!-- Footer / Actions -->
                <div class="bg-slate-50 dark:bg-slate-900/50 p-4 flex gap-3 justify-center">
                    <button onclick="window.print()"
                        class="flex-1 inline-flex justify-center items-center py-3 px-4 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download
                    </button>
                    <button
                        class="flex-1 inline-flex justify-center items-center py-3 px-4 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 transition-colors shadow-lg shadow-indigo-600/20">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                            </path>
                        </svg>
                        Add to Wallet
                    </button>
                </div>
            </div>

            <p class="text-center text-xs text-slate-500 mt-6 max-w-xs mx-auto">
                Please present this QR code at the entrance. Screenshots are accepted but original ticket is preferred.
            </p>

            @if($ticket->event->end_time->isPast())
                <div class="mt-8 pt-8 border-t border-slate-200 dark:border-white/10">
                    <div
                        class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-slate-100 dark:border-white/5">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 text-center">How was the event?</h3>

                        @if($ticket->testimonial)
                            <div class="text-center">
                                <div class="flex justify-center gap-1 mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-6 h-6 {{ $i <= $ticket->testimonial->rating ? 'text-amber-400' : 'text-slate-200 dark:text-slate-600' }}"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                                <p class="text-slate-600 dark:text-slate-300 italic">"{{ $ticket->testimonial->comment }}"</p>
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
                                            <svg class="w-8 h-8"
                                                :class="i <= rating ? 'text-amber-400' : 'text-slate-200 dark:text-slate-600'"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        </button>
                                    </template>
                                </div>

                                <div>
                                    <textarea name="comment" rows="3"
                                        class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                        placeholder="Share your experience..."></textarea>
                                </div>

                                <button type="submit"
                                    class="w-full bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-bold py-3 rounded-xl hover:opacity-90 transition-opacity">
                                    Submit Review
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection