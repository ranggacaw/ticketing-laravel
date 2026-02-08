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
                        <h2 class="text-2xl font-bold text-white relative z-10">{{ $ticket->type }} Ticket</h2>
                        <p class="text-indigo-200 relative z-10 text-sm">Valid for entry</p>
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