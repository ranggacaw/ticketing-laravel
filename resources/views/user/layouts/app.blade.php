<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Portal | Tiketcaw</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="min-h-screen bg-base-200 text-base-content">

    <!-- Global Header -->
    <header
        class="fixed top-0 w-full glass z-30 px-6 py-4 flex justify-between items-center border-b border-base-300/50">
        <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 group">
            <img src="{{ asset('tiketcaw-logo.png') }}" alt="Tiketcaw Logo" class="w-32 object-contain">
        </a>
        <!-- <div class="flex items-center space-x-3">
            <a href="{{ route('profile.edit') }}"
                class="flex items-center space-x-3 p-1 px-3 rounded-full bg-base-100 border border-base-300/50 hover:bg-base-200 transition-colors">
                <span class="text-sm font-medium text-base-content/80">{{ auth()->user()->name }}</span>
                <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="p-2 text-base-content/40 hover:text-error transition-colors"
                    title="Sign Out">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                </button>
            </form>
        </div> -->
    </header>

    <!-- Main Content -->
    <main class="pt-24 min-h-screen pb-32">
        <div class="px-4 md:px-8 max-w-7xl mx-auto">
            @yield('content')
        </div>
    </main>

    <x-bottom-navigation />


    @include('user.components.toast')

</body>

</html>