@extends('layouts.admin')

@section('content')
    <div class="space-y-8 animate-in fade-in duration-700">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 sm:gap-6">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">System <span
                        class="bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">Users</span></h2>
                <p class="text-base-content/60 mt-1 font-light text-sm">Manage administrative access and roles for the
                    ticketing system.</p>
            </div>
            <a href="{{ route('admin.users.create') }}"
                class="btn btn-primary shadow-lg shadow-primary/20 gap-2 rounded-xl">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                <span>Register New User</span>
            </a>
        </div>

        @if(session('success'))
            <div role="alert" class="alert alert-success animate-in slide-in-from-top-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div role="alert" class="alert alert-error animate-in slide-in-from-top-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="card bg-base-100 shadow-sm border border-base-300 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <!-- head -->
                    <thead class="bg-base-200">
                        <tr>
                            <th class="px-6 py-4 uppercase tracking-widest text-xs font-semibold text-base-content/60">Name
                                & Email</th>
                            <th
                                class="px-6 py-4 uppercase tracking-widest text-xs font-semibold text-base-content/60 text-center">
                                Role</th>
                            <th class="px-6 py-4 uppercase tracking-widest text-xs font-semibold text-base-content/60">
                                Joined Date</th>
                            <th
                                class="px-6 py-4 uppercase tracking-widest text-xs font-semibold text-base-content/60 text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="hover">
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="avatar placeholder">
                                            <div
                                                class="bg-primary/10 text-primary rounded-xl w-10 h-10 border border-primary/20">
                                                <span class="font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                            </div>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-medium text-base-content">{{ $user->name }}</span>
                                            <span class="text-xs text-base-content/60">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @php
                                        $roleClass = match ($user->role) {
                                            'admin' => 'badge-primary',
                                            'staff' => 'badge-success',
                                            'volunteer' => 'badge-warning',
                                            default => 'badge-ghost',
                                        };
                                    @endphp
                                    <div class="badge {{ $roleClass }} badge-outline font-bold uppercase text-[10px] p-3">
                                        {{ $user->role }}
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="text-base-content/60 text-sm">{{ $user->created_at->format('M d, Y') }}</span>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                            class="btn btn-ghost btn-square btn-sm text-base-content/60 hover:text-primary"
                                            title="Edit User">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                class="inline-block"
                                                onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-ghost btn-square btn-sm text-base-content/60 hover:text-error"
                                                    title="Delete User">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
                                        <div
                                            class="w-16 h-16 bg-base-200 rounded-2xl flex items-center justify-center text-base-content/40 mb-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-medium text-base-content">No users found</h3>
                                        <p class="text-base-content/60 mt-1">Register your first system user to get started.</p>
                                        <a href="{{ route('admin.users.create') }}"
                                            class="btn btn-link link-primary no-underline mt-4">Register User &rarr;</a>
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
                <div class="bg-base-100 shadow-sm border border-base-200 px-4 py-2 rounded-2xl">
                    {{ $users->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection