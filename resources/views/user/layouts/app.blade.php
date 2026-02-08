<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Portal | TicketScan</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: #0f172a;
            color: #f8fafc;
        }

        .glass {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .nav-active {
            background: rgba(99, 102, 241, 0.1);
            color: #818cf8;
            border-right: 2px solid #6366f1;
        }

        /* Mobile Nav Active */
        .mobile-nav-active {
            color: #818cf8;
        }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="min-h-screen bg-slate-900 text-slate-100">

    <!-- Desktop Sidebar -->
    <aside class="fixed top-0 left-0 h-full w-64 glass hidden md:flex flex-col z-20">
        <div class="p-6 border-b border-white/5">
            <h1 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 to-cyan-400">
                TicketScan
            </h1>
        </div>

        <nav class="flex-1 py-6 px-3 space-y-1">
            <a href="{{ route('user.dashboard') }}"
                class="flex items-center px-4 py-3 rounded-lg text-slate-400 hover:text-white hover:bg-white/5 transition-colors {{ request()->routeIs('user.dashboard') ? 'nav-active' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                    </path>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('user.tickets.index') }}"
                class="flex items-center px-4 py-3 rounded-lg text-slate-400 hover:text-white hover:bg-white/5 transition-colors {{ request()->routeIs('user.tickets.*') ? 'nav-active' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                    </path>
                </svg>
                My Tickets
            </a>

            <a href="{{ route('user.payments.index') }}"
                class="flex items-center px-4 py-3 rounded-lg text-slate-400 hover:text-white hover:bg-white/5 transition-colors {{ request()->routeIs('user.payments.*') ? 'nav-active' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                    </path>
                </svg>
                Payments
            </a>

            <a href="{{ route('user.profile.edit') }}"
                class="flex items-center px-4 py-3 rounded-lg text-slate-400 hover:text-white hover:bg-white/5 transition-colors {{ request()->routeIs('user.profile.*') ? 'nav-active' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Profile
            </a>
        </nav>

        <div class="p-4 border-t border-white/5">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="flex items-center w-full px-4 py-2 text-sm text-slate-400 hover:text-red-400 transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    Sign Out
                </button>
            </form>
        </div>
    </aside>

    <!-- Mobile Header -->
    <header class="md:hidden fixed top-0 w-full glass z-30 px-4 py-3 flex justify-between items-center">
        <h1 class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 to-cyan-400">
            TicketScan
        </h1>
        <div class="flex items-center space-x-4">
            <a href="{{ route('user.profile.edit') }}"
                class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center text-sm font-bold text-white">
                {{ substr(auth()->user()->name, 0, 1) }}
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="md:pl-64 pt-16 md:pt-0 min-h-screen pb-20 md:pb-8">
        <div class="p-4 md:p-8 max-w-7xl mx-auto">
            <!-- Desktop Top Bar -->
            <div class="hidden md:flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-white">@yield('header', 'Dashboard')</h2>
                    <p class="text-slate-400 text-sm">@yield('subheader', 'Welcome back, ' . auth()->user()->name)</p>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Notifications (Future) -->
                    <button class="p-2 text-slate-400 hover:text-white relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                    </button>
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-lg">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </div>

            @yield('content')
        </div>
    </main>

    <!-- Mobile Bottom Nav -->
    <nav
        class="md:hidden fixed bottom-0 w-full glass z-30 border-t border-white/10 px-6 py-3 flex justify-between items-center">
        <a href="{{ route('user.dashboard') }}"
            class="flex flex-col items-center {{ request()->routeIs('user.dashboard') ? 'mobile-nav-active' : 'text-slate-500' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                </path>
            </svg>
            <span class="text-xs">Home</span>
        </a>
        <a href="{{ route('user.tickets.index') }}"
            class="flex flex-col items-center {{ request()->routeIs('user.tickets.*') ? 'mobile-nav-active' : 'text-slate-500' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                </path>
            </svg>
            <span class="text-xs">Tickets</span>
        </a>
        <a href="{{ route('user.payments.index') }}"
            class="flex flex-col items-center {{ request()->routeIs('user.payments.*') ? 'mobile-nav-active' : 'text-slate-500' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
            </svg>
            <span class="text-xs">Pay</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        <button onclick="document.getElementById('logout-form').submit()"
            class="flex flex-col items-center text-slate-500">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                </path>
            </svg>
            <span class="text-xs">Exit</span>
        </button>
    </nav>

    @include('user.components.toast')

</body>

</html>