@extends('layouts.admin')

@section('content')
    <div class="space-y-8 animate-in fade-in duration-700">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 sm:gap-6">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">Admin <span class="gradient-text">Dashboard</span>
                </h2>
                <p class="text-slate-400 mt-1 font-light text-sm">Comprehensive overview of ticket sales and guest activity.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <div class="glass-card px-4 sm:px-6 py-3 rounded-2xl border-indigo-500/20 flex flex-col items-center">
                    <span
                        class="text-[10px] sm:text-xs text-indigo-500  uppercase tracking-widest font-bold">Total
                        Sales</span>
                    <span class="text-lg sm:text-xl font-bold text-indigo-600 ">Rp
                        {{ number_format($totalSales, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Quick Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Tickets -->
            <div
                class="glass-card p-6 rounded-3xl border-black/5  group hover:border-indigo-500/30 transition-all duration-500">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-indigo-500/10 rounded-2xl flex items-center justify-center text-indigo-600  group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                    <span class="text-indigo-500/30 ">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                </div>
                <h4 class="text-slate-500  text-sm font-medium uppercase tracking-wider">Total Tickets
                </h4>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="text-3xl font-bold text-slate-900 ">{{ $totalTickets }}</span>
                    <span class="text-xs text-slate-500">Issued</span>
                </div>
            </div>

            <!-- Validated Tickets -->
            <div
                class="glass-card p-6 rounded-3xl border-black/5  group hover:border-emerald-500/30 transition-all duration-500">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-600  group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span
                        class="bg-emerald-500/10 text-emerald-600  px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider">Scanned</span>
                </div>
                <h4 class="text-slate-500  text-sm font-medium uppercase tracking-wider">Validated</h4>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="text-3xl font-bold text-slate-900 ">{{ $validatedTickets }}</span>
                    <span
                        class="text-xs text-slate-500">({{ $totalTickets > 0 ? round(($validatedTickets / $totalTickets) * 100) : 0 }}%)</span>
                </div>
            </div>

            <!-- Unvalidated Tickets -->
            <div
                class="glass-card p-6 rounded-3xl border-black/5  group hover:border-amber-500/30 transition-all duration-500">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-amber-500/10 rounded-2xl flex items-center justify-center text-amber-600  group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span
                        class="bg-amber-500/10 text-amber-600  px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider">Pending</span>
                </div>
                <h4 class="text-slate-500  text-sm font-medium uppercase tracking-wider">Unvalidated</h4>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="text-3xl font-bold text-slate-900 ">{{ $unvalidatedTickets }}</span>
                    <span class="text-xs text-slate-500">Remaining</span>
                </div>
            </div>

            <!-- Revenue -->
            <div
                class="glass-card p-6 rounded-3xl border-black/5  group hover:border-violet-500/30 transition-all duration-500">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-violet-500/10 rounded-2xl flex items-center justify-center text-violet-600  group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-violet-500/30 ">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </span>
                </div>
                <h4 class="text-slate-500  text-sm font-medium uppercase tracking-wider">Revenue</h4>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="text-2xl font-bold text-slate-900  leading-tight">Rp
                        {{ number_format($totalSales, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Category Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-6">
            <!-- VVIP -->
            <div
                class="glass p-5 rounded-3xl border-black/5  hover:bg-black/5  transition-all">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-8 h-8 rounded-xl bg-rose-500/20 flex items-center justify-center text-rose-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-widest">VVIP</span>
                </div>
                <p class="text-2xl font-bold text-slate-900 ">{{ $vvipTickets }}</p>
            </div>

            <!-- VIP -->
            <div
                class="glass p-5 rounded-3xl border-black/5  hover:bg-black/5  transition-all">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-8 h-8 rounded-xl bg-amber-500/20 flex items-center justify-center text-amber-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-widest">VIP</span>
                </div>
                <p class="text-2xl font-bold text-slate-900 ">{{ $vipTickets }}</p>
            </div>

            <!-- Festival -->
            <div
                class="glass p-5 rounded-3xl border-black/5  hover:bg-black/5  transition-all">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-8 h-8 rounded-xl bg-sky-500/20 flex items-center justify-center text-sky-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3.005 3.005 0 013.75-2.906z" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-widest">Festival</span>
                </div>
                <p class="text-2xl font-bold text-slate-900 ">{{ $festivalTickets }}</p>
            </div>

            <!-- General Admission -->
            <div
                class="glass p-5 rounded-3xl border-black/5  hover:bg-black/5  transition-all">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500/20 flex items-center justify-center text-emerald-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                            <path fill-rule="evenodd"
                                d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-widest text-[10px]">Gen.
                        Admission</span>
                </div>
                <p class="text-2xl font-bold text-slate-900 ">{{ $gaTickets }}</p>
            </div>
        </div>

        <!-- Ticket Data Table & Activity Feed -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
            <!-- Recent Activity -->
            <div
                class="lg:col-span-1 glass-card rounded-3xl overflow-hidden border-black/5  shadow-sm flex flex-col h-full">
                <div class="p-6 border-b border-black/5  flex items-center justify-between shrink-0">
                    <h3 class="text-lg font-semibold text-slate-900 ">Recent Activity</h3>
                    <a href="{{ route('admin.history.index') }}"
                        class="text-sm text-indigo-600  hover:text-indigo-500  font-medium transition-colors">View
                        All &rarr;</a>
                </div>
                <div class="overflow-y-auto flex-1">
                    <ul role="list" class="divide-y divide-black/5 ">
                        @forelse($recentActivities as $activity)
                            <li class="p-4 hover:bg-black/5  transition-colors duration-200">
                                <div class="flex space-x-3">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="h-8 w-8 rounded-full bg-slate-100  flex items-center justify-center ring-2 ring-white ">
                                            <span
                                                class="text-xs font-medium leading-none text-slate-500">{{ substr($activity->user ? $activity->user->name : 'S', 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div class="flex-1 space-y-1">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-sm font-medium text-slate-900 ">
                                                {{ $activity->user ? $activity->user->name : 'System' }}
                                            </h3>
                                            <p class="text-xs text-slate-500">{{ $activity->created_at->diffForHumans() }}</p>
                                        </div>
                                        <p class="text-sm text-slate-500  line-clamp-2"><span
                                                class="font-semibold text-indigo-500">{{ $activity->action }}</span>
                                            {{ $activity->description }}</p>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="p-4 text-center text-slate-500 text-sm">No recent activity.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Ticket Data Table -->
            <div class="lg:col-span-2 glass-card rounded-3xl overflow-hidden border-black/5 shadow-sm flex flex-col">
                <div class="p-6 border-b border-black/5 flex items-center justify-between shrink-0">
                    <h3 class="text-lg font-semibold text-slate-900">Recent Tickets</h3>
                    <a href="{{ route('admin.tickets.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500 font-medium transition-colors">Manage All &rarr;</a>
                </div>

                <!-- Filters -->
                <div class="p-4 bg-slate-50/50 border-b border-black/5">
                    <form action="{{ route('admin.dashboard') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        
                        <!-- Search -->
                        <div class="relative col-span-1 sm:col-span-2">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <span class="material-symbols-outlined text-[18px]">search</span>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search guest, email, UUID..." 
                                class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none bg-white">
                        </div>

                        <!-- Status -->
                        <select name="status" class="py-2 px-3 rounded-xl border border-slate-200 text-sm focus:border-indigo-500 outline-none bg-white cursor-pointer" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="scanned" {{ request('status') == 'scanned' ? 'selected' : '' }}>Scanned</option>
                            <option value="unscanned" {{ request('status') == 'unscanned' ? 'selected' : '' }}>Unscanned</option>
                        </select>

                        <!-- Type -->
                        <select name="type" class="py-2 px-3 rounded-xl border border-slate-200 text-sm focus:border-indigo-500 outline-none bg-white cursor-pointer" onchange="this.form.submit()">
                            <option value="">All Types</option>
                            <option value="VVIP" {{ request('type') == 'VVIP' ? 'selected' : '' }}>VVIP</option>
                            <option value="VIP" {{ request('type') == 'VIP' ? 'selected' : '' }}>VIP</option>
                            <option value="Festival" {{ request('type') == 'Festival' ? 'selected' : '' }}>Festival</option>
                            <option value="General Admission" {{ request('type') == 'General Admission' ? 'selected' : '' }}>General Admission</option>
                        </select>

                        <!-- Date Range (Optional expansion) -->
                        <div class="col-span-1 sm:col-span-2 flex gap-2">
                            <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full py-2 px-3 rounded-xl border border-slate-200 text-sm focus:border-indigo-500 outline-none bg-white">
                            <span class="flex items-center text-slate-400">-</span>
                            <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full py-2 px-3 rounded-xl border border-slate-200 text-sm focus:border-indigo-500 outline-none bg-white">
                        </div>

                        <div class="col-span-1 sm:col-span-2 flex justify-end gap-2">
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-sm text-slate-500 hover:text-slate-700 font-medium">Clear</a>
                            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-black/5  bg-black/5 ">
                                <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Ticket
                                    ID</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Guest
                                    Info</th>
                                <th
                                    class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest text-center">
                                    Seat</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Type
                                </th>
                                <th
                                    class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest text-center">
                                    Status</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Price
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-black/5 ">
                            @forelse($tickets as $ticket)
                                <tr class="hover:bg-black/5  transition-colors duration-200 group">
                                    <td class="px-6 py-5">
                                        <div class="flex flex-col">
                                            <span
                                                class="text-indigo-400 font-mono text-sm font-semibold tracking-wider">#{{ strtoupper(substr($ticket->uuid, 0, 8)) }}</span>
                                            <span
                                                class="text-xs text-slate-500 mt-0.5">{{ $ticket->created_at->format('M d, H:i') }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex flex-col">
                                            <span
                                                class="text-slate-900  font-medium">{{ $ticket->user_name }}</span>
                                            <span class="text-xs text-slate-500">{{ $ticket->user_email }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <span
                                            class="inline-flex items-center justify-center px-3 py-1 rounded-lg bg-slate-100  text-slate-600  font-bold text-xs border border-black/5 ">
                                            {{ $ticket->seat_number }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        @php
                                            $typeClasses = match ($ticket->type) {
                                                'VVIP' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                                'VIP' => 'bg-amber-500/10 text-amber-500 border-amber-500/20',
                                                'Festival' => 'bg-sky-500/10 text-sky-400 border-sky-500/20',
                                                'General Admission' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                                default => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
                                            };
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border {{ $typeClasses }}">
                                            {{ $ticket->type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        @if($ticket->scanned_at)
                                            <span
                                                class="inline-flex items-center gap-1 text-emerald-400 text-xs font-bold uppercase tracking-wider">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                                Validated
                                            </span>
                                        @else
                                            <span class="text-slate-500 text-xs font-bold uppercase tracking-wider">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="text-slate-700  font-medium">Rp
                                            {{ number_format($ticket->price, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <div
                                                class="w-16 h-16 bg-black/5  rounded-2xl flex items-center justify-center text-slate-500 mb-4 glass">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-medium text-slate-900 ">No tickets found
                                            </h3>
                                            <p class="text-slate-500 mt-1">Ticket data will appear here once generated.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($tickets->hasPages())
                    <div class="p-6 border-t border-black/5  flex justify-center">
                        <div class="glass px-4 py-2 rounded-2xl border-white/5">
                            {{ $tickets->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
@endsection