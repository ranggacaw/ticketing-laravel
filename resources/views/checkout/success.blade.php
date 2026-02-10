@extends('layouts.public')

@section('content')
    <div class="flex flex-col items-center justify-center min-h-[60vh] text-center">
        <div class="w-20 h-20 bg-success/20 rounded-full flex items-center justify-center mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-success" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <h1 class="text-4xl font-bold mb-4">Confirmed!</h1>
        <p class="text-xl text-base-content/70 mb-8 max-w-md">
            Your payment to <span class="font-bold text-base-content">{{ $ticket->event->name }}</span> was successful.
            We've sent a confirmation email to <span class="font-bold text-base-content">{{ $ticket->user_email }}</span>.
        </p>

        <div class="card w-full max-w-md bg-base-100 shadow-xl border border-base-200 mb-8">
            <div class="card-body text-left">
                <h2 class="card-title text-sm uppercase text-base-content/50">Ticket Details</h2>
                <div class="flex justify-between items-center mt-2">
                    <div>
                        <p class="font-bold text-lg">{{ $ticket->ticketType->name }}</p>
                        <p class="text-sm opacity-70">{{ $ticket->event->venue->name ?? 'Venue TBD' }}</p>
                    </div>
                    <!-- Simple placeholder barcode or QR -->
                    <div class="bg-base-300 p-2 rounded">
                        {{-- Simulate a QR code --}}
                        <div class="w-12 h-12 bg-white flex items-center justify-center text-xs text-black font-mono">QR
                        </div>
                    </div>
                </div>

                <div class="divider my-2"></div>

                <div class="flex justify-between text-sm">
                    <span>Total Amount</span>
                    <span class="font-bold">${{ number_format($ticket->price, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm mt-1">
                    <span>Date</span>
                    <span
                        class="font-bold">{{ $ticket->event->start_time ? $ticket->event->start_time->format('M d, Y') : 'TBA' }}</span>
                </div>

                <div class="text-center mt-4 text-xs font-mono text-base-content/40">
                    UUID: {{ $ticket->uuid }}
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('user.tickets.index') }}" class="btn btn-primary">
                View My Tickets
            </a>
            <a href="{{ route('events.index') }}" class="btn btn-ghost">
                Browse More Events
            </a>
        </div>
    </div>
@endsection