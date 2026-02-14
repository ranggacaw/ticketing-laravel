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