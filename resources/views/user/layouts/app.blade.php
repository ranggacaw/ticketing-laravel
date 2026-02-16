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
    </header>

    <!-- Main Content -->
    <main class="pt-24 min-h-screen pb-32">
        @yield('content-full')

        @hasSection('content')
            <div class="px-4 md:px-8 max-w-7xl mx-auto">
                @yield('content')
            </div>
        @endif
    </main>

    <x-bottom-navigation />


    @include('user.components.toast')

    @livewireScripts
</body>

</html>