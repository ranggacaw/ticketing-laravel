<div class="max-w-md mx-auto relative group">
    <!-- Scanner Overlay -->
    <div class="absolute -inset-1 bg-gradient-to-r from-red-600 to-violet-600 rounded-lg blur opacity-25 group-hover:opacity-100 transition duration-1000 group-hover:duration-200"></div>
    
    <div class="relative bg-slate-900 ring-1 ring-slate-900/5 rounded-lg leading-none flex items-top justify-start space-x-6">
        <div class="w-full space-y-6">
            
            <div class="p-6">
                <form wire:submit.prevent="scan" class="space-y-4">
                    <div>
                        <label for="barcode" class="text-sm font-medium text-slate-400 block mb-2">Scan Barcode / Enter UUID</label>
                        <div class="relative">
                            <input 
                                type="text" 
                                id="barcode"
                                wire:model="barcode_input" 
                                class="w-full bg-slate-800 border-none rounded-md py-3 px-4 text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500 transition shadow-inner font-mono text-center tracking-wider text-xl"
                                placeholder="Start Scanning..." 
                                autofocus
                                autocomplete="off"
                            >
                            <div wire:loading wire:target="scan" class="absolute right-3 top-3">
                                <svg class="animate-spin h-6 w-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <button 
                        type="submit" 
                        class="w-full py-3 px-6 rounded-md bg-indigo-600 hover:bg-indigo-500 text-white font-bold shadow-lg shadow-indigo-500/30 transition transform active:scale-95 flex items-center justify-center gap-2"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                        Validate Ticket
                    </button>
                </form>

                <!-- Result Area -->
                @if($scan_result)
                    <div class="mt-6 p-4 rounded-lg border {{ $scan_result['status'] === 'success' ? 'bg-emerald-500/10 border-emerald-500/20' : 'bg-rose-500/10 border-rose-500/20' }}">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0">
                                @if($scan_result['status'] === 'success')
                                    <svg class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @else
                                    <svg class="h-6 w-6 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h3 class="font-medium {{ $scan_result['status'] === 'success' ? 'text-emerald-400' : 'text-rose-400' }}">
                                    {{ $scan_result['message'] }}
                                </h3>
                                @if(isset($scan_result['ticket']))
                                    <div class="mt-1 text-sm text-slate-300">
                                        <p>Attendee: <span class="text-white font-semibold">{{ $scan_result['ticket']->user_name ?? 'N/A' }}</span></p>
                                        <p>Type: <span class="text-white font-semibold">{{ $scan_result['ticket']->ticketType->name ?? 'Unknown Type' }}</span></p>
                                        @if($scan_result['ticket']->seat_number)
                                            <p>Seat: <span class="text-white font-semibold">{{ $scan_result['ticket']->seat_number }}</span></p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Recent Scans -->
            @if(count($recent_scans) > 0)
                <div class="border-t border-slate-800 bg-slate-900/50 p-4 rounded-b-lg">
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Recent Activity</h3>
                    <ul class="space-y-3">
                        @foreach($recent_scans as $scan)
                            <li class="flex justify-between items-center text-sm animate-fade-in-down">
                                <div class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $scan['status'] === 'success' ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                    <span class="font-mono text-slate-400">{{ $scan['time'] }}</span>
                                    <span class="text-slate-300">{{ $scan['attendee'] ?? $scan['code'] }}</span>
                                </div>
                                <span class="{{ $scan['status'] === 'success' ? 'text-emerald-500' : 'text-rose-500' }} font-medium text-xs">
                                    {{ $scan['status'] === 'success' ? 'OK' : 'FAIL' }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
    </div>
</div>
