@extends('layouts.admin')

@section('content')
    <div class="space-y-8 animate-in fade-in duration-700 max-w-4xl mx-auto">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.events.index') }}"
                    class="group inline-flex items-center text-sm text-slate-500 hover:text-indigo-400 mb-2 transition-colors">
                    <svg class="w-4 h-4 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Events
                </a>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">Edit <span class="gradient-text">Event</span></h2>
                <p class="text-slate-400 mt-1 font-light text-sm">Update event details and schedule.</p>
            </div>
        </div>

        <div class="glass-card p-6 sm:p-8 rounded-3xl border-black/5 dark:border-white/10 shadow-sm">
            <form action="{{ route('admin.events.update', $event) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Basic Info -->
                    <div class="col-span-2">
                        <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Event
                            Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $event->name) }}"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            placeholder="e.g. Summer Music Festival 2026" required>
                        @error('name')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2">
                        <label for="description"
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Description</label>
                        <textarea name="description" id="description" rows="4"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            placeholder="Event details, lineup, etc..."
                            required>{{ old('description', $event->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Schedule -->
                    <div>
                        <label for="start_time"
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Start Time</label>
                        <input type="datetime-local" name="start_time" id="start_time"
                            value="{{ old('start_time', $event->start_time?->format('Y-m-d\TH:i')) }}"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            required>
                        @error('start_time')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_time" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">End
                            Time</label>
                        <input type="datetime-local" name="end_time" id="end_time"
                            value="{{ old('end_time', $event->end_time?->format('Y-m-d\TH:i')) }}"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            required>
                        @error('end_time')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Assignment -->
                    <div>
                        <label for="venue_id"
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Venue</label>
                        <select name="venue_id" id="venue_id"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            required>
                            <option value="">Select Venue</option>
                            @foreach($venues as $venue)
                                <option value="{{ $venue->id }}" {{ old('venue_id', $event->venue_id) == $venue->id ? 'selected' : '' }}>
                                    {{ $venue->name }} ({{ $venue->city }})
                                </option>
                            @endforeach
                        </select>
                        @error('venue_id')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="organizer_id"
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Organizer</label>
                        <select name="organizer_id" id="organizer_id"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            required>
                            <option value="">Select Organizer</option>
                            @foreach($organizers as $organizer)
                                <option value="{{ $organizer->id }}" {{ old('organizer_id', $event->organizer_id) == $organizer->id ? 'selected' : '' }}>
                                    {{ $organizer->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('organizer_id')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Optional & Status -->
                    <div class="col-span-2">
                        <label for="location" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                            Custom Location Text
                            <span class="text-xs text-slate-400 font-normal ml-1">(Optional override for venue
                                location)</span>
                        </label>
                        <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            placeholder="e.g. Main Hall, Stage 2 (Default: City, Country)">
                        @error('location')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">Event
                            Status</label>
                        <div class="flex gap-4">
                            <label
                                class="flex items-center gap-2 cursor-pointer p-3 rounded-xl border border-slate-200 dark:border-slate-800 has-[:checked]:bg-indigo-50 dark:has-[:checked]:bg-indigo-500/10 has-[:checked]:border-indigo-500/50 transition-all">
                                <input type="radio" name="status" value="draft"
                                    class="text-indigo-600 focus:ring-indigo-500" {{ old('status', $event->status) == 'draft' ? 'checked' : '' }}>
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Draft</span>
                            </label>
                            <label
                                class="flex items-center gap-2 cursor-pointer p-3 rounded-xl border border-slate-200 dark:border-slate-800 has-[:checked]:bg-indigo-50 dark:has-[:checked]:bg-indigo-500/10 has-[:checked]:border-indigo-500/50 transition-all">
                                <input type="radio" name="status" value="published"
                                    class="text-indigo-600 focus:ring-indigo-500" {{ old('status', $event->status) == 'published' ? 'checked' : '' }}>
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Published</span>
                            </label>
                            <label
                                class="flex items-center gap-2 cursor-pointer p-3 rounded-xl border border-slate-200 dark:border-slate-800 has-[:checked]:bg-indigo-50 dark:has-[:checked]:bg-indigo-500/10 has-[:checked]:border-indigo-500/50 transition-all">
                                <input type="radio" name="status" value="cancelled"
                                    class="text-indigo-600 focus:ring-indigo-500" {{ old('status', $event->status) == 'cancelled' ? 'checked' : '' }}>
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Cancelled</span>
                            </label>
                            <label
                                class="flex items-center gap-2 cursor-pointer p-3 rounded-xl border border-slate-200 dark:border-slate-800 has-[:checked]:bg-indigo-50 dark:has-[:checked]:bg-indigo-500/10 has-[:checked]:border-indigo-500/50 transition-all">
                                <input type="radio" name="status" value="completed"
                                    class="text-indigo-600 focus:ring-indigo-500" {{ old('status', $event->status) == 'completed' ? 'checked' : '' }}>
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Completed</span>
                            </label>
                        </div>
                        @error('status')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end pt-4 gap-4">
                    <a href="{{ route('admin.events.index') }}"
                        class="text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 font-medium transition-colors">Cancel</a>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-indigo-600/20 transition-all duration-300 transform hover:scale-[1.02] active:scale-95">
                        Update Event
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection