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
    <style>
        :root {
            --bg-primary: #f8fafc;
            --bg-secondary: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-primary: rgba(0, 0, 0, 0.05);
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.5);
            --sidebar-bg: rgba(255, 255, 255, 0.9);
            --accent-primary: #6366f1;
            --header-bg: rgba(248, 250, 252, 0.8);
        }

        .dark {
            --bg-primary: #020617;
            --bg-secondary: #0f172a;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --border-primary: rgba(255, 255, 255, 0.1);
            --glass-bg: rgba(30, 41, 59, 0.4);
            --glass-border: rgba(255, 255, 255, 0.05);
            --sidebar-bg: rgba(15, 23, 42, 0.85);
            --accent-primary: #818cf8;
            --header-bg: rgba(2, 6, 23, 0.82);
        }

        * {
            transition: background-color 0.4s cubic-bezier(0.4, 0, 0.2, 1), 
                        border-color 0.4s cubic-bezier(0.4, 0, 0.2, 1), 
                        color 0.4s cubic-bezier(0.4, 0, 0.2, 1), 
                        box-shadow 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
        }
        .bg-app { background-color: var(--bg-primary); }
        .bg-app-secondary { background-color: var(--bg-secondary); }
        .text-app-primary { color: var(--text-primary); }
        .text-app-secondary { color: var(--text-secondary); }
        .border-app { border-color: var(--border-primary); }

        .glass {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
        }
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-primary);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.05);
        }
        .dark .glass-card {
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
        }
        .gradient-text {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .sidebar {
            background: var(--sidebar-bg);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-right: 1px solid var(--border-primary);
        }
        header {
            background: var(--header-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-primary);
        }

        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(99, 102, 241, 0.2);
            border-radius: 10px;
        }
        .dark ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(99, 102, 241, 0.4);
        }
        .dark ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.2);
        }
    </style>
    <script>
        // Inline script to prevent FOUC (Flash of Unstyled Content)
        (function() {
            try {
                const theme = localStorage.getItem('theme') || 'system';
                const isDark = theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
                document.documentElement.classList.toggle('dark', isDark);
            } catch (e) {
                console.error('Theme initialization failed:', e);
            }
        })();
    </script>
</head>
<body class="bg-app text-app-primary">
    <div class="fixed top-0 left-0 w-full h-full -z-10 bg-[radial-gradient(circle_at_0%_0%,rgba(99,102,241,0.05),transparent_40%),radial-gradient(circle_at_100%_100%,rgba(168,85,247,0.05),transparent_40%)] dark:bg-[radial-gradient(circle_at_0%_0%,rgba(99,102,241,0.12),transparent_40%),radial-gradient(circle_at_100%_100%,rgba(168,85,247,0.12),transparent_40%)]"></div>

    <div class="flex min-h-screen relative">
        <!-- Sidebar Overlay (Mobile) -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity duration-300 opacity-0"></div>

        <!-- Sidebar -->
        <aside class="sidebar w-64 fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="flex flex-col h-full p-6">
                <div class="flex items-center gap-3 mb-10 px-2 uppercase tracking-tighter">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20 glass">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Ticket<span class="gradient-text">Scan</span></h1>
                </div>

                <nav class="flex-1 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 dark:bg-indigo-600/20 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-500/20' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-slate-200' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.tickets.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.tickets.*') ? 'bg-indigo-50 dark:bg-indigo-600/20 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-500/20' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-slate-200' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <span>Tickets</span>
                    </a>
                    <a href="/" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-slate-200 transition-all duration-200 mt-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Back to Site</span>
                    </a>
                </nav>

                <div class="mt-auto px-4 py-4 glass rounded-2xl border border-indigo-100 dark:border-indigo-500/10">
                    <p class="text-xs text-slate-500 dark:text-slate-500 uppercase tracking-widest font-semibold mb-1">Admin User</p>
                    <p class="text-sm font-medium text-slate-700 dark:text-slate-300">Super Administrator</p>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 lg:ml-64 min-h-screen min-w-0">
            <header class="h-16 flex items-center justify-between px-4 sm:px-8 sticky top-0 z-40">
                <div class="lg:hidden">
                    <button id="sidebar-toggle" class="p-2 -ml-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors rounded-lg hover:bg-slate-100 dark:hover:bg-white/5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
                <div class="flex items-center gap-2 sm:gap-4 ml-auto">
                    <!-- Theme Switcher -->
                    <div class="flex items-center gap-1 glass rounded-full p-1 border border-slate-200 dark:border-white/5 shadow-sm">
                        <button onclick="setTheme('light')" id="theme-light" class="w-8 h-8 flex items-center justify-center rounded-full text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/5 hover:text-indigo-600 dark:hover:text-white transition-all theme-btn cursor-pointer" title="Light Theme">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                        <button onclick="setTheme('dark')" id="theme-dark" class="w-8 h-8 flex items-center justify-center rounded-full text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/5 hover:text-indigo-600 dark:hover:text-white transition-all theme-btn cursor-pointer" title="Dark Theme">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </button>
                        <button onclick="setTheme('system')" id="theme-system" class="w-8 h-8 flex items-center justify-center rounded-full text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/5 hover:text-indigo-600 dark:hover:text-white transition-all theme-btn cursor-pointer" title="System Preference">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </button>
                    </div>

                    <div class="hidden sm:block text-xs sm:text-sm text-slate-500 dark:text-slate-400 font-medium">
                        {{ now()->format('D, M d, Y') }}
                    </div>
                </div>
            </header>

            <div class="p-4 sm:p-8">
                @if(session('success'))
                <div class="mb-6 animate-in fade-in slide-in-from-top-4 duration-500">
                    <div class="glass-card bg-emerald-500/10 border-emerald-500/20 rounded-2xl p-4 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="text-emerald-600 dark:text-emerald-400 font-medium text-sm">{{ session('success') }}</p>
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
            
            document.documentElement.classList.toggle('dark', isDark);
            
            // Update buttons
            // Update buttons
            document.querySelectorAll('.theme-btn').forEach(btn => {
                btn.classList.remove('bg-indigo-600', 'text-white', 'shadow-md', 'shadow-indigo-500/20', 'scale-110');
                btn.classList.add('text-slate-500', 'dark:text-slate-400');
            });
            
            const activeBtn = document.getElementById('theme-' + theme);
            if (activeBtn) {
                activeBtn.classList.remove('text-slate-500', 'dark:text-slate-400');
                activeBtn.classList.add('bg-indigo-600', 'text-white', 'shadow-md', 'shadow-indigo-500/20', 'scale-110');
            }
        }

        // Initialize UI
        document.addEventListener('DOMContentLoaded', function() {
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

                document.addEventListener('keydown', function(event) {
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

