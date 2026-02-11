@extends('layouts.admin')

@section('content')
    <div class="space-y-8 animate-in fade-in duration-700 max-w-4xl mx-auto">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.venues.seats.index', $venue) }}"
                    class="group inline-flex items-center text-sm text-slate-500 hover:text-indigo-400 mb-2 transition-colors">
                    <svg class="w-4 h-4 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Seats
                </a>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">Edit <span class="gradient-text">Seat</span></h2>
                <p class="text-slate-400 mt-1 font-light text-sm">Update seat details.</p>
            </div>
        </div>

        <div class="glass-card p-6 sm:p-8 rounded-3xl border-black/5 dark:border-white/10 shadow-sm">
            <form action="{{ route('admin.venues.seats.update', [$venue, $seat]) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="section"
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Section</label>
                        <input type="text" name="section" id="section" value="{{ old('section', $seat->section) }}"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            placeholder="e.g. A">
                        @error('section')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="row"
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Row</label>
                        <input type="text" name="row" id="row" value="{{ old('row', $seat->row) }}"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            placeholder="e.g. 1">
                        @error('row')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="number" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Seat
                            Number</label>
                        <input type="text" name="number" id="number" value="{{ old('number', $seat->number) }}"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            placeholder="e.g. 101" required>
                        @error('number')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="type"
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Type</label>
                        <select name="type" id="type"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                            <option value="standard" {{ old('type', $seat->type) == 'standard' ? 'selected' : '' }}>Standard
                            </option>
                            <option value="vip" {{ old('type', $seat->type) == 'vip' ? 'selected' : '' }}>VIP</option>
                            <option value="accessible" {{ old('type', $seat->type) == 'accessible' ? 'selected' : '' }}>
                                Accessible</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status"
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Status</label>
                        <select name="status" id="status"
                            class="w-full rounded-xl border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                            <option value="available" {{ old('status', $seat->status) == 'available' ? 'selected' : '' }}>
                                Available</option>
                            <option value="blocked" {{ old('status', $seat->status) == 'blocked' ? 'selected' : '' }}>Blocked
                            </option>
                            <option value="maintenance" {{ old('status', $seat->status) == 'maintenance' ? 'selected' : '' }}>
                                Maintenance</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end pt-4 gap-4">
                    <a href="{{ route('admin.venues.seats.index', $venue) }}"
                        class="text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 font-medium transition-colors">Cancel</a>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-indigo-600/20 transition-all duration-300 transform hover:scale-[1.02] active:scale-95">
                        Update Seat
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection