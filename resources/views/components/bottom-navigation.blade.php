<nav class="fixed bottom-0 left-0 right-0 glass-card border-t border-slate-100 px-5 py-1 z-50 rounded-t-[2rem]">
    <div class="flex justify-between items-center max-w-md mx-auto relative">
        <a href="{{ route('user.dashboard') }}"
            class="flex flex-col items-center {{ request()->routeIs('user.dashboard') ? 'text-primary-ref' : 'text-slate-600 hover:text-slate-900' }} w-16 transition-colors">
            <span
                class="material-symbols-outlined {{ request()->routeIs('user.dashboard') ? 'fill-current' : '' }}">dashboard</span>
            <span
                class="text-[10px] {{ request()->routeIs('user.dashboard') ? 'font-bold' : 'font-medium' }} mt-1">Dashboard</span>
        </a>
        <a href="{{ route('favorites.index') }}"
            class="flex flex-col items-center {{ request()->routeIs('favorites.index') ? 'text-primary-ref' : 'text-slate-600 hover:text-slate-900' }} w-16 transition-colors">
            <span
                class="material-symbols-outlined {{ request()->routeIs('favorites.index') ? 'fill-current' : '' }}">favorite</span>
            <span
                class="text-[10px] {{ request()->routeIs('favorites.index') ? 'font-bold' : 'font-medium' }} mt-1">Wishlist</span>
        </a>
        <div class="relative -top-8">
            <a href="{{ route('events.index') }}"
                class="w-16 h-16 bg-primary-ref text-white rounded-full shadow-xl shadow-red-500/30 flex items-center justify-center ring-4 ring-white hover:bg-red-700 transition-colors transform active:scale-95">
                <span class="material-symbols-outlined text-3xl">explore</span>
            </a>
        </div>
        <a href="{{ route('user.tickets.index') }}"
            class="flex flex-col items-center {{ request()->routeIs('user.tickets.*') ? 'text-primary-ref' : 'text-slate-600 hover:text-slate-900' }} w-16 transition-colors">
            <span
                class="material-symbols-outlined {{ request()->routeIs('user.tickets.*') ? 'fill-current' : '' }}">local_activity</span>
            <span class="text-[10px] {{ request()->routeIs('user.tickets.*') ? 'font-bold' : 'font-medium' }} mt-1">My
                Tickets</span>
        </a>
        <a href="{{ route('profile.edit') }}"
            class="flex flex-col items-center {{ request()->routeIs('profile.edit') ? 'text-primary-ref' : 'text-slate-600 hover:text-slate-900' }} w-16 transition-colors">
            <span
                class="material-symbols-outlined {{ request()->routeIs('profile.edit') ? 'fill-current' : '' }}">person</span>
            <span
                class="text-[10px] {{ request()->routeIs('profile.edit') ? 'font-bold' : 'font-medium' }} mt-1">Profile</span>
        </a>
    </div>
    <div class="w-32 h-1 bg-slate-300 rounded-full mx-auto mt-2"></div>
</nav>