@extends('user.layouts.app')

@section('header', 'Payment Details')
@section('subheader', 'Invoice ' . $payment->invoice_number)

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-slate-800/50 backdrop-blur border border-white/5 rounded-2xl p-8 mb-8">
            <div class="flex justify-between items-center mb-8 pb-8 border-b border-white/5">
                <div>
                    <p class="text-slate-400 text-sm mb-1 uppercase tracking-wider">Invoice To</p>
                    <h3 class="text-xl font-bold text-white">{{ auth()->user()->name }}</h3>
                    <p class="text-slate-500 text-sm">{{ auth()->user()->email }}</p>
                </div>
                <div class="text-right">
                    <p class="text-slate-400 text-sm mb-1 uppercase tracking-wider">Status</p>
                    @if($payment->status === 'confirmed')
                        <span class="px-3 py-1 bg-green-500/20 text-green-400 text-sm font-bold rounded-full">PAID</span>
                    @else
                        <span
                            class="px-3 py-1 bg-yellow-500/20 text-yellow-400 text-sm font-bold rounded-full uppercase">{{ $payment->status }}</span>
                    @endif
                </div>
            </div>

            <div class="mb-8">
                <h4 class="text-white font-medium mb-4">Items</h4>
                <div class="bg-slate-900/50 rounded-lg p-4 space-y-3">
                    @foreach($payment->tickets as $ticket)
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-300">Ticket - {{ $ticket->type }} (Seat {{ $ticket->seat_number }})</span>
                            <span class="text-white font-medium">${{ number_format($ticket->price, 2) }}</span>
                        </div>
                    @endforeach
                    <div class="border-t border-white/5 pt-3 flex justify-between items-center text-lg font-bold">
                        <span class="text-white">Total</span>
                        <span class="text-white">${{ number_format($payment->amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8 text-sm">
                <div>
                    <p class="text-slate-400 mb-1">Invoice Number</p>
                    <p class="text-white font-mono">{{ $payment->invoice_number }}</p>
                </div>
                <div>
                    <p class="text-slate-400 mb-1">Date</p>
                    <p class="text-white">{{ $payment->created_at->format('F d, Y H:i A') }}</p>
                </div>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('user.payments.index') }}" class="text-indigo-400 hover:text-white transition-colors">Back to
                Payments</a>
        </div>
    </div>
@endsection