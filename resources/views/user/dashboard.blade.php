<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>User Activity Dashboard</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Spline+Sans:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>
<body class="bg-surface-light text-primary-black font-display min-h-screen flex flex-col antialiased selection:bg-primary selection:text-white">
<header class="px-6 py-8 flex items-center justify-between sticky top-0 z-50 bg-surface-light/95 backdrop-blur-md">
    <div class="flex flex-col">
        <span class="text-sm text-gray-500 font-medium mb-1">{{ now()->format('l, M d') }}</span>
        <h1 class="text-2xl font-bold tracking-tight text-primary-black">Welcome back, {{ auth()->user()->name }}!</h1>
    </div>
    <div class="relative">
        <a href="{{ route('profile.edit') }}" class="relative block rounded-full border-2 border-primary/30 p-0.5 overflow-hidden">
            <img alt="User Profile" class="w-10 h-10 rounded-full object-cover" data-alt="User avatar" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=e61f27&color=fff"/>
        </a>
        <span class="absolute top-0 right-0 w-3 h-3 bg-primary rounded-full border-2 border-surface-light"></span>
    </div>
</header>
<main class="flex-1 px-6 pb-24 space-y-8 overflow-y-auto">
    <section aria-label="Key Statistics">
        <div class="grid grid-cols-3 gap-4">
            <div class="flex flex-col items-center p-4 bg-card-bg rounded-xl shadow-card border border-gray-100 hover:shadow-card-hover transition-shadow">
                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center mb-3">
                    <span class="material-icons text-primary">confirmation_number</span>
                </div>
                <span class="text-3xl font-bold text-gray-500 mb-1">{{ $activeTicketsCount }}</span>
                <span class="text-xs text-gray-500 text-center font-medium">Active<br/>Tickets</span>
            </div>
            <div class="flex flex-col items-center p-4 bg-card-bg rounded-xl shadow-card border border-gray-100 hover:shadow-card-hover transition-shadow">
                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center mb-3">
                    <span class="material-icons text-primary">credit_card</span>
                </div>
                <span class="text-3xl font-bold text-gray-500 mb-1">{{ $pendingPaymentsCount }}</span>
                <span class="text-xs text-gray-500 text-center font-medium">Pending<br/>Payments</span>
            </div>
            <div class="flex flex-col items-center p-4 bg-card-bg rounded-xl shadow-card border border-gray-100 hover:shadow-card-hover transition-shadow">
                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center mb-3">
                    <span class="material-icons text-primary">star</span>
                </div>
                <span class="text-3xl font-bold text-gray-500 mb-1">{{ number_format($loyaltyPoints) }}</span>
                <span class="text-xs text-gray-500 text-center font-medium">Loyalty<br/>Points</span>
            </div>
        </div>
    </section>
    <section>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-primary-black">Recent Activity</h2>
            <a class="text-sm text-primary hover:text-primary-dark transition-colors" href="{{ route('user.tickets.index') }}">View All</a>
        </div>
        <div class="flex space-x-4 overflow-x-auto no-scrollbar pb-2 -mx-6 px-6 snap-x snap-mandatory">
            @forelse($recentTickets as $ticket)
                <div class="snap-center shrink-0 w-[85%] sm:w-[300px] flex flex-col bg-card-bg rounded-2xl overflow-hidden shadow-card border border-gray-100 relative group">
                    <div class="h-32 bg-gray-200 relative">
                        <!-- Placeholder image since we don't know if event has image -->
                        <img alt="Event Image" class="w-full h-full object-cover" src="https://placehold.co/600x400/e61f27/ffffff?text={{ urlencode($ticket->type) }}"/>
                        @if($ticket->scanned_at)
                            <div class="absolute top-3 right-3 bg-gray-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">Used</div>
                        @else
                            <div class="absolute top-3 right-3 bg-primary text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">Active</div>
                        @endif
                    </div>
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-bold text-lg leading-tight text-primary-black">{{ $ticket->event->title ?? $ticket->type }}</h3>
                        </div>
                        <p class="text-sm text-gray-500 mb-4">{{ $ticket->event->location ?? 'Venue TBD' }}</p>
                        <div class="grid grid-cols-2 gap-y-3 gap-x-2 text-sm">
                            <div class="flex flex-col">
                                <span class="text-xs text-gray-400 uppercase font-semibold">Type</span>
                                <span class="font-medium text-primary-black">{{ $ticket->type }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs text-gray-400 uppercase font-semibold">Seat</span>
                                <span class="font-medium text-primary-black">{{ $ticket->seat_number }}</span>
                            </div>
                            <div class="flex flex-col col-span-2 mt-2 pt-3 border-t border-gray-100">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-400 uppercase font-semibold">Total Price</span>
                                    <span class="text-lg font-bold text-primary-black">${{ number_format($ticket->price, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="w-full p-4 text-center text-gray-500">
                    No recent tickets found.
                </div>
            @endforelse
        </div>
    </section>
    <section class="grid gap-4">
        <div class="bg-card-bg rounded-2xl p-5 shadow-card border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-primary/10 rounded-full">
                        <span class="material-icons text-primary text-xl">receipt_long</span>
                    </div>
                    <h3 class="font-bold text-lg text-primary-black">Billing &amp; Payments</h3>
                </div>
                <a class="text-sm text-primary hover:text-primary-dark transition-colors" href="{{ route('user.payments.index') }}">View All</a>
            </div>
            <div class="space-y-4">
                @forelse($recentPayments as $payment)
                    <div class="flex items-center justify-between py-2 {{ $loop->last ? '' : 'border-b border-gray-100' }}">
                        <div class="flex flex-col">
                            <span class="font-medium text-sm text-primary-black">Invoice #{{ $payment->id }}</span>
                            <span class="text-xs text-gray-500">{{ $payment->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="text-right">
                            <span class="block font-bold {{ $payment->status == 'pending' ? 'text-primary' : 'text-gray-400' }}">${{ number_format($payment->amount, 2) }}</span>
                            @if($payment->status == 'pending')
                                <span class="text-xs text-yellow-500 font-medium capitalize">{{ $payment->status }}</span>
                            @elseif($payment->status == 'paid')
                                <span class="text-xs text-green-500 font-medium capitalize">{{ $payment->status }}</span>
                            @else
                                <span class="text-xs text-gray-500 font-medium capitalize">{{ $payment->status }}</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-center text-gray-500 py-2">No recent payments.</p>
                @endforelse
            </div>
        </div>
        <div class="relative overflow-hidden rounded-2xl p-6 bg-gradient-to-br from-primary to-primary-black">
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <h3 class="text-white font-bold text-lg mb-1">Upgrade to VIP</h3>
                    <p class="text-white/80 text-xs mb-3 max-w-[180px]">Get exclusive access and 2x points on your next purchase.</p>
                    <button class="bg-white text-primary text-xs font-bold px-4 py-2 rounded-full shadow-lg hover:bg-gray-100 transition-colors">Learn More</button>
                </div>
                <span class="material-icons text-white/20 text-6xl">diamond</span>
            </div>
        </div>
    </section>
</main>
<nav class="fixed bottom-0 left-0 w-full bg-surface-light border-t border-gray-200 px-6 py-3 z-50 safe-area-bottom shadow-[0_-4px_16px_rgba(0,0,0,0.03)]">
    <ul class="flex justify-between items-center max-w-md mx-auto">
        <li>
            <a class="flex flex-col items-center gap-1 group" href="{{ route('user.dashboard') }}">
                <span class="material-icons {{ request()->routeIs('user.dashboard') ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }} text-2xl transition-all">dashboard</span>
                <span class="text-[10px] font-medium {{ request()->routeIs('user.dashboard') ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }} transition-colors">Home</span>
            </a>
        </li>
        <li>
            <a class="flex flex-col items-center gap-1 group" href="{{ route('user.tickets.index') }}">
                <span class="material-icons {{ request()->routeIs('user.tickets.*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }} text-2xl transition-colors">confirmation_number</span>
                <span class="text-[10px] font-medium {{ request()->routeIs('user.tickets.*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }} transition-colors">My Tickets</span>
            </a>
        </li>
        <li class="relative -top-5">
            <a class="flex items-center justify-center w-14 h-14 bg-primary rounded-full shadow-lg shadow-primary/40 hover:scale-105 transition-transform" href="{{ route('events.index') }}">
                <span class="material-icons text-white text-2xl">add</span>
            </a>
        </li>
        <li>
            <a class="flex flex-col items-center gap-1 group" href="{{ route('events.index') }}">
                <span class="material-icons {{ request()->routeIs('events.*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }} text-2xl transition-colors">search</span>
                <span class="text-[10px] font-medium {{ request()->routeIs('events.*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }} transition-colors">Explore</span>
            </a>
        </li>
        <li>
            <a class="flex flex-col items-center gap-1 group" href="{{ route('profile.edit') }}">
                <span class="material-icons {{ request()->routeIs('profile.*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }} text-2xl transition-colors">person</span>
                <span class="text-[10px] font-medium {{ request()->routeIs('profile.*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }} transition-colors">Profile</span>
            </a>
        </li>
    </ul>
</nav>

</body></html>
