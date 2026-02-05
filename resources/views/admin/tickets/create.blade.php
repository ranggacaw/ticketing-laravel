@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold tracking-tight">Generate <span class="gradient-text">New Ticket</span></h2>
            <p class="text-slate-400 mt-1 font-light text-sm">Fill in the details below to create a unique event ticket.</p>
        </div>
        <a href="{{ route('admin.tickets.index') }}" class="flex items-center gap-2 text-slate-400 hover:text-slate-200 transition-colors text-sm font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to List
        </a>
    </div>

    <div class="glass-card rounded-3xl overflow-hidden border-white/10">
        <form action="{{ route('admin.tickets.store') }}" method="POST" class="p-8 md:p-12 space-y-10">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- User Name -->
                <div class="space-y-2">
                    <label for="user_name" class="block text-sm font-semibold text-slate-300 ml-1">Guest Full Name</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input type="text" name="user_name" id="user_name" value="{{ old('user_name') }}" required
                            class="w-full pl-12 pr-4 py-4 bg-white/5 border border-white/10 rounded-2xl text-slate-200 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500/40 transition-all @error('user_name') border-rose-500/50 @enderror"
                            placeholder="e.g. John Doe">
                    </div>
                    @error('user_name') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                <!-- User Email -->
                <div class="space-y-2">
                    <label for="user_email" class="block text-sm font-semibold text-slate-300 ml-1">Email Address</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="email" name="user_email" id="user_email" value="{{ old('user_email') }}" required
                            class="w-full pl-12 pr-4 py-4 bg-white/5 border border-white/10 rounded-2xl text-slate-200 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500/40 transition-all @error('user_email') border-rose-500/50 @enderror"
                            placeholder="john@example.com">
                    </div>
                    @error('user_email') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                <!-- Seat Number -->
                <div class="space-y-2">
                    <label for="seat_number" class="block text-sm font-semibold text-slate-300 ml-1">Seat Assignment</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <input type="text" name="seat_number" id="seat_number" value="{{ old('seat_number') }}" required
                            class="w-full pl-12 pr-4 py-4 bg-white/5 border border-white/10 rounded-2xl text-slate-200 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500/40 transition-all @error('seat_number') border-rose-500/50 @enderror"
                            placeholder="e.g. B12, Row 4-A">
                    </div>
                    @error('seat_number') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                <!-- Ticket Type -->
                <div class="space-y-2">
                    <label for="type" class="block text-sm font-semibold text-slate-300 ml-1">Ticket Category</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 11h10M7 15h10" />
                            </svg>
                        </div>
                        <select name="type" id="type" required
                            class="w-full pl-12 pr-4 py-4 bg-white/5 border border-white/10 rounded-2xl text-slate-200 appearance-none focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500/40 transition-all cursor-pointer">
                            <option value="General Admission" {{ old('type') == 'General Admission' ? 'selected' : '' }} class="bg-slate-900">General Admission</option>
                            <option value="Festival" {{ old('type') == 'Festival' ? 'selected' : '' }} class="bg-slate-900">Festival</option>
                            <option value="VIP" {{ old('type') == 'VIP' ? 'selected' : '' }} class="bg-slate-900">VIP</option>
                            <option value="VVIP" {{ old('type') == 'VVIP' ? 'selected' : '' }} class="bg-slate-900">VVIP</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Price -->
                <div class="space-y-2 md:col-span-2">
                    <label for="price" class="block text-sm font-semibold text-slate-300 ml-1">Ticket Price</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                            <span class="text-lg font-bold ml-1">Rp</span>
                        </div>
                        <input type="hidden" name="price" id="real_price" value="{{ old('price', 0) }}">
                        <input type="text" id="display_price" value="{{ old('price', 0) }}" required
                            class="w-full pl-12 pr-4 py-4 bg-white/5 border border-white/10 rounded-2xl text-slate-200 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500/40 transition-all"
                            placeholder="50.000">
                    </div>
                </div>
            </div>

            <div class="pt-8 flex items-center justify-end gap-4">
                <a href="{{ route('admin.tickets.index') }}" class="px-8 py-4 rounded-2xl border border-white/10 text-slate-400 hover:text-slate-200 hover:bg-white/5 transition-all font-bold cursor-pointer">
                    Cancel
                </a>
                <button type="submit" class="flex-1 md:flex-none group relative flex items-center justify-center gap-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-4 px-10 rounded-2xl transition-all duration-300 shadow-xl shadow-indigo-600/20 cursor-pointer">
                    <svg class="h-5 w-5 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Generate Ticket</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        const displayPrice = document.getElementById('display_price');
        const realPrice = document.getElementById('real_price');

        // Define prices for each category
        const prices = {
            'VVIP': 850000,
            'VIP': 500000,
            'Festival': 200000,
            'General Admission': 150000
        };

        // Format number with thousands separator (3000 -> 3.000)
        function formatNumber(num) {
            if (!num && num !== 0) return '';
            return num.toString().replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Initialize display value
        if (realPrice.value) {
            displayPrice.value = formatNumber(realPrice.value);
        }

        // Handle Type Change
        typeSelect.addEventListener('change', function() {
            const selectedType = this.value;
            if (prices.hasOwnProperty(selectedType)) {
                const price = prices[selectedType];
                realPrice.value = price;
                displayPrice.value = formatNumber(price);
            }
        });

        // Handle Manual Price Input
        displayPrice.addEventListener('input', function(e) {
            // Remove all dots to get raw number
            let rawValue = this.value.replace(/\./g, '');
            // Remove any non-digits that might have slipped in
            rawValue = rawValue.replace(/\D/g, '');
            
            // Update the hidden input with integer value
            realPrice.value = rawValue;

            // Re-format the display value
            this.value = formatNumber(rawValue);
        });
    });
</script>
