@extends('user.layouts.app')

@section('content')
    <div class="min-h-screen -mx-4 md:-mx-8 font-display px-6">
        <!-- Header -->
        <x-page-header title="Payment Details" :subtitle="'Invoice ' . $payment->invoice_number">
            <x-slot:action>
                <div class="flex gap-2">
                    <button onclick="window.print()"
                        class="p-2 bg-slate-50 rounded-full border border-slate-100 text-slate-400 hover:text-primary-ref transition-colors">
                        <span class="material-symbols-outlined">print</span>
                    </button>
                    <a href="{{ route('user.payments.index') }}"
                        class="p-2 bg-slate-50 rounded-full border border-slate-100 text-slate-400 hover:text-primary-ref transition-colors">
                        <span class="material-symbols-outlined">arrow_back</span>
                    </a>
                </div>
            </x-slot:action>
        </x-page-header>

        <main class="py-4 md:p-8">
            <div class="max-w-3xl mx-auto">
                <div
                    class="bg-white rounded-[2.5rem] border border-slate-100 shadow-2xl shadow-slate-200/60 overflow-hidden relative">
                    <!-- Top Decoration -->
                    <div class="h-2 bg-gradient-to-r from-primary-ref to-rose-400"></div>

                    <div class="p-8 md:p-12">
                        <!-- Invoice Header -->
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-6">
                            <div>
                                <h2 class="text-3xl font-black text-slate-900 mb-2">Invoice</h2>
                                <p class="text-slate-500 font-medium">Thank you for your purchase.</p>
                            </div>
                            <div class="text-right">
                                @if($payment->status === 'confirmed' || $payment->status === 'paid')
                                    <span
                                        class="inline-block px-4 py-2 bg-emerald-50 text-emerald-600 text-sm font-black uppercase tracking-widest rounded-full border border-emerald-100">
                                        PAID
                                    </span>
                                @elseif($payment->status === 'pending')
                                    <span
                                        class="inline-block px-4 py-2 bg-amber-50 text-amber-600 text-sm font-black uppercase tracking-widest rounded-full border border-amber-100">
                                        PENDING
                                    </span>
                                @else
                                    <span
                                        class="inline-block px-4 py-2 bg-red-50 text-red-600 text-sm font-black uppercase tracking-widest rounded-full border border-red-100">
                                        {{ strtoupper($payment->status) }}
                                    </span>
                                @endif
                                <p class="mt-2 text-xs font-bold text-slate-400 uppercase tracking-wider">
                                    {{ $payment->created_at->format('M d, Y') }}
                                </p>
                            </div>
                        </div>

                        <!-- Bill To & Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-12">
                            <div>
                                <p class="text-[10px] uppercase font-black text-slate-400 tracking-widest mb-4">Billed To
                                </p>
                                <h3 class="text-xl font-bold text-slate-900 mb-1">{{ auth()->user()->name }}</h3>
                                <p class="text-slate-500 font-medium">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="md:text-right">
                                <p class="text-[10px] uppercase font-black text-slate-400 tracking-widest mb-4">Payment
                                    Method</p>
                                <div
                                    class="inline-flex items-center gap-2 bg-slate-50 px-4 py-2 rounded-xl border border-slate-100">
                                    <span class="material-symbols-outlined text-slate-500">credit_card</span>
                                    <span
                                        class="font-bold text-slate-700 text-sm">{{ $payment->payment_method ?? 'Bank Transfer' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Items Table -->
                        <div class="mb-12">
                            <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider mb-6">Order Summary</h3>
                            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                                <div class="space-y-4">
                                    @foreach($payment->tickets as $ticket)
                                        <div class="flex justify-between items-start group">
                                            <div class="flex-1 pr-4">
                                                <div class="font-bold text-slate-900 mb-1">
                                                    {{ $ticket->event->name ?? 'Event Ticket' }}
                                                </div>
                                                <div class="text-xs font-medium text-slate-500 flex items-center gap-2">
                                                    <span class="capitalize">{{ $ticket->type }} Ticket</span>
                                                    @if($ticket->seat_number)
                                                        <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                                        <span>Seat {{ $ticket->seat_number }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="font-black text-slate-900">
                                                Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                            </div>
                                        </div>
                                        @if(!$loop->last)
                                            <div class="h-px bg-slate-200 border-dashed"></div>
                                        @endif
                                    @endforeach
                                </div>

                                <div class="border-t-2 border-dashed border-slate-200 mt-6 pt-6">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-black text-slate-500 uppercase tracking-widest">Total
                                            Amount</span>
                                        <span class="text-lg font-black text-primary-ref">
                                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="text-center">
                            <p class="text-xs font-bold text-slate-400">
                                Invoice ID: <span class="font-mono text-slate-600">{{ $payment->invoice_number }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection