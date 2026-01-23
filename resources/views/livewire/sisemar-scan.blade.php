<div>
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <!-- RESULT STATE -->
                @if (!$isScanning)
                    <div class="text-center">
                        <!-- Alert Info -->
                        @if ($message)
                            <div class="mb-6 border-l-4 p-6 rounded shadow-md
                                        @if($statusType === 'success') bg-green-50 border-green-500 text-green-800 
                                        @elseif($statusType === 'error') bg-red-50 border-red-500 text-red-800 
                                        @elseif($statusType === 'warning') bg-yellow-50 border-yellow-500 text-yellow-800 
                                        @endif">

                                <h3 class="font-bold text-2xl mb-2">
                                    @if($statusType === 'success') SUCCESS
                                    @elseif($statusType === 'error') ERROR
                                    @elseif($statusType === 'warning') ALREADY CHECKED-IN
                                    @endif
                                </h3>
                                <p class="text-lg">{{ $message }}</p>
                            </div>

                            @if($scannedData)
                                <div class="mt-4 p-6 bg-gray-50 border border-gray-200 rounded-lg text-left shadow-sm">
                                    <h4 class="font-semibold text-lg border-b pb-2 mb-3 text-gray-700">Detail Peserta</h4>
                                    <div class="grid grid-cols-1 gap-2 text-gray-800">
                                        <p><span class="font-bold w-24 inline-block text-gray-500">Nama:</span>
                                            {{ $scannedData['name'] }}</p>
                                        <p><span class="font-bold w-24 inline-block text-gray-500">Email:</span>
                                            {{ $scannedData['email'] }}</p>
                                        <p><span class="font-bold w-24 inline-block text-gray-500">Sekolah:</span>
                                            {{ $scannedData['school'] }}</p>
                                    </div>
                                </div>
                            @endif
                        @endif

                        <div class="mt-8">
                            <button wire:click="nextScan"
                                class="w-full sm:w-auto px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg transform transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Scan Berikutnya
                            </button>
                        </div>
                    </div>
                @endif

                <!-- SCANNING STATE -->
                <div class="@if(!$isScanning) hidden @endif text-center mb-6">
                    <!-- Scanner Container -->
                    <div id="reader" width="600px" wire:ignore
                        class="bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 mx-auto max-w-sm"
                        style="min-height: 250px;">
                    </div>
                    <p class="text-sm text-gray-500 mt-2">Arahkan scanner ke Barcode E-Ticket (dari email).</p>

                    <!-- Manual Input Fallback -->
                    <div class="mt-6 border-t pt-4">
                        <p class="text-sm text-gray-600 mb-2">Masalah dengan scanner? Input manual:</p>
                        <form wire:submit.prevent="scan(document.getElementById('manual-code').value)">
                            <div class="flex max-w-sm mx-auto gap-2">
                                <input type="text" id="manual-code" placeholder="Input kode e-ticket..."
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full py-2 text-sm">
                                <button type="submit"
                                    class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm hover:bg-gray-700 font-semibold transition">Cek</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            const beepSound = new Audio('https://www.soundjay.com/button/beep-07.wav');
            let html5QrcodeScanner = null;
            let isProcessing = false;

            function initScanner() {
                if (html5QrcodeScanner) {
                    // Cleaner initialization to prevent errors
                    try { html5QrcodeScanner.clear(); } catch (e) { }
                }

                // Ensure the element exists before initializing
                const readerElem = document.getElementById('reader');
                if (!readerElem) return;

                html5QrcodeScanner = new Html5QrcodeScanner(
                    "reader",
                    { fps: 10, qrbox: { width: 250, height: 250 } },
                    /* verbose= */ false
                );
                html5QrcodeScanner.render(onScanSuccess, onScanFailure);
            }

            function onScanSuccess(decodedText, decodedResult) {
                if (isProcessing) return;

                isProcessing = true;
                beepSound.play();

                // Stop scanner UI immediately after success to prevent double scans
                if (html5QrcodeScanner) {
                    html5QrcodeScanner.clear();
                }

                // Call Livewire Component method
                @this.scan(decodedText).then(() => {
                    isProcessing = false;
                });
            }

            function onScanFailure(error) {
                // handle error
            }

            // Init scanner on load
            initScanner();

            // Listen for restart event
            Livewire.on('start-scanner', () => {
                // Determine if we need to re-init. 
                // Since DOM might be updated, wait a tick.
                setTimeout(() => {
                    initScanner();
                }, 100);
            });
        });
    </script>
</div>