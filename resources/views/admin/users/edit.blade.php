@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold tracking-tight">Edit <span class="gradient-text">User</span></h2>
            <p class="text-app-secondary mt-1 font-light text-sm">Update user account information and access roles.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2 text-app-secondary hover:text-indigo-400 transition-colors text-sm font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to User List
        </a>
    </div>

    <div class="glass-card rounded-3xl overflow-hidden">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-8 md:p-12 space-y-10">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Name -->
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-semibold text-app-secondary ml-1">Full Name</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                            class="w-full pl-12 pr-4 py-4 bg-white/5 dark:bg-black/20 border border-black/5 dark:border-white/5 rounded-2xl text-app-primary placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500/40 transition-all @error('name') border-rose-500/50 @enderror"
                            placeholder="e.g. Jane Smith">
                    </div>
                    @error('name') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-semibold text-app-secondary ml-1">Email Address</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                            class="w-full pl-12 pr-4 py-4 bg-white/5 dark:bg-black/20 border border-black/5 dark:border-white/5 rounded-2xl text-app-primary placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500/40 transition-all @error('email') border-rose-500/50 @enderror"
                            placeholder="jane@example.com">
                    </div>
                    @error('email') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                <!-- Role -->
                <div class="space-y-2 md:col-span-2">
                    <label for="role" class="block text-sm font-semibold text-app-secondary ml-1">Role Assignment</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <select name="role" id="role" required
                            class="w-full pl-12 pr-4 py-4 bg-white/5 dark:bg-black/20 border border-black/5 dark:border-white/5 rounded-2xl text-app-primary appearance-none focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500/40 transition-all cursor-pointer">
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }} class="bg-white dark:bg-slate-900">Admin (Full Access)</option>
                            <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }} class="bg-white dark:bg-slate-900">Staff (Everything except creating users)</option>
                            <option value="volunteer" {{ old('role', $user->role) == 'volunteer' ? 'selected' : '' }} class="bg-white dark:bg-slate-900">Volunteer (Scan Only)</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-semibold text-app-secondary ml-1">New Password (Optional)</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="password" id="password"
                            class="w-full pl-12 pr-4 py-4 bg-white/5 dark:bg-black/20 border border-black/5 dark:border-white/5 rounded-2xl text-app-primary placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500/40 transition-all @error('password') border-rose-500/50 @enderror"
                            placeholder="Leave blank to keep current">
                    </div>
                    @error('password') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                <!-- Confirm Password -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-semibold text-app-secondary ml-1">Confirm New Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full pl-12 pr-4 py-4 bg-white/5 dark:bg-black/20 border border-black/5 dark:border-white/5 rounded-2xl text-app-primary placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500/40 transition-all"
                            placeholder="Leave blank to keep current">
                    </div>
                </div>
            </div>

            <div class="pt-8 flex items-center justify-end gap-4">
                <a href="{{ route('admin.users.index') }}" class="px-8 py-4 rounded-2xl border border-black/5 dark:border-white/10 text-app-secondary hover:text-app-primary hover:bg-black/5 dark:hover:bg-white/5 transition-all font-bold cursor-pointer">
                    Cancel
                </a>
                <button type="submit" class="flex-1 md:flex-none group relative flex items-center justify-center gap-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-4 px-10 rounded-2xl transition-all duration-300 shadow-xl shadow-indigo-600/20 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>Update User</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
