@extends('layouts.admin')

@section('content')
<div class="space-y-8 animate-in fade-in duration-700">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 sm:gap-6">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">System <span class="gradient-text">Users</span></h2>
            <p class="text-slate-400 mt-1 font-light text-sm">Manage administrative access and roles for the ticketing system.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="group relative inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-3 px-6 rounded-2xl transition-all duration-300 transform hover:scale-[1.02] active:scale-95 shadow-lg shadow-indigo-600/20">
            <svg class="h-5 w-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            <span>Register New User</span>
        </a>
    </div>

    @if(session('success'))
    <div class="glass-card bg-emerald-500/10 border-emerald-500/20 p-4 rounded-2xl flex items-center gap-3 text-emerald-500 animate-in slide-in-from-top-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        <p class="text-sm font-medium">{{ session('success') }}</p>
    </div>
    @endif

    @if(session('error'))
    <div class="glass-card bg-rose-500/10 border-rose-500/20 p-4 rounded-2xl flex items-center gap-3 text-rose-500 animate-in slide-in-from-top-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm8.707-7.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293z" clip-rule="evenodd" />
        </svg>
        <p class="text-sm font-medium">{{ session('error') }}</p>
    </div>
    @endif

    <div class="glass-card rounded-3xl overflow-hidden border-black/5 dark:border-white/10 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-black/5 dark:border-white/5 bg-black/5 dark:bg-white/5">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Name & Email</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest text-center">Role</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Joined Date</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5 dark:divide-white/5">
                    @forelse($users as $user)
                    <tr class="hover:bg-black/5 dark:hover:bg-white/5 transition-colors duration-200 group">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-500 font-bold border border-indigo-500/20">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-slate-900 dark:text-slate-200 font-medium">{{ $user->name }}</span>
                                    <span class="text-xs text-slate-500">{{ $user->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            @php
                                $roleClasses = match($user->role) {
                                    'admin' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
                                    'staff' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                    'volunteer' => 'bg-amber-500/10 text-amber-500 border-amber-500/20',
                                    default => 'bg-slate-500/10 text-slate-400 border-slate-500/20',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider border {{ $roleClasses }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <span class="text-slate-500 text-sm">{{ $user->created_at->format('M d, Y') }}</span>
                        </td>
                        <td class="px-6 py-5 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-slate-400 hover:text-indigo-400 hover:bg-indigo-400/10 rounded-xl transition-all duration-200" title="Edit User">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-400 hover:bg-rose-400/10 rounded-xl transition-all duration-200" title="Delete User">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-black/5 dark:bg-white/5 rounded-2xl flex items-center justify-center text-slate-500 mb-4 glass">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-slate-900 dark:text-slate-300">No users found</h3>
                                <p class="text-slate-500 mt-1">Register your first system user to get started.</p>
                                <a href="{{ route('admin.users.create') }}" class="mt-4 text-indigo-400 hover:text-indigo-300 font-medium">Register User &rarr;</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($users->hasPages())
    <div class="mt-6 flex justify-center">
        <div class="glass px-4 py-2 rounded-2xl border-white/5">
            {{ $users->links() }}
        </div>
    </div>
    @endif
</div>
@endsection
