<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Portal | Tiketcaw</title>
    <!-- Fonts -->
    <!-- No CDNs - all assets bundled via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="min-h-screen bg-base-200 text-base-content">


    <!-- Global Header -->
    <header x-data="{ scrolled: false }" x-init="scrolled = (window.scrollY > 20)"
        @scroll.window="scrolled = (window.scrollY > 20)"
        class="fixed top-0 w-full glass z-30 px-6 py-4 flex justify-between items-center border-b border-base-300/50 transition-all duration-300"
        :class="{ 'py-3 bg-base-100/90': scrolled }">
        <div class="flex items-center">
            <div x-show="scrolled" x-transition:enter="transition-all ease-out duration-300"
                x-transition:enter-start="opacity-0 w-0 -translate-x-4"
                x-transition:leave="transition-all ease-in duration-300"
                x-transition:leave-end="opacity-0 w-0 -translate-x-4" class="overflow-hidden whitespace-nowrap"
                style="display: none;">
                <button @click="window.history.back()" class="btn btn-circle btn-ghost btn-sm mr-2"
                    aria-label="Go back">
                    <span class="material-symbols-outlined">arrow_back</span>
                </button>
            </div>
            <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('tiketcaw-logo.png') }}" alt="Tiketcaw Logo" class="w-32 object-contain">
            </a>
        </div>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex items-center space-x-8">
            <a href="{{ route('user.dashboard') }}"
                class="text-sm font-bold {{ request()->routeIs('user.dashboard') ? 'text-primary-ref' : 'text-slate-600 hover:text-slate-900' }} transition-colors">
                Dashboard
            </a>
            <a href="{{ route('events.index') }}"
                class="text-sm font-bold {{ request()->routeIs('events.index') ? 'text-primary-ref' : 'text-slate-600 hover:text-slate-900' }} transition-colors">
                Browse Events
            </a>
            <a href="{{ route('user.tickets.index') }}"
                class="text-sm font-bold {{ request()->routeIs('user.tickets.*') ? 'text-primary-ref' : 'text-slate-600 hover:text-slate-900' }} transition-colors">
                My Tickets
            </a>
            <a href="{{ route('favorites.index') }}"
                class="text-sm font-bold {{ request()->routeIs('favorites.index') ? 'text-primary-ref' : 'text-slate-600 hover:text-slate-900' }} transition-colors">
                Wishlist
            </a>

            <!-- User Menu -->
            <div class="relative ml-4" x-data="{ open: false }">
                <button @click="open = !open" @click.away="open = false"
                    class="flex items-center gap-2 text-sm font-bold text-slate-900 hover:text-primary-ref transition-colors focus:outline-none">
                    <span>{{ auth()->user()->name }}</span>
                    <div
                        class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-primary-ref border border-slate-200">
                        <span class="material-symbols-outlined text-lg">person</span>
                    </div>
                </button>
                <!-- Dropdown menu -->
                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 py-1 z-50 origin-top-right"
                    style="display: none;">
                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary-ref font-bold transition-colors">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">settings</span>
                            Profile Settings
                        </div>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-bold transition-colors">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-lg">logout</span>
                                Log Out
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="pt-24 min-h-screen pb-32 md:pb-12">
        @yield('content-full')

        @hasSection('content')
            <div class="px-4 md:px-8 max-w-7xl mx-auto">
                @yield('content')
            </div>
        @endif
    </main>

    <div class="md:hidden">
        <x-bottom-navigation />
    </div>


    @include('user.components.toast')

    @livewireScripts
</body>

</html>