<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'TicketScan') }} | Browse Events</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950 text-slate-100 font-sans antialiased">
    <div class="drawer">
        <input id="my-drawer-3" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col min-h-screen">
            <!-- Navbar -->
            <div class="w-full navbar bg-slate-900/90 backdrop-blur sticky top-0 z-50 border-b border-white/5">
                <div class="flex-none lg:hidden">
                    <label for="my-drawer-3" aria-label="open sidebar" class="btn btn-square btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            class="inline-block w-6 h-6 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </label>
                </div>
                <div class="flex-1 px-4 text-xl font-bold tracking-tight">
                    <a href="{{ url('/') }}" class="flex items-center gap-2">
                        <span
                            class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 to-cyan-400">TicketScan</span>
                    </a>
                </div>
                <div class="flex-none hidden lg:block">
                    <ul class="menu menu-horizontal gap-2">
                        <!-- Navbar menu content here -->
                        <li><a href="{{ route('events.index') }}"
                                class="font-medium {{ request()->routeIs('events.*') ? 'active' : '' }}">Events</a></li>
                        @auth
                            <li>
                                <details class="dropdown dropdown-end">
                                    <summary class="m-1 btn btn-ghost btn-sm">{{ auth()->user()->name }}</summary>
                                    <ul
                                        class="p-2 shadow-2xl menu dropdown-content z-[1] bg-slate-800 border border-white/5 rounded-box w-52">
                                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'staff')
                                            <li><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                                        @elseif(auth()->user()->role === 'volunteer')
                                            <li><a href="{{ route('scan') }}">Scan Center</a></li>
                                        @else
                                            <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                                        @endif
                                        <li><a href="{{ route('profile.edit') }}">Profile</a></li>
                                        @if(auth()->user()->role === 'user')
                                            <li><a href="{{ route('user.tickets.index') }}">My Tickets</a></li>
                                        @endif
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="w-full text-left">Logout</button>
                                            </form>
                                        </li>
                                    </ul>
                                </details>
                            </li>
                        @else
                            <li><a href="{{ route('login') }}" class="btn btn-sm btn-ghost">Login</a></li>
                            <li><a href="{{ route('register') }}" class="btn btn-sm btn-primary">Sign up</a></li>
                        @endauth
                    </ul>
                </div>
            </div>

            <!-- Page Content -->
            <main class="flex-grow container mx-auto px-4 py-8 max-w-7xl">
                @if(session('success'))
                    <div class="alert alert-success shadow-lg mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-error shadow-lg mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>

            <footer class="footer items-center p-6 bg-slate-900 text-slate-400 mt-auto border-t border-white/5">
                <div class="items-center grid-flow-col">
                    <p>&copy; {{ date('Y') }} {{ config('app.name', 'TicketScan') }}. All rights reserved.</p>
                </div>
                <div class="grid-flow-col gap-4 md:place-self-center md:justify-self-end">
                    <!-- Social icons can go here -->
                </div>
            </footer>
        </div>
        <div class="drawer-side z-50">
            <label for="my-drawer-3" aria-label="close sidebar" class="drawer-overlay"></label>
            <ul class="menu p-4 w-80 min-h-full bg-slate-900 text-slate-100">
                <!-- Sidebar content here -->
                <li><a href="{{ route('events.index') }}"
                        class="{{ request()->routeIs('events.*') ? 'active' : '' }}">Browse Events</a></li>
                @auth
                    <li class="menu-title mt-4">Account</li>
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'staff')
                        <li><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                    @elseif(auth()->user()->role === 'volunteer')
                        <li><a href="{{ route('scan') }}">Scan Center</a></li>
                    @else
                        <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                    @endif
                    <li><a href="{{ route('profile.edit') }}">Profile</a></li>
                    @if(auth()->user()->role === 'user')
                        <li><a href="{{ route('user.tickets.index') }}">My Tickets</a></li>
                    @endif
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="menu-title mt-4">Account</li>
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Create Account</a></li>
                @endauth
            </ul>
        </div>
    </div>
</body>

</html>