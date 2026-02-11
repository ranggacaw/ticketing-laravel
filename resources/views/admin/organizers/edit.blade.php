@extends('layouts.admin')

@section('content')
    <div class="space-y-8 animate-in fade-in duration-700 max-w-4xl mx-auto">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.organizers.index') }}"
                    class="group inline-flex items-center text-sm text-slate-500 hover:text-indigo-400 mb-2 transition-colors">
                    <svg class="w-4 h-4 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Organizers
                </a>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">Edit <span class="gradient-text">Organizer</span>
                </h2>
                <p class="text-slate-400 mt-1 font-light text-sm">Update organizer profile details.</p>
            </div>
        </div>

        <div class="glass-card p-6 sm:p-8 rounded-3xl border-black/5 dark:border-white/10 shadow-sm">
            <form action="{{ route('admin.organizers.update', $organizer) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="col-span-2">
                        <label for="name"
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Organizer Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $organizer->name) }}"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            placeholder="e.g. Acme Events" required>
                        @error('name')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2">
                        <label for="description"
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Description</label>
                        <textarea name="description" id="description" rows="3"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            placeholder="About the organizer...">{{ old('description', $organizer->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Email
                            Contact</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $organizer->email) }}"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            placeholder="contact@example.com" required>
                        @error('email')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Phone
                            Number</label>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone', $organizer->phone) }}"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            placeholder="+1 (555) 000-0000">
                        @error('phone')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2">
                        <label for="website"
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Website URL</label>
                        <input type="url" name="website" id="website" value="{{ old('website', $organizer->website) }}"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            placeholder="https://example.com">
                        @error('website')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end pt-4 gap-4">
                    <a href="{{ route('admin.organizers.index') }}"
                        class="text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 font-medium transition-colors">Cancel</a>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-indigo-600/20 transition-all duration-300 transform hover:scale-[1.02] active:scale-95">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection