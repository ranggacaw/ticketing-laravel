@extends('user.layouts.app')

@section('header', 'Ticket Details')
@section('subheader', 'Seat ' . $ticket->seat_number)

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('user.tickets.index') }}"
                class="text-slate-400 hover:text-white flex items-center transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Back to Tickets
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Ticket Card -->
            <div class="md:col-span-2 space-y-6">
                <div class="bg-slate-800/50 backdrop-blur-md border border-white/10 rounded-2xl overflow-hidden shadow-2xl">
                    <!-- Banner -->
                    <div class="h-32 bg-gradient-to-r from-indigo-600 to-purple-600 relative p-6 flex flex-col justify-end">
                        <div
                            class="absolute top-0 left-0 w-full h-full opacity-30 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
                        </div>
                        <h2 class="text-2xl font-bold text-white relative z-10">{{ $ticket->event?->name ?? $ticket->type }}
                        </h2>
                        <p class="text-indigo-200 relative z-10 text-sm">
                            {{ $ticket->event?->start_time?->format('l, F j, Y \a\t g:i A') }}
                            @if($ticket->event?->location)
                                • {{ $ticket->event->location }}
                            @endif
                        </p>
                    </div>

                    <div class="p-8">
                        <div
                            class="flex flex-col md:flex-row justify-between md:items-center mb-8 pb-8 border-b border-white/5">
                            <div class="mb-4 md:mb-0">
                                <p class="text-slate-400 text-sm uppercase tracking-wider mb-1">Pass Holder</p>
                                <h3 class="text-xl font-bold text-white">{{ $ticket->user_name ?? auth()->user()->name }}
                                </h3>
                                <p class="text-slate-500 text-sm">{{ $ticket->user_email ?? auth()->user()->email }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-slate-400 text-sm uppercase tracking-wider mb-1">Seat Number</p>
                                <h3 class="text-3xl font-bold text-white">{{ $ticket->seat_number }}</h3>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6 mb-8">
                            <div>
                                <p class="text-slate-400 text-sm mb-1">Price</p>
                                <p class="text-lg font-medium text-white">${{ number_format($ticket->price, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-slate-400 text-sm mb-1">Status</p>
                                @if($ticket->scanned_at)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-700 text-slate-300">
                                        Used on {{ $ticket->scanned_at->format('M d, H:i') }}
                                    </span>
                                @elseif($ticket->payment_status === 'pending')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-500/20 text-yellow-400">
                                        Payment Pending
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/20 text-green-400">
                                        Valid for Entry
                                    </span>
                                @endif
                            </div>
                            <div>
                                <p class="text-slate-400 text-sm mb-1">Order ID</p>
                                <p class="text-sm font-mono text-white">{{ substr($ticket->uuid, 0, 8) }}</p>
                            </div>
                            <div>
                                <p class="text-slate-400 text-sm mb-1">Purchase Date</p>
                                <p class="text-sm text-white">{{ $ticket->created_at->format('M d, Y') }}</p>
                            </div>
                            <!-- Event Details -->
                            @if($ticket->event)
                                <div>
                                    <p class="text-slate-400 text-sm mb-1">Event Location</p>
                                    <p class="text-white text-sm">{{ $ticket->event->location }}</p>
                                </div>
                                @if($ticket->event->end_time)
                                    <div>
                                        <p class="text-slate-400 text-sm mb-1">Duration</p>
                                        <p class="text-white text-sm">
                                            {{ $ticket->event->start_time->diffInHours($ticket->event->end_time) }} Hours
                                        </p>
                                    </div>
                                @endif
                            @endif
                        </div>


                        <div class="flex flex-col space-y-3">
                            <button onclick="window.print()"
                                class="w-full py-3 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white font-medium transition-colors flex justify-center items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Download / Print Ticket
                            </button>

                            <!-- Review Section -->
                            @if($ticket->event && ($ticket->event->end_time ?? $ticket->event->start_time) < now())
                                @if($ticket->testimonial)
                                    <div class="mt-6 p-6 bg-slate-700/30 rounded-xl border border-white/5">
                                        <h3 class="text-lg font-bold text-white mb-2">My Review</h3>
                                        <div class="flex items-center mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-5 h-5 {{ $i <= $ticket->testimonial->rating ? 'text-yellow-400' : 'text-slate-600' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                            @endfor
                                        </div>
                                        <p class="text-slate-300 italic">"{{ $ticket->testimonial->comment }}"</p>
                                        
                                        <div class="mt-4 flex space-x-3">
                                            <a href="https://twitter.com/intent/tweet?text={{ urlencode('Checking out ' . ($ticket->event->name ?? 'an event') . '! My review: ' . $ticket->testimonial->comment) }}"
                                                target="_blank"
                                                class="px-3 py-1.5 bg-sky-500/20 text-sky-400 text-xs rounded-lg hover:bg-sky-500/30 transition-colors flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                                                Share on X
                                            </a>
                                            <button onclick="navigator.clipboard.writeText('{{ $ticket->testimonial->comment }}'); alert('Review copied to clipboard!');"
                                                class="px-3 py-1.5 bg-slate-600/20 text-slate-400 text-xs rounded-lg hover:bg-slate-600/30 transition-colors flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                                Copy
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <button onclick="review_modal.showModal()"
                                        class="w-full py-3 rounded-lg bg-slate-700 hover:bg-slate-600 text-white font-medium transition-colors flex justify-center items-center border border-white/5">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                        Write a Review
                                    </button>

                                    <!-- Review Modal -->
                                    <dialog id="review_modal" class="modal">
                                        <div class="modal-box bg-slate-800 border border-white/10">
                                            <form method="dialog">
                                                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                            </form>
                                            <h3 class="font-bold text-lg text-white mb-4">Write a Review</h3>
                                            <form method="POST" action="{{ route('user.testimonials.store') }}">
                                                @csrf
                                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                                                <div class="form-control mb-4">
                                                    <label class="label">
                                                        <span class="label-text text-slate-300">Rating</span>
                                                    </label>
                                                    <div class="rating rating-lg">
                                                        <input type="radio" name="rating" value="1"
                                                            class="mask mask-star-2 bg-orange-400" />
                                                        <input type="radio" name="rating" value="2"
                                                            class="mask mask-star-2 bg-orange-400" />
                                                        <input type="radio" name="rating" value="3"
                                                            class="mask mask-star-2 bg-orange-400" />
                                                        <input type="radio" name="rating" value="4"
                                                            class="mask mask-star-2 bg-orange-400" />
                                                        <input type="radio" name="rating" value="5"
                                                            class="mask mask-star-2 bg-orange-400" checked />
                                                    </div>
                                                </div>

                                                <div class="form-control mb-6">
                                                    <label class="label">
                                                        <span class="label-text text-slate-300">Your specific feedback</span>
                                                    </label>
                                                    <textarea name="comment"
                                                        class="textarea textarea-bordered h-24 bg-slate-900 text-white"
                                                        placeholder="Tell us about your experience..."></textarea>
                                                </div>

                                                <button class="btn btn-primary w-full">Submit Review</button>
                                            </form>
                                        </div>
                                        <form method="dialog" class="modal-backdrop">
                                            <button>close</button>
                                        </form>
                                    </dialog>
                                @endif
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- QR Code Side -->
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-2xl shadow-2xl flex flex-col items-center justify-center text-center">
                <p class="text-slate-500 text-xs uppercase tracking-widest mb-4">Scan for Entry</p>
                <div class="bg-white p-2 rounded-lg">
                    {!! QrCode::size(200)->generate($ticket->barcode_data) !!}
                </div>
                <p class="mt-4 text-xs text-slate-400 font-mono">{{ $ticket->barcode_data }}</p>
            </div>

            <div class="bg-slate-800/50 backdrop-blur border border-white/5 rounded-2xl p-6">
                <h3 class="text-white font-bold mb-2">Important Info</h3>
                <ul class="text-sm text-slate-400 space-y-2 list-disc list-inside">
                    <li>Please have this code ready at the entrance.</li>
                    <li>Do not share this code with anyone else.</li>
                    <li>Valid ID may be required for verification.</li>
                </ul>
            </div>
        </div>
    </div>
    </div>
@endsection