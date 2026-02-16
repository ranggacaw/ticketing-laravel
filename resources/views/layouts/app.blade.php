<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiketcaw | High-Fidelity Prototype</title>
    <!-- No CDNs -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="min-h-screen flex flex-col items-center justify-center p-4 bg-base-200 text-base-content">
    <main class="w-full max-w-md">
        @yield('content')
    </main>

    <footer class="mt-8 text-base-content/50 text-sm font-light">
        &copy; 2026 Cawticket Scanner
    </footer>
    @livewireScripts
</body>

</html>