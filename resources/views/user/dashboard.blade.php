@extends('user.layouts.app')

@section('content')
    <div class="min-h-screen pb-24 font-display text-slate-900 -mx-4 md:-mx-8 px-6">
        <!-- Header Section -->
        <x-page-header :title="'Welcome back, ' . auth()->user()->name . '!'" :subtitle="now()->format('l, M d')">
        </x-page-header>

        <main class="space-y-8 mt-3">
            <!-- Key Statistics Section -->
            <section aria-label="Key Statistics">
                <div class="grid grid-cols-3 gap-4">
                    <div
                        class="flex flex-col items-center p-4 bg-white rounded-3xl shadow-lg shadow-slate-200/50 border border-slate-100 hover:shadow-xl transition-all duration-300">
                        <div class="w-12 h-12 rounded-2xl bg-primary-ref/10 flex items-center justify-center mb-3">
                            <span class="material-symbols-outlined text-primary-ref text-2xl">confirmation_number</span>
                        </div>
                        <span class="text-2xl font-black text-slate-900 mb-1">{{ $activeTicketsCount }}</span>
                        <span class="text-[10px] text-slate-400 uppercase tracking-wider font-bold text-center">Active<br />Tickets</span>
                    </div>
                    <div
                        class="flex flex-col items-center p-4 bg-white rounded-3xl shadow-lg shadow-slate-200/50 border border-slate-100 hover:shadow-xl transition-all duration-300">
                        <div class="w-12 h-12 rounded-2xl bg-primary-ref/10 flex items-center justify-center mb-3">
                            <span class="material-symbols-outlined text-primary-ref text-2xl">account_balance_wallet</span>
                        </div>
                        <span class="text-2xl font-black text-slate-900 mb-1">{{ $pendingPaymentsCount }}</span>
                        <span class="text-[10px] text-slate-400 uppercase tracking-wider font-bold text-center">Pending<br />Payments</span>
                    </div>
                    <div
                        class="flex flex-col items-center p-4 bg-white rounded-3xl shadow-lg shadow-slate-200/50 border border-slate-100 hover:shadow-xl transition-all duration-300">
                        <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center mb-3">
                            <span class="material-symbols-outlined text-amber-600 text-2xl">stars</span>
                        </div>
                        <span class="text-2xl font-black text-slate-900 mb-1">{{ number_format($loyaltyPoints) }}</span>
                        <span class="text-[10px] text-slate-400 uppercase tracking-wider font-bold text-center">Loyalty<br />Points</span>
                    </div>
                </div>
            </section>

            <!-- Browse Events Section -->
            <section>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-black text-slate-900">Explore Events</h2>
                    <a class="text-sm font-bold text-primary-ref hover:text-red-700 transition-colors flex items-center gap-1"
                        href="{{ route('events.index') }}">
                        Browse All
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
                <div class="flex space-x-6 overflow-x-auto no-scrollbar pb-4 -mx-4 px-4 snap-x snap-mandatory">
                    @forelse($latestEvents as $event)
                        <div onclick="window.location='{{ route('events.show', $event) }}'"
                            class="snap-center shrink-0 w-[13rem] bg-white rounded-3xl overflow-hidden shadow-lg shadow-slate-200/50 border border-slate-100 group transition-all duration-300 hover:shadow-xl cursor-pointer">
                            <div class="h-32 bg-slate-900 relative overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-br from-primary-ref/80 to-slate-900"></div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-5xl text-white/20">event</span>
                                </div>
                                <div class="absolute top-3 right-3">
                                    <span class="text-[9px] font-black text-white bg-primary-ref px-2 py-0.5 rounded-full uppercase tracking-wider">
                                        {{ $event->start_time?->format('M d') ?? 'TBA' }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-5">
                                <h3 class="font-bold text-slate-900 leading-tight mb-1 truncate">
                                    {{ $event->name }}
                                </h3>
                                <p class="text-[10px] text-slate-500 mb-3 flex items-center">
                                    <span class="material-symbols-outlined text-[12px] mr-1 opacity-70">location_on</span>
                                    <span class="truncate">{{ $event->venue->name ?? 'Venue TBD' }}</span>
                                </p>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-black text-primary-ref">View Details</span>
                                    <span class="material-symbols-outlined text-sm text-primary-ref group-hover:translate-x-1 transition-transform">arrow_forward</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="w-full py-8 flex flex-col items-center justify-center bg-white rounded-3xl border border-dashed border-slate-200 text-center">
                            <span class="material-symbols-outlined text-4xl text-slate-200 mb-3">event_busy</span>
                            <p class="text-sm text-slate-400 font-medium">No events available right now.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- Recent Activity Section -->
            <section>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-black text-slate-900">Recent Activity</h2>
                    <a class="text-sm font-bold text-primary-ref hover:text-red-700 transition-colors flex items-center gap-1"
                        href="{{ route('user.tickets.index') }}">
                        View All
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
                <div class="flex space-x-6 overflow-x-auto no-scrollbar pb-4 -mx-4 px-4 snap-x snap-mandatory">
                    @forelse($recentTickets as $ticket)
                        <div
                            class="snap-center shrink-0 w-[280px] bg-white rounded-3xl overflow-hidden shadow-lg shadow-slate-200/50 border border-slate-100 group transition-all duration-300 hover:shadow-xl">
                            <div class="h-32 bg-slate-900 relative overflow-hidden">
                                <div class="absolute inset-0 opacity-40 bg-gradient-to-br from-primary-ref to-slate-900"></div>
                                <div class="absolute inset-0 flex items-center justify-center opacity-10">
                                    <span class="material-symbols-outlined text-8xl text-white">confirmation_number</span>
                                </div>
                                @if($ticket->scanned_at)
                                    <div
                                        class="absolute top-4 right-4 bg-slate-100/90 backdrop-blur-md text-slate-400 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider border border-slate-200">
                                        Used</div>
                                @else
                                    <div
                                        class="absolute top-4 right-4 bg-white/90 backdrop-blur-md text-primary-ref text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">
                                        Active</div>
                                @endif
                                <div class="absolute bottom-4 left-4">
                                    <span class="text-white font-black text-[10px] bg-primary-ref px-2 py-1 rounded uppercase tracking-wider">
                                        {{ $ticket->event?->start_time?->format('M d') ?? 'TBA' }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-5">
                                <h3 class="font-bold text-slate-900 leading-tight mb-1 truncate">
                                    {{ $ticket->event->name ?? $ticket->type }}
                                </h3>
                                <p class="text-xs text-slate-500 mb-4 flex items-center">
                                    <span class="material-symbols-outlined text-xs mr-1 opacity-70">location_on</span>
                                    <span class="truncate">{{ $ticket->event->venue->name ?? 'Venue TBD' }}</span>
                                </p>
                                <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                                    <div class="flex flex-col">
                                        <span class="text-[9px] text-slate-400 uppercase font-black tracking-tighter">Seat</span>
                                        <span class="font-bold text-slate-900 text-sm">{{ $ticket->seat_number }}</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-[9px] text-slate-400 uppercase font-black tracking-tighter block leading-none">Price</span>
                                        <span class="text-base font-black text-slate-900">
                                            Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="w-full py-12 flex flex-col items-center justify-center bg-white rounded-3xl border border-dashed border-slate-200 text-center">
                            <span class="material-symbols-outlined text-4xl text-slate-200 mb-3">confirmation_number_off</span>
                            <p class="text-sm text-slate-400 font-medium">No recent tickets found.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- Billing & VIP Section -->
            <section class="grid md:grid-cols-2 gap-6">
                <!-- Billing Card -->
                <div class="bg-white rounded-3xl p-6 shadow-lg shadow-slate-200/50 border border-slate-100">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-primary-ref/10 rounded-xl flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary-ref">receipt_long</span>
                            </div>
                            <h3 class="font-black text-lg text-slate-900">Billing</h3>
                        </div>
                        <a class="text-xs font-bold text-primary-ref hover:text-red-700 transition-colors"
                            href="{{ route('user.payments.index') }}">View All</a>
                    </div>
                    <div class="space-y-4">
                        @forelse($recentPayments as $payment)
                            <div
                                class="flex items-center justify-between group">
                                <div class="flex flex-col">
                                    <span class="font-bold text-sm text-slate-900 group-hover:text-primary-ref transition-colors">#{{ $payment->id }}</span>
                                    <span class="text-[10px] text-slate-400 font-medium uppercase tracking-wider">{{ $payment->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="text-right">
                                    <span
                                        class="block font-black text-sm text-slate-900 leading-none mb-1">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                                    @if($payment->status == 'pending')
                                        <span class="text-[9px] text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full font-black uppercase tracking-wider border border-amber-100">{{ $payment->status }}</span>
                                    @elseif($payment->status == 'paid')
                                        <span class="text-[9px] text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full font-black uppercase tracking-wider border border-emerald-100">{{ $payment->status }}</span>
                                    @else
                                        <span class="text-[9px] text-slate-400 bg-slate-50 px-2 py-0.5 rounded-full font-black uppercase tracking-wider border border-slate-100">{{ $payment->status }}</span>
                                    @endif
                                </div>
                            </div>
                            @if(!$loop->last)
                                <div class="h-px bg-slate-50"></div>
                            @endif
                        @empty
                            <p class="text-sm text-center text-slate-400 py-4 font-medium italic">No recent payments.</p>
                        @endforelse
                    </div>
                </div>

                <!-- VIP Promo Card -->
                <div class="relative overflow-hidden rounded-3xl p-8 bg-slate-900 group">
                    <!-- Background Effects -->
                    <div class="absolute -right-12 -top-12 w-48 h-48 bg-primary-ref/20 rounded-full blur-[64px] group-hover:bg-primary-ref/30 transition-colors duration-500"></div>
                    <div class="absolute -left-12 -bottom-12 w-48 h-48 bg-primary-ref/10 rounded-full blur-[64px] group-hover:bg-primary-ref/20 transition-colors duration-500"></div>
                    
                    <div class="relative z-10 flex flex-col h-full justify-between">
                        <div>
                            <div class="inline-flex items-center gap-2 px-3 py-1 bg-primary-ref/20 rounded-full mb-4">
                                <span class="material-symbols-outlined text-primary-ref text-sm">diamond</span>
                                <span class="text-[10px] font-black text-primary-ref uppercase tracking-widest">Exclusive Offer</span>
                            </div>
                            <h3 class="text-white font-black text-2xl mb-2 leading-tight">Upgrade to <span class="text-primary-ref">VIP</span></h3>
                            <p class="text-slate-400 text-sm mb-6 max-w-[200px] leading-relaxed">Get exclusive access and 2x points on your next purchase.</p>
                        </div>
                        <button
                            class="w-full bg-white text-slate-900 font-black text-sm py-4 rounded-2xl shadow-xl hover:bg-primary-ref hover:text-white transition-all duration-300 transform group-hover:translate-y-[-2px]">
                            Learn More
                        </button>
                    </div>
                </div>
            </section>
        </main>
    </div>
@endsection