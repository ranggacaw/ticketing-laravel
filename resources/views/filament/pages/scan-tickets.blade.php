<x-filament-panels::page>
    <div x-data="{
            tab: 'automatic',
            scanner: null,
            lastScanned: null,
            isProcessing: false,
            scanComplete: false,

            initScanner() {
                if (this.scanner) return;
                
                this.$nextTick(() => {
                    const html5QrcodeScanner = new Html5QrcodeScanner(
                        'reader', 
                        { 
                            fps: 10, 
                            qrbox: {width: 250, height: 250},
                            aspectRatio: 1.0,
                            videoConstraints: {
                                facingMode: 'environment'
                            }
                        },
                        /* verbose= */ false
                    );
                    
                    html5QrcodeScanner.render((decodedText, decodedResult) => {
                        console.log('Scan success:', decodedText);
                        this.handleScan(decodedText);
                    }, (errorMessage) => {
                        // console.log('Scan error:', errorMessage);
                    });

                    this.scanner = html5QrcodeScanner;
                });
            },

            stopScanner() {
                if (this.scanner) {
                    this.scanner.clear().catch(error => {
                        console.error('Failed to clear html5QrcodeScanner. ', error);
                    });
                    this.scanner = null;
                }
            },

            handleScan(code) {
                console.log('Handling scan for code:', code);
                if (this.isProcessing || code === this.lastScanned) {
                    console.log('Skipping: processing=' + this.isProcessing + ', lastScanned=' + this.lastScanned);
                    return;
                }
                
                this.isProcessing = true;
                this.scanComplete = false;
                this.lastScanned = code;

                console.log('Auto-captured TicketID:', code);
                
                // Replicate manual mechanism: set the code in manualCode input and call checkManualCode
                $wire.set('manualCode', code)
                    .then(() => {
                        console.log('Triggering manual verification for:', code);
                        return $wire.checkManualCode();
                    })
                    .then(() => {
                        console.log('Verification completed');
                        this.isProcessing = false;
                        this.scanComplete = true;
                    })
                    .catch(err => {
                        console.error('Verification failed:', err);
                        this.isProcessing = false;
                    });
                
                // Reset lastScanned after delay to allow rescanning same code
                setTimeout(() => {
                    this.lastScanned = null;
                }, 3000); 
            },

            resetScan() {
                this.scanComplete = false;
                this.lastScanned = null;
                $wire.resetScanner();
            }
        }" 
        x-init="
            $watch('tab', value => {
                if (value === 'automatic') {
                    initScanner();
                } else {
                    stopScanner();
                }
            }); 
            initScanner();
            
            // Listen for Livewire scan-completed event
            $wire.on('scan-completed', (data) => {
                console.log('Scan completed event received:', data);
                isProcessing = false;
                scanComplete = true;
            });
        " class="flex flex-col gap-6">
        <!-- Tabs Navigation -->
        <div x-show="!window.isSecureContext" class="bg-amber-50 border-l-4 border-amber-400 p-4 mb-4" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-amber-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-amber-700">
                        Camera access requires a secure context (HTTPS or localhost). Scanner may not work.
                    </p>
                </div>
            </div>
        </div>

        <div class="flex p-1 space-x-1 bg-gray-100/50 rounded-xl p-2">
            <button
                class="w-full py-2.5 text-sm font-medium leading-5 rounded-lg focus:outline-none transition-all duration-200"
                :class="tab === 'automatic' ? 'bg-white shadow text-indigo-700' : 'text-gray-500 hover:text-gray-700 hover:bg-white/[0.12]'"
                @click="tab = 'automatic'">
                <div class="flex items-center justify-center gap-2">
                    <x-heroicon-o-camera class="w-5 h-5" />
                    <span>Automatic</span>
                </div>
            </button>
            <button
                class="w-full py-2.5 text-sm font-medium leading-5 rounded-lg focus:outline-none transition-all duration-200"
                :class="tab === 'manual' ? 'bg-white shadow text-indigo-700' : 'text-gray-500 hover:text-gray-700 hover:bg-white/[0.12]'"
                @click="tab = 'manual'">
                <div class="flex items-center justify-center gap-2">
                    <x-heroicon-o-pencil-square class="w-5 h-5" />
                    <span>Manual</span>
                </div>
            </button>
        </div>

        <!-- Automatic Tab Content -->
        <div x-show="tab === 'automatic'" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            class="bg-white p-4 rounded-xl shadow border border-gray-100">
            <div id="reader" class="w-full rounded-lg overflow-hidden"></div>
            <p class="text-center text-sm text-gray-500 mt-4">
                Position the QR code within the frame to scan.
            </p>

            <div x-show="lastScanned" class="mt-4 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                <div class="text-center">
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Captured Ticket ID</p>
                    <p x-text="lastScanned" class="font-mono font-bold text-lg text-gray-800 bg-white px-3 py-2 rounded border border-gray-300 inline-block"></p>
                </div>
                <div class="mt-2 text-center">
                    <span x-show="isProcessing" class="inline-flex items-center gap-1 text-indigo-600 text-sm">
                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Verifying ticket...
                    </span>
                    <span x-show="scanComplete && !isProcessing" class="inline-flex items-center gap-1 text-green-600 text-sm font-medium">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Verification complete
                    </span>
                </div>
            </div>

            @if($scannedResult)
                <div class="mt-6 space-y-6">
                    <!-- Status Banner -->
                    <div class="p-4 rounded-xl border {{ $scannedResult['status'] === 'success' ? 'bg-green-50 border-green-200' : ($scannedResult['status'] === 'warning' ? 'bg-yellow-50 border-yellow-200' : 'bg-red-50 border-red-200') }}">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0">
                                @if($scannedResult['status'] === 'success')
                                    <x-heroicon-m-check-circle class="w-8 h-8 text-green-500" />
                                @elseif($scannedResult['status'] === 'warning')
                                    <x-heroicon-m-exclamation-triangle class="w-8 h-8 text-yellow-500" />
                                @else
                                    <x-heroicon-m-x-circle class="w-8 h-8 text-red-500" />
                                @endif
                            </div>
                            <div>
                                <h3 class="font-bold text-lg {{ $scannedResult['status'] === 'success' ? 'text-green-800' : ($scannedResult['status'] === 'warning' ? 'text-yellow-800' : 'text-red-800') }}">
                                    {{ $scannedResult['title'] }}
                                </h3>
                                <p class="text-sm {{ $scannedResult['status'] === 'success' ? 'text-green-700' : ($scannedResult['status'] === 'warning' ? 'text-yellow-700' : 'text-red-700') }}">
                                    {{ $scannedResult['message'] }}
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($scannedTicket)
                        <!-- Detailed Ticket Info -->
                        <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-xl shadow-gray-200/40">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-10 h-10 rounded-2xl bg-indigo-50 flex items-center justify-center">
                                    <x-heroicon-m-ticket class="w-6 h-6 text-indigo-600" />
                                </div>
                                <h3 class="text-xl font-black text-gray-900">Ticket Details</h3>
                            </div>

                            <!-- Main Event Info -->
                            <div class="flex flex-col md:flex-row gap-6 mb-8 pb-8 border-b border-gray-100">
                                @if($scannedTicket->event && $scannedTicket->event->banner_url)
                                    <img src="{{ $scannedTicket->event->banner_url }}" alt="{{ $scannedTicket->event->name }}" class="w-full md:w-32 h-32 object-cover rounded-xl shadow-sm">
                                @endif
                                <div class="flex-1 space-y-2">
                                    <h2 class="text-2xl font-black text-gray-900 leading-tight">{{ $scannedTicket->event->name ?? 'Unknown Event' }}</h2>
                                    <div class="flex items-center text-gray-500 gap-2 text-sm">
                                        <x-heroicon-m-calendar class="w-4 h-4" />
                                        <span>{{ $scannedTicket->event->start_time?->format('d M, Y • h:i A') }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-500 gap-2 text-sm">
                                        <x-heroicon-m-map-pin class="w-4 h-4" />
                                        <span>{{ $scannedTicket->event->location ?? 'Unknown Location' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Fields Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="flex justify-between items-center text-sm py-2 border-b border-gray-50">
                                    <span class="text-gray-500 font-bold uppercase text-[10px] tracking-widest">Holder</span>
                                    <span class="font-bold text-gray-900">{{ $scannedTicket->user->name ?? $scannedTicket->user_name }}</span>
                                </div>
                                <div class="flex justify-between items-center text-sm py-2 border-b border-gray-50">
                                    <span class="text-gray-500 font-bold uppercase text-[10px] tracking-widest">Ticket ID</span>
                                    <span class="font-mono text-xs font-bold text-gray-900 bg-gray-100 px-2 py-1 rounded">{{ $scannedTicket->uuid }}</span>
                                </div>
                                <div class="flex justify-between items-center text-sm py-2 border-b border-gray-50">
                                    <span class="text-gray-500 font-bold uppercase text-[10px] tracking-widest">Type</span>
                                    <span class="font-bold text-indigo-600 px-2 py-1 bg-indigo-50 rounded-full text-xs">{{ $scannedTicket->ticketType->name ?? $scannedTicket->type }}</span>
                                </div>
                                <div class="flex justify-between items-center text-sm py-2 border-b border-gray-50">
                                    <span class="text-gray-500 font-bold uppercase text-[10px] tracking-widest">Seat</span>
                                    <span class="font-bold text-gray-900">{{ $scannedTicket->seat_number ?? 'General Admission' }}</span>
                                </div>
                                <div class="flex justify-between items-center text-sm py-2 border-b border-gray-50">
                                    <span class="text-gray-500 font-bold uppercase text-[10px] tracking-widest">Status</span>
                                    @if($scannedTicket->scanned_at || $scannedTicket->status === 'used')
                                        <span class="font-bold text-gray-600 px-2 py-1 bg-gray-100 rounded-full text-xs">Used / Scanned</span>
                                    @elseif($scannedTicket->status === 'cancelled')
                                        <span class="font-bold text-red-600 px-2 py-1 bg-red-100 rounded-full text-xs">Cancelled</span>
                                    @else
                                        <span class="font-bold text-emerald-600 px-2 py-1 bg-emerald-100 rounded-full text-xs">Valid</span>
                                    @endif
                                </div>
                                <div class="flex justify-between items-center text-sm py-2 border-b border-gray-50">
                                    <span class="text-gray-500 font-bold uppercase text-[10px] tracking-widest">Paid</span>
                                    <span class="font-black text-gray-900">Rp {{ number_format($scannedTicket->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Action Button -->
                    <button @click="resetScan()" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black text-lg rounded-2xl shadow-xl shadow-indigo-200 transition-all transform hover:scale-[1.02] flex items-center justify-center gap-2">
                        <x-heroicon-m-qr-code class="w-6 h-6"/>
                        <span>{{ isset($scannedTicket) ? 'Scan Next Ticket' : 'Try Again' }}</span>
                    </button>
                </div>
            @endif


        </div>

        <!-- Manual Tab Content -->
        <div x-show="tab === 'manual'" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            class="bg-white p-6 rounded-xl shadow border border-gray-100">
            <form wire:submit.prevent="checkManualCode" class="space-y-4">
                <div>
                    <label for="manualCode" class="block text-sm font-medium text-gray-700 mb-1">Ticket ID /
                        Barcode</label>
                    <input type="text" id="manualCode" wire:model="manualCode" placeholder="e.g. TICKET-123456"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4" />
                    @error('manualCode') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <button type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    <x-heroicon-o-magnifying-glass class="w-5 h-5 mr-2" />
                    Verify Ticket
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
        <style>
            /* Custom tweaks for scanner buttons self-contained */
            #reader button {
                background-color: #4f46e5;
                color: white;
                padding: 8px 16px;
                border-radius: 0.5rem;
                margin-top: 8px;
                border: none;
                cursor: pointer;
            }

            #reader select {
                display: block;
                width: 100%;
                padding: 8px;
                border-radius: 0.375rem;
                border: 1px solid #d1d5db;
                margin-bottom: 8px;
            }
        </style>
    @endpush
</x-filament-panels::page>