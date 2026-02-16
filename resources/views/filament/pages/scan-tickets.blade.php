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

                console.log('Calling Livewire handleScan...');
                $wire.handleScan(code)
                    .then(() => {
                        console.log('Livewire call handled');
                        this.isProcessing = false;
                        this.scanComplete = true;
                    })
                    .catch(err => {
                        console.error('Livewire call failed:', err);
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
                $wire.set('scannedResult', null);
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

            <div x-show="lastScanned" class="mt-2 text-center text-sm text-gray-600 bg-gray-50 p-2 rounded">
                Scanned: <span x-text="lastScanned" class="font-mono font-bold"></span>
                <span x-show="isProcessing" class="text-indigo-600 ml-2 animate-pulse">Processing...</span>
                <span x-show="scanComplete && !isProcessing" class="text-green-600 ml-2">Done!</span>
            </div>

            @if($scannedResult)
                <div
                    class="mt-6 p-4 rounded-xl border {{ $scannedResult['status'] === 'success' ? 'bg-green-50 border-green-200' : ($scannedResult['status'] === 'warning' ? 'bg-yellow-50 border-yellow-200' : 'bg-red-50 border-red-200') }}">
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
                            <h3
                                class="font-bold text-lg {{ $scannedResult['status'] === 'success' ? 'text-green-800' : ($scannedResult['status'] === 'warning' ? 'text-yellow-800' : 'text-red-800') }}">
                                {{ $scannedResult['title'] }}
                            </h3>
                            <p
                                class="text-sm {{ $scannedResult['status'] === 'success' ? 'text-green-700' : ($scannedResult['status'] === 'warning' ? 'text-yellow-700' : 'text-red-700') }}">
                                {{ $scannedResult['message'] }}
                            </p>
                            @if(isset($scannedResult['ticket']))
                                <div
                                    class="mt-2 text-sm font-semibold {{ $scannedResult['status'] === 'success' ? 'text-green-900' : ($scannedResult['status'] === 'warning' ? 'text-yellow-900' : 'text-red-900') }}">
                                    User: {{ $scannedResult['ticket']['user_name'] ?? 'Unknown' }}
                                    <br>
                                    Type: {{ $scannedResult['ticket']['type'] ?? 'Unknown' }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="mt-4">
                        <button @click="resetScan()"
                            class="w-full py-2 bg-white border border-gray-300 rounded shadow-sm text-sm font-medium hover:bg-gray-50">
                            Scan Next
                        </button>
                    </div>
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