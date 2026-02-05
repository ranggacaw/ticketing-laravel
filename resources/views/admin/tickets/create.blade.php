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
                            <option value="VIP" {{ old('type') == 'VIP' ? 'selected' : '' }} class="bg-slate-900">VIP / Premium</option>
                            <option value="Staff" {{ old('type') == 'Staff' ? 'selected' : '' }} class="bg-slate-900">Staff Access</option>
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
                            <span class="text-lg font-bold ml-1">$</span>
                        </div>
                        <input type="number" step="0.01" name="price" id="price" value="{{ old('price', 0) }}" required
                            class="w-full pl-12 pr-4 py-4 bg-white/5 border border-white/10 rounded-2xl text-slate-200 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500/40 transition-all"
                            placeholder="0.00">
                    </div>
                </div>
            </div>

            <div class="pt-8 flex flex-col items-center gap-4">
                <button type="submit" class="w-full group relative flex items-center justify-center gap-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-4 px-8 rounded-2xl transition-all duration-300 transform hover:scale-[1.01] active:scale-95 shadow-xl shadow-indigo-600/20">
                    <svg class="h-6 w-6 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                    <span>Generate Ticket & Create Barcode</span>
                </button>
                <p class="text-xs text-slate-500 font-light italic">Unique barcode will be automatically generated upon saving.</p>
            </div>
        </form>
    </div>
</div>
@endsection
