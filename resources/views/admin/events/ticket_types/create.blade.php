@extends('layouts.admin')

@section('content')
    <div class="space-y-8 animate-in fade-in duration-700 max-w-4xl mx-auto">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.events.ticket-types.index', $event) }}"
                    class="group inline-flex items-center text-sm text-slate-500 hover:text-indigo-400 mb-2 transition-colors">
                    <svg class="w-4 h-4 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Ticket Types
                </a>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">Add <span class="gradient-text">Ticket Type</span>
                </h2>
                <p class="text-slate-400 mt-1 font-light text-sm">Create a new ticket tier for {{ $event->name }}.</p>
            </div>
        </div>

        <div class="glass-card p-6 sm:p-8 rounded-3xl border-black/5  shadow-sm">
            <form action="{{ route('admin.events.ticket-types.store', $event) }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Basic Info -->
                    <div class="col-span-2">
                        <label for="name" class="block text-sm font-medium text-slate-700  mb-1">Ticket
                            Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="w-full rounded-xl border-slate-200  bg-white/50  focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            placeholder="e.g. Early Bird, VIP, General Admission" required>
                        @error('name')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2">
                        <label for="description"
                            class="block text-sm font-medium text-slate-700  mb-1">Description</label>
                        <textarea name="description" id="description" rows="2"
                            class="w-full rounded-xl border-slate-200  bg-white/50  focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            placeholder="Ticket perks, access details...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pricing & Quantity -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-slate-700  mb-1">Price
                            (IDR)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500">Rp</span>
                            <input type="number" name="price" id="price" value="{{ old('price') }}"
                                class="w-full pl-10 rounded-xl border-slate-200  bg-white/50  focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                                placeholder="0" min="0" step="1000" required>
                        </div>
                        @error('price')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="quantity"
                            class="block text-sm font-medium text-slate-700  mb-1">Total Quantity</label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}"
                            class="w-full rounded-xl border-slate-200  bg-white/50  focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            placeholder="100" min="1" required>
                        @error('quantity')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sale Period -->
                    <div>
                        <label for="sale_start_date"
                            class="block text-sm font-medium text-slate-700  mb-1">Sale Start
                            (Optional)</label>
                        <input type="datetime-local" name="sale_start_date" id="sale_start_date"
                            value="{{ old('sale_start_date') }}"
                            class="w-full rounded-xl border-slate-200  bg-white/50  focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                        <p class="text-xs text-slate-400 mt-1">Leave blank to start immediately.</p>
                        @error('sale_start_date')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sale_end_date"
                            class="block text-sm font-medium text-slate-700  mb-1">Sale End
                            (Optional)</label>
                        <input type="datetime-local" name="sale_end_date" id="sale_end_date"
                            value="{{ old('sale_end_date') }}"
                            class="w-full rounded-xl border-slate-200  bg-white/50  focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                        <p class="text-xs text-slate-400 mt-1">Leave blank to end when event starts.</p>
                        @error('sale_end_date')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end pt-4 gap-4">
                    <a href="{{ route('admin.events.ticket-types.index', $event) }}"
                        class="text-slate-500 hover:text-slate-700  font-medium transition-colors">Cancel</a>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-indigo-600/20 transition-all duration-300 transform hover:scale-[1.02] active:scale-95">
                        Create Ticket Type
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection