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
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">Add <span class="gradient-text">Seats</span></h2>
                <p class="text-slate-400 mt-1 font-light text-sm">Create individual seats or generate entire rows.</p>
            </div>
        </div>

        <div class="glass-card p-6 sm:p-8 rounded-3xl border-black/5  shadow-sm">

            <!-- Tabs -->
            <div class="flex gap-4 mb-6 border-b border-black/5  pb-1">
                <button type="button" onclick="switchMode('single')" id="tab-single"
                    class="px-4 py-2 text-sm font-medium text-indigo-600 border-b-2 border-indigo-600 transition-colors">
                    Single Seat
                </button>
                <button type="button" onclick="switchMode('bulk')" id="tab-bulk"
                    class="px-4 py-2 text-sm font-medium text-slate-500 hover:text-slate-700  border-b-2 border-transparent transition-colors">
                    Bulk Create (Row)
                </button>
            </div>

            <form action="{{ route('admin.venues.seats.store', $venue) }}" method="POST" class="space-y-6">
                @csrf

                <input type="hidden" name="bulk_mode" id="bulk_mode" value="0">

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Common Fields -->
                    <div>
                        <label for="section"
                            class="block text-sm font-medium text-slate-700  mb-1">Section</label>
                        <input type="text" name="section" id="section" value="{{ old('section') }}"
                            class="w-full rounded-xl border-slate-200  bg-white/50  focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            placeholder="e.g. VIP Area, Balcony">
                        @error('section')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="row"
                            class="block text-sm font-medium text-slate-700  mb-1">Row</label>
                        <input type="text" name="row" id="row" value="{{ old('row') }}"
                            class="w-full rounded-xl border-slate-200  bg-white/50  focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            placeholder="e.g. A, 1, Front">
                        @error('row')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Single Mode Field -->
                    <div id="field-number" class="col-span-2 sm:col-span-1">
                        <label for="number" class="block text-sm font-medium text-slate-700  mb-1">Seat
                            Number</label>
                        <input type="text" name="number" id="number" value="{{ old('number') }}"
                            class="w-full rounded-xl border-slate-200  bg-white/50  focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                            placeholder="e.g. 101">
                        @error('number')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bulk Mode Fields -->
                    <div id="field-bulk" class="hidden col-span-2 grid grid-cols-2 gap-6">
                        <div>
                            <label for="number_start"
                                class="block text-sm font-medium text-slate-700  mb-1">Start
                                Number</label>
                            <input type="number" name="number_start" id="number_start" value="{{ old('number_start') }}"
                                class="w-full rounded-xl border-slate-200  bg-white/50  focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                                placeholder="1">
                            @error('number_start')
                                <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="number_end"
                                class="block text-sm font-medium text-slate-700  mb-1">End Number</label>
                            <input type="number" name="number_end" id="number_end" value="{{ old('number_end') }}"
                                class="w-full rounded-xl border-slate-200  bg-white/50  focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                                placeholder="20">
                            @error('number_end')
                                <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Type & Status -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-slate-700  mb-1">Seat
                            Type</label>
                        <select name="type" id="type"
                            class="w-full rounded-xl border-slate-200  bg-white/50  focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                            <option value="standard" {{ old('type') == 'standard' ? 'selected' : '' }}>Standard</option>
                            <option value="vip" {{ old('type') == 'vip' ? 'selected' : '' }}>VIP</option>
                            <option value="accessible" {{ old('type') == 'accessible' ? 'selected' : '' }}>Accessible</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status"
                            class="block text-sm font-medium text-slate-700  mb-1">Initial Status</label>
                        <select name="status" id="status"
                            class="w-full rounded-xl border-slate-200  bg-white/50  focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                            <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="blocked" {{ old('status') == 'blocked' ? 'selected' : '' }}>Blocked</option>
                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance
                            </option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end pt-4 gap-4">
                    <a href="{{ route('admin.venues.seats.index', $venue) }}"
                        class="text-slate-500 hover:text-slate-700  font-medium transition-colors">Cancel</a>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-indigo-600/20 transition-all duration-300 transform hover:scale-[1.02] active:scale-95">
                        Save Seat(s)
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function switchMode(mode) {
            const singleTab = document.getElementById('tab-single');
            const bulkTab = document.getElementById('tab-bulk');
            const bulkInput = document.getElementById('bulk_mode');
            const fieldNumber = document.getElementById('field-number');
            const fieldBulk = document.getElementById('field-bulk');

            if (mode === 'bulk') {
                singleTab.classList.remove('text-indigo-600', 'border-indigo-600');
                singleTab.classList.add('text-slate-500', 'border-transparent');

                bulkTab.classList.add('text-indigo-600', 'border-indigo-600');
                bulkTab.classList.remove('text-slate-500', 'border-transparent');

                fieldNumber.classList.add('hidden');
                fieldBulk.classList.remove('hidden');
                bulkInput.value = '1';
            } else {
                bulkTab.classList.remove('text-indigo-600', 'border-indigo-600');
                bulkTab.classList.add('text-slate-500', 'border-transparent');

                singleTab.classList.add('text-indigo-600', 'border-indigo-600');
                singleTab.classList.remove('text-slate-500', 'border-transparent');

                fieldBulk.classList.add('hidden');
                fieldNumber.classList.remove('hidden');
                bulkInput.value = '0';
            }
        }

        // Check errors on load to persist mode
        document.addEventListener('DOMContentLoaded', () => {
            @if($errors->has('number_start') || $errors->has('number_end'))
                switchMode('bulk');
            @endif
        });
    </script>
@endsection