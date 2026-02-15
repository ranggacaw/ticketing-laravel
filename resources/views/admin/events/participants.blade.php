@extends('layouts.admin')

@section('content')
<div class="space-y-6 animate-in fade-in duration-700">
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.events.show', $event) }}" class="text-slate-400 hover:text-slate-600 transition-colors flex items-center gap-1 text-sm font-medium">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                    Back to Event
                </a>
            </div>
            <h2 class="text-2xl font-bold tracking-tight">Participants List</h2>
            <p class="text-slate-500 text-sm mt-1">Event: <span class="font-semibold text-slate-700">{{ $event->name }}</span></p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-lg uppercase tracking-wider">
                {{ $participants->total() }} Attendees
            </span>
        </div>
    </div>

    <div class="glass-card rounded-3xl overflow-hidden border-black/5 shadow-sm flex flex-col">
        <!-- Filters -->
        <div class="p-4 bg-slate-50/50 border-b border-black/5">
            <form action="{{ route('admin.events.participants', $event) }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="relative col-span-1 sm:col-span-2">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <span class="material-symbols-outlined text-[18px]">search</span>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, email, ticket ID..." 
                        class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none bg-white">
                </div>

                <select name="status" class="py-2 px-3 rounded-xl border border-slate-200 text-sm focus:border-indigo-500 outline-none bg-white cursor-pointer" onchange="this.form.submit()">
                    <option value="">All Status</option>
                    <option value="scanned" {{ request('status') == 'scanned' ? 'selected' : '' }}>Scanned (Checked In)</option>
                    <option value="unscanned" {{ request('status') == 'unscanned' ? 'selected' : '' }}>Pending Check In</option>
                </select>

                <select name="type" class="py-2 px-3 rounded-xl border border-slate-200 text-sm focus:border-indigo-500 outline-none bg-white cursor-pointer" onchange="this.form.submit()">
                    <option value="">All Ticket Types</option>
                    @foreach($event->ticketTypes as $type)
                        <option value="{{ $type->name }}" {{ request('type') == $type->name ? 'selected' : '' }}>{{ $type->name }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-black/5 bg-slate-50/50">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest w-16">#</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Guest</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Ticket Type</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest text-center">Check-in Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Purchase Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5">
                    @forelse($participants as $ticket)
                        <tr class="hover:bg-slate-50/50 transition-colors duration-200 group">
                            <td class="px-6 py-4 text-xs text-slate-400 font-mono">
                                {{ substr($ticket->uuid, 0, 8) }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-900">{{ $ticket->user_name }}</span>
                                    <span class="text-xs text-slate-500">{{ $ticket->user_email }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                    {{ $ticket->type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($ticket->scanned_at)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-bold border border-emerald-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Checked In
                                    </span>
                                    <div class="text-[10px] text-slate-400 mt-1">{{ $ticket->scanned_at->format('H:i') }}</div>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-slate-50 text-slate-500 text-xs font-medium border border-slate-100">
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">
                                {{ $ticket->created_at->format('M d, Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">person_off</span>
                                <p>No participants found matching your filters.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($participants->hasPages())
            <div class="p-4 border-t border-black/5 flex justify-center">
                {{ $participants->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
