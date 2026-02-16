<x-filament-panels::page>
    <div 
        x-data="{
            tab: 'automatic',
            scanner: null,
            lastScanned: null,
            isProcessing: false,

            initScanner() {
                if (this.scanner) return;
                
                this.$nextTick(() => {
                    const html5QrcodeScanner = new Html5QrcodeScanner(
                        'reader', 
                        { 
                            fps: 10, 
                            qrbox: {width: 250, height: 250},
                            aspectRatio: 1.0
                        },
                        /* verbose= */ false
                    );
                    
                    html5QrcodeScanner.render((decodedText, decodedResult) => {
                        this.handleScan(decodedText);
                    }, (errorMessage) => {
                        // ignore errors
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
                if (this.isProcessing || code === this.lastScanned) return;
                
                this.isProcessing = true;
                this.lastScanned = code;

                $wire.dispatch('scan-success', { code: code });
                
                // Debounce next scan
                setTimeout(() => {
                    this.isProcessing = false;
                    this.lastScanned = null; // Allow rescanning same code after delay
                }, 3000); 
            }
        }"
        x-init="$watch('tab', value => {
            if (value === 'automatic') {
                initScanner();
            } else {
                stopScanner();
            }
        }); initScanner();"
        class="flex flex-col gap-6"
    >
        <!-- Tabs Navigation -->
        <div class="flex p-1 space-x-1 bg-gray-100/50 rounded-xl p-2">
            <button 
                class="w-full py-2.5 text-sm font-medium leading-5 rounded-lg focus:outline-none transition-all duration-200"
                :class="tab === 'automatic' ? 'bg-white shadow text-indigo-700' : 'text-gray-500 hover:text-gray-700 hover:bg-white/[0.12]'"
                @click="tab = 'automatic'"
            >
                <div class="flex items-center justify-center gap-2">
                    <x-heroicon-o-camera class="w-5 h-5"/>
                    <span>Automatic</span>
                </div>
            </button>
            <button 
                class="w-full py-2.5 text-sm font-medium leading-5 rounded-lg focus:outline-none transition-all duration-200"
                :class="tab === 'manual' ? 'bg-white shadow text-indigo-700' : 'text-gray-500 hover:text-gray-700 hover:bg-white/[0.12]'"
                @click="tab = 'manual'"
            >
                <div class="flex items-center justify-center gap-2">
                    <x-heroicon-o-pencil-square class="w-5 h-5"/>
                    <span>Manual</span>
                </div>
            </button>
        </div>

        <!-- Automatic Tab Content -->
        <div x-show="tab === 'automatic'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="bg-white p-4 rounded-xl shadow border border-gray-100">
            <div id="reader" class="w-full rounded-lg overflow-hidden"></div>
            <p class="text-center text-sm text-gray-500 mt-4">
                Position the QR code within the frame to scan.
            </p>
        </div>

        <!-- Manual Tab Content -->
        <div x-show="tab === 'manual'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="bg-white p-6 rounded-xl shadow border border-gray-100">
            <form wire:submit.prevent="checkManualCode" class="space-y-4">
                <div>
                    <label for="manualCode" class="block text-sm font-medium text-gray-700 mb-1">Ticket ID / Barcode</label>
                    <input 
                        type="text" 
                        id="manualCode" 
                        wire:model="manualCode" 
                        placeholder="e.g. TICKET-123456" 
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4" 
                    />
                    @error('manualCode') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    <x-heroicon-o-magnifying-glass class="w-5 h-5 mr-2"/>
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