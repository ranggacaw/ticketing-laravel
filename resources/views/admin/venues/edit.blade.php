@extends('layouts.admin')

@section('content')
    <div class="space-y-8 animate-in fade-in duration-700 max-w-4xl mx-auto">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.venues.index') }}"
                    class="group inline-flex items-center text-sm text-slate-500 hover:text-indigo-400 mb-2 transition-colors">
                    <svg class="w-4 h-4 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Venues
                </a>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">Edit <span class="gradient-text">Venue</span></h2>
                <p class="text-slate-400 mt-1 font-light text-sm">Update location and capacity details.</p>
            </div>
        </div>

        <div class="glass-card p-6 sm:p-8 rounded-3xl border-black/5  shadow-sm">
            <form action="{{ route('admin.venues.update', $venue) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="col-span-2">
                        <label for="name" class="block text-sm font-medium text-slate-700  mb-1">Venue
                            Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $venue->name) }}"
                            class="w-full rounded-xl border-slate-200  bg-white/50  focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            placeholder="e.g. Grand City Hall" required>
                        @error('name')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2">
                        <label for="description"
                            class="block text-sm font-medium text-slate-700  mb-1">Description</label>
                        <textarea name="description" id="description" rows="3"
                            class="w-full rounded-xl border-slate-200  bg-white/50  focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            placeholder="Optional description about the venue...">{{ old('description', $venue->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2">
                        <label for="address"
                            class="block text-sm font-medium text-slate-700  mb-1">Address</label>
                        <input type="text" name="address" id="address" value="{{ old('address', $venue->address) }}"
                            class="w-full rounded-xl border-slate-200  bg-white/50  focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            placeholder="Street Address" required>
                        @error('address')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="city"
                            class="block text-sm font-medium text-slate-700  mb-1">City</label>
                        <input type="text" name="city" id="city" value="{{ old('city', $venue->city) }}"
                            class="w-full rounded-xl border-slate-200  bg-white/50  focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            placeholder="City" required>
                        @error('city')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="state" class="block text-sm font-medium text-slate-700  mb-1">State /
                            Province</label>
                        <input type="text" name="state" id="state" value="{{ old('state', $venue->state) }}"
                            class="w-full rounded-xl border-slate-200  bg-white/50  focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            placeholder="State">
                        @error('state')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="country"
                            class="block text-sm font-medium text-slate-700  mb-1">Country</label>
                        <input type="text" name="country" id="country" value="{{ old('country', $venue->country) }}"
                            class="w-full rounded-xl border-slate-200  bg-white/50  focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            placeholder="Country" required>
                        @error('country')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="postal_code"
                            class="block text-sm font-medium text-slate-700  mb-1">Postal Code</label>
                        <input type="text" name="postal_code" id="postal_code"
                            value="{{ old('postal_code', $venue->postal_code) }}"
                            class="w-full rounded-xl border-slate-200  bg-white/50  focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            placeholder="Zip Code">
                        @error('postal_code')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="capacity" class="block text-sm font-medium text-slate-700  mb-1">Max
                            Capacity</label>
                        <input type="number" name="capacity" id="capacity" value="{{ old('capacity', $venue->capacity) }}"
                            class="w-full rounded-xl border-slate-200  bg-white/50  focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            placeholder="Total seats available">
                        @error('capacity')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end pt-4 gap-4">
                    <a href="{{ route('admin.venues.index') }}"
                        class="text-slate-500 hover:text-slate-700  font-medium transition-colors">Cancel</a>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-indigo-600/20 transition-all duration-300 transform hover:scale-[1.02] active:scale-95">
                        Update Venue
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection