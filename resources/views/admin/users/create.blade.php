@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto animate-in fade-in slide-in-from-bottom-4 duration-700">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold tracking-tight">Register <span
                        class="bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">New User</span>
                </h2>
                <p class="text-base-content/60 mt-1 font-light text-sm">Create a new user account with specific access
                    roles.</p>
            </div>
            <a href="{{ route('admin.users.index') }}"
                class="btn btn-ghost btn-sm gap-2 text-base-content/60 hover:text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to User List
            </a>
        </div>

        <div class="card bg-base-100 shadow-sm border border-base-300 overflow-hidden">
            <form action="{{ route('admin.users.store') }}" method="POST" class="card-body p-8 md:p-12 space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Name -->
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-semibold">Full Name</span>
                        </label>
                        <label class="input input-bordered flex items-center gap-3 w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-50" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                                class="grow" placeholder="e.g. Jane Smith" />
                        </label>
                        @error('name') <p class="mt-1 text-xs text-error">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-semibold">Email Address</span>
                        </label>
                        <label class="input input-bordered flex items-center gap-3 w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-50" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required class="grow"
                                placeholder="jane@example.com" />
                        </label>
                        @error('email') <p class="mt-1 text-xs text-error">{{ $message }}</p> @enderror
                    </div>

                    <!-- Role -->
                    <div class="form-control w-full md:col-span-2">
                        <label class="label">
                            <span class="label-text font-semibold">Role Assignment</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none opacity-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <select name="role" id="role" required class="select select-bordered w-full pl-10">
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Full Access)
                                </option>
                                <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff (Everything except
                                    creating users)</option>
                                <option value="volunteer" {{ old('role') == 'volunteer' ? 'selected' : '' }}>Volunteer (Scan
                                    Only)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-semibold">Password</span>
                        </label>
                        <label class="input input-bordered flex items-center gap-3 w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-50" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <input type="password" name="password" id="password" required class="grow"
                                placeholder="••••••••" />
                        </label>
                        @error('password') <p class="mt-1 text-xs text-error">{{ $message }}</p> @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-semibold">Confirm Password</span>
                        </label>
                        <label class="input input-bordered flex items-center gap-3 w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-50" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                class="grow" placeholder="••••••••" />
                        </label>
                    </div>
                </div>

                <div class="pt-8 flex items-center justify-end gap-4">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary gap-2 shadow-lg shadow-primary/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        <span>Create User</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection