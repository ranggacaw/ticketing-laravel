<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | TicketScan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Inline script to prevent FOUC (Flash of Unstyled Content)
        (function () {
            try {
                const theme = localStorage.getItem('theme') || 'system';
                const isDark = theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
                document.documentElement.setAttribute('data-theme', isDark ? 'dark' : 'light');
            } catch (e) {
                console.error('Theme initialization failed:', e);
            }
        })();
    </script>
</head>

<body class="bg-base-100 text-base-content min-h-screen">


    <div class="flex min-h-screen relative">
        <!-- Sidebar Overlay (Mobile) -->
        <div id="sidebar-overlay"
            class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity duration-300 opacity-0">
        </div>

        <!-- Sidebar -->
        <aside
            class="w-64 fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out bg-base-200 border-r border-base-300">
            <div class="flex flex-col h-full p-6">
                <div class="flex items-center gap-3 mb-10 px-2 uppercase tracking-tighter">
                    <div
                        class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20 glass">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Ticket<span
                            class="gradient-text">Scan</span></h1>
                </div>

                <ul class="menu flex-1 w-full p-2 gap-2">
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'staff')
                        <li>
                            <a href="{{ route('admin.dashboard') }}"
                                class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('events.index') }}"
                                class="{{ request()->routeIs('events.*') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <span>Browse Events</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.tickets.index') }}"
                                class="{{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <span>Tickets</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.history.index') }}"
                                class="{{ request()->routeIs('admin.history.*') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>User History</span>
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->role === 'admin')
                        <li>
                            <a href="{{ route('admin.users.index') }}"
                                class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span>Manage Users</span>
                            </a>
                        </li>
                    @endif

                    <li class="mt-auto">
                        <a href="{{ route('scan') }}" class="{{ request()->routeIs('scan') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                            <span>Scan Ticket</span>
                        </a>
                    </li>
                </ul>

                <div class="mt-auto p-4 bg-base-100 shadow-sm border border-base-300 rounded-box">
                    <p class="text-[10px] text-base-content/60 uppercase tracking-widest font-bold mb-1">
                        Signed in as</p>
                    <p class="text-sm font-bold text-base-content truncate">{{ auth()->user()->name }}
                    </p>
                    <p class="text-[10px] text-primary font-bold uppercase tracking-widest mt-0.5">
                        {{ auth()->user()->role }}
                    </p>

                    <a href="{{ route('my.history') }}"
                        class="flex items-center gap-2 mt-3 px-3 py-2 rounded-lg text-xs font-medium text-base-content/70 hover:bg-base-200 hover:text-primary transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        My Activity
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full btn btn-sm btn-outline btn-error gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 lg:ml-64 min-h-screen min-w-0">
            <header
                class="navbar bg-base-100/80 backdrop-blur sticky top-0 z-40 border-b border-base-300 px-4 sm:px-8 h-16">
                <div class="lg:hidden mr-2">
                    <button id="sidebar-toggle" class="btn btn-square btn-ghost btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
                <div class="flex items-center gap-2 sm:gap-4 ml-auto">
                    <!-- Theme Switcher -->
                    <div class="flex items-center gap-1 bg-base-200 rounded-full p-1 border border-base-300 shadow-sm">
                        <button onclick="setTheme('light')" id="theme-light"
                            class="btn btn-circle btn-xs btn-ghost theme-btn" title="Light Theme">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                        <button onclick="setTheme('dark')" id="theme-dark"
                            class="btn btn-circle btn-xs btn-ghost theme-btn" title="Dark Theme">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </button>
                        <button onclick="setTheme('system')" id="theme-system"
                            class="btn btn-circle btn-xs btn-ghost theme-btn" title="System Preference">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </button>
                    </div>

                    <div class="hidden sm:block text-xs sm:text-sm text-base-content/60 font-medium">
                        {{ now()->format('D, M d, Y') }}
                    </div>
                </div>
            </header>

            <div class="p-4 sm:p-8">
                @if(session('success'))
                    <div class="mb-6 animate-in fade-in slide-in-from-top-4 duration-500">
                        <div
                            class="glass-card bg-emerald-500/10 border-emerald-500/20 rounded-2xl p-4 flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <p class="text-emerald-600 dark:text-emerald-400 font-medium text-sm">{{ session('success') }}
                            </p>
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Theme logic
        function setTheme(theme) {
            if (theme === 'system') {
                localStorage.removeItem('theme');
            } else {
                localStorage.setItem('theme', theme);
            }
            updateThemeUI();
        }

        function updateThemeUI() {
            const theme = localStorage.getItem('theme') || 'system';
            const isDark = theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);

            document.documentElement.setAttribute('data-theme', isDark ? 'dark' : 'light');

            // Update buttons
            // Update buttons
            document.querySelectorAll('.theme-btn').forEach(btn => {
                btn.classList.remove('bg-base-100', 'shadow-sm', 'text-primary');
                btn.classList.add('text-base-content/60');
            });

            const activeBtn = document.getElementById('theme-' + theme);
            if (activeBtn) {
                activeBtn.classList.remove('text-base-content/60');
                activeBtn.classList.add('bg-base-100', 'shadow-sm', 'text-primary');
            }
        }

        // Initialize UI
        document.addEventListener('DOMContentLoaded', function () {
            updateThemeUI();

            // Sidebar toggle logic
            const toggle = document.getElementById('sidebar-toggle');
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            function toggleSidebar() {
                const isOpen = !sidebar.classList.contains('-translate-x-full');
                if (isOpen) {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                    overlay.classList.remove('opacity-100');
                    overlay.classList.add('opacity-0');
                    document.body.style.overflow = '';
                } else {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                    setTimeout(() => {
                        overlay.classList.add('opacity-100');
                        overlay.classList.remove('opacity-0');
                    }, 10);
                    document.body.style.overflow = 'hidden';
                }
            }

            if (toggle && sidebar && overlay) {
                toggle.addEventListener('click', toggleSidebar);
                overlay.addEventListener('click', toggleSidebar);

                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
                        toggleSidebar();
                    }
                });
            }

            // Sync with system changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                if (!localStorage.getItem('theme')) updateThemeUI();
            });
        });
    </script>
</body>

</html>