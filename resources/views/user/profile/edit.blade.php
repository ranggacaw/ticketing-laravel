@extends('user.layouts.app')

@section('content')
    <div class="min-h-screen -mx-4 md:-mx-8 font-display px-6">
        <!-- Header -->
        <x-page-header title="Profile Settings" subtitle="Update your personal information and security settings">
            <x-slot:action>
                <div class="p-2 bg-slate-50 rounded-full border border-slate-100 hidden sm:block">
                    <span class="material-symbols-outlined text-slate-400">settings</span>
                </div>
            </x-slot:action>
        </x-page-header>

        <div class="py-4 md:p-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8 max-w-6xl mx-auto">
                <!-- Personal Information -->
                <div class="bg-white rounded-3xl p-6 md:p-8 border border-slate-100 shadow-xl shadow-slate-200/40">
                    <div class="flex items-center space-x-3 mb-6 md:mb-8">
                        <div class="w-10 h-10 rounded-2xl bg-primary-ref/10 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-primary-ref">person_edit</span>
                        </div>
                        <h3 class="text-xl font-black text-slate-900">Personal Information</h3>
                    </div>

                    @if (session('status') === 'profile-updated')
                        <div
                            class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-2xl text-sm flex items-center space-x-3 animate-in fade-in slide-in-from-top-2 duration-300">
                            <span class="material-symbols-outlined text-lg">check_circle</span>
                            <span class="font-bold">Profile updated successfully.</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label
                                class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em] mb-3 ml-1">Profile
                                Picture</label>
                            <div
                                class="flex flex-col sm:flex-row items-center sm:items-start space-y-4 sm:space-y-0 sm:space-x-6 bg-slate-50 p-4 md:p-6 rounded-3xl border border-dashed border-slate-200 group transition-all hover:border-primary-ref/30">
                                <div class="relative shrink-0">
                                    @if ($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar"
                                            class="w-20 h-20 md:w-24 md:h-24 rounded-full object-cover border-4 border-white shadow-md ring-1 ring-slate-100">
                                    @else
                                        <div
                                            class="w-20 h-20 md:w-24 md:h-24 rounded-full bg-primary-ref/10 flex items-center justify-center text-primary-ref border-4 border-white shadow-md ring-1 ring-slate-100">
                                            <span
                                                class="text-2xl md:text-3xl font-black">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                        </div>
                                    @endif
                                    <div
                                        class="absolute -bottom-1 -right-1 bg-white p-1.5 rounded-full shadow-sm border border-slate-100">
                                        <span
                                            class="material-symbols-outlined text-base text-primary-ref">photo_camera</span>
                                    </div>
                                </div>
                                <div class="flex-1 w-full">
                                    <input type="file" name="avatar" accept="image/*"
                                        class="block w-full text-xs font-medium text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-primary-ref/10 file:text-primary-ref hover:file:bg-primary-ref/20 transition-all cursor-pointer">
                                    <p class="mt-2 text-[10px] text-slate-400 font-medium">JPG, PNG or GIF. Max 2MB.</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label for="name"
                                    class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em] mb-2 ml-1">Full
                                    Name</label>
                                <div class="relative group">
                                    <span
                                        class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary-ref transition-colors">person</span>
                                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                                        class="w-full pl-12 pr-4 py-3.5 md:py-4 rounded-2xl bg-slate-50 border border-slate-200 text-slate-900 font-bold placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-ref/5 focus:border-primary-ref transition-all">
                                </div>
                                @error('name')
                                    <p class="mt-2 text-xs text-red-500 font-bold flex items-center space-x-1">
                                        <span class="material-symbols-outlined text-sm">error</span>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="email"
                                    class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em] mb-2 ml-1">Email
                                    Address</label>
                                <div class="relative group">
                                    <span
                                        class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary-ref transition-colors">alternate_email</span>
                                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}"
                                        required
                                        class="w-full pl-12 pr-4 py-3.5 md:py-4 rounded-2xl bg-slate-50 border border-slate-200 text-slate-900 font-bold placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-ref/5 focus:border-primary-ref transition-all">
                                </div>
                                @error('email')
                                    <p class="mt-2 text-xs text-red-500 font-bold flex items-center space-x-1">
                                        <span class="material-symbols-outlined text-sm">error</span>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone"
                                    class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em] mb-2 ml-1">Phone
                                    Number</label>
                                <div class="relative group">
                                    <span
                                        class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary-ref transition-colors">call</span>
                                    <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                        class="w-full pl-12 pr-4 py-3.5 md:py-4 rounded-2xl bg-slate-50 border border-slate-200 text-slate-900 font-bold placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-ref/5 focus:border-primary-ref transition-all"
                                        placeholder="+62 812 3456 7890">
                                </div>
                                @error('phone')
                                    <p class="mt-2 text-xs text-red-500 font-bold flex items-center space-x-1">
                                        <span class="material-symbols-outlined text-sm">error</span>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <div class="pt-2">
                            <button type="submit"
                                class="w-full py-4 bg-primary-ref text-white font-bold rounded-2xl hover:bg-red-700 transition-all flex items-center justify-center space-x-2 shadow-lg shadow-red-100 active:scale-[0.98]">
                                <span>Save Changes</span>
                                <span class="material-symbols-outlined text-sm">save</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Update Password -->
                <div class="bg-white rounded-3xl p-6 md:p-8 border border-slate-100 shadow-xl shadow-slate-200/40 h-fit">
                    <div class="flex items-center space-x-3 mb-6 md:mb-8">
                        <div class="w-10 h-10 rounded-2xl bg-amber-500/10 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-amber-600">lock_reset</span>
                        </div>
                        <h3 class="text-xl font-black text-slate-900">Security</h3>
                    </div>

                    @if (session('status') === 'password-updated')
                        <div
                            class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-2xl text-sm flex items-center space-x-3 animate-in fade-in slide-in-from-top-2 duration-300">
                            <span class="material-symbols-outlined text-lg">enhanced_encryption</span>
                            <span class="font-bold">Password changed successfully.</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.password') }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4">
                            <div>
                                <label for="current_password"
                                    class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em] mb-2 ml-1">Current</label>
                                <div class="relative group">
                                    <span
                                        class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-amber-600 transition-colors">lock_open</span>
                                    <input id="current_password" type="password" name="current_password" required
                                        class="w-full pl-12 pr-4 py-3.5 md:py-4 rounded-2xl bg-slate-50 border border-slate-200 text-slate-900 font-bold placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-amber-500/5 focus:border-amber-500 transition-all">
                                </div>
                                @error('current_password')
                                    <p class="mt-2 text-xs text-red-500 font-bold flex items-center space-x-1">
                                        <span class="material-symbols-outlined text-sm">error</span>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="password"
                                    class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em] mb-2 ml-1">New
                                    Password</label>
                                <div class="relative group">
                                    <span
                                        class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-amber-600 transition-colors">new_releases</span>
                                    <input id="password" type="password" name="password" required
                                        class="w-full pl-12 pr-4 py-3.5 md:py-4 rounded-2xl bg-slate-50 border border-slate-200 text-slate-900 font-bold placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-amber-500/5 focus:border-amber-500 transition-all">
                                </div>
                                @error('password')
                                    <p class="mt-2 text-xs text-red-500 font-bold flex items-center space-x-1">
                                        <span class="material-symbols-outlined text-sm">error</span>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation"
                                    class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em] mb-2 ml-1">Confirm</label>
                                <div class="relative group">
                                    <span
                                        class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-amber-600 transition-colors">verified_user</span>
                                    <input id="password_confirmation" type="password" name="password_confirmation" required
                                        class="w-full pl-12 pr-4 py-3.5 md:py-4 rounded-2xl bg-slate-50 border border-slate-200 text-slate-900 font-bold placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-amber-500/5 focus:border-amber-500 transition-all">
                                </div>
                            </div>
                        </div>

                        <div class="pt-2">
                            <button type="submit"
                                class="w-full py-4 bg-slate-900 text-white font-bold rounded-2xl hover:bg-black transition-all flex items-center justify-center space-x-2 shadow-lg shadow-slate-100 active:scale-[0.98]">
                                <span>Update Password</span>
                                <span class="material-symbols-outlined text-sm">key</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Account Actions -->
                <div
                    class="lg:col-span-2 bg-rose-50 rounded-3xl p-6 md:p-8 border border-rose-100 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex items-center space-x-4 w-full md:w-auto">
                        <div
                            class="w-12 h-12 rounded-2xl bg-rose-500/10 flex items-center justify-center text-rose-600 shrink-0">
                            <span class="material-symbols-outlined text-2xl"
                                style="font-variation-settings: 'FILL' 1">logout</span>
                        </div>
                        <div>
                            <h4 class="text-lg font-black text-rose-900">Sign Out</h4>
                            <p class="text-sm text-rose-600/70 font-medium">Log out of your account on this device.</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="w-full md:w-auto">
                        @csrf
                        <button type="submit"
                            class="w-full px-12 py-4 bg-rose-600 text-white font-bold rounded-2xl hover:bg-rose-700 transition-all shadow-lg shadow-rose-200/50 flex items-center justify-center space-x-2 active:scale-[0.98]">
                            <span>Logout Now</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection