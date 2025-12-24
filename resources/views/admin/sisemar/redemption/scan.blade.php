<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Scan & Penukaran Tiket Fisik SI SEMAR') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Error Alert -->
                    @if (session('error'))
                        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                            <p class="font-bold">Error!</p>
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif

                    <!-- Step 1: Form Scan E-Ticket (Selalu muncul jika belum ada hasil check) -->
                    @if (!isset($sisemar))
                        <div class="text-center mb-6">
                            <h3 class="text-lg font-bold text-gray-700">LANGKAH 1: Scan Barcode Peserta (Email)</h3>
                            <button onclick="startScanner()"
                                class="mt-2 bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded text-sm hover:bg-gray-300">
                                <i class="fas fa-camera mr-2"></i> Gunakan Kamera
                            </button>
                            <div id="reader-container" class="hidden mt-4">
                                <div id="reader" width="600px"
                                    class="bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 mx-auto max-w-sm">
                                </div>
                                <button onclick="stopScanner()" class="mt-2 text-red-600 text-sm hover:underline">Tutup
                                    Kamera</button>
                            </div>
                            <p class="text-sm text-gray-500 mt-2">Arahkan scanner ke kode E-Ticket peserta.</p>
                        </div>

                        <form id="scan-form" action="{{ route('admin.sisemar.redemption.check') }}" method="POST"
                            class="space-y-4">
                            @csrf
                            <div>
                                <input type="text" name="e_ticket_code" id="e_ticket_code"
                                    class="w-full text-center text-2xl font-mono tracking-widest border-2 border-blue-300 rounded-lg p-4 focus:ring-4 focus:ring-blue-200 focus:border-blue-500 uppercase"
                                    placeholder="ATAU KETIK DI SINI..." autofocus autocomplete="off" required>
                                <p class="text-xs text-gray-400 mt-2 text-center">*Pastikan kursor aktif di kotak ini
                                    sebelum scan</p>
                            </div>
                            <!-- Tombol tidak wajib jika menggunakan scanner (biasanya auto-enter), tapi bagus untuk manual -->
                            <button type="submit"
                                class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition">
                                CEK E-TIKET
                            </button>
                        </form>
                    @endif


                    <!-- Step 2: Hasil Scan & Input Tiket Fisik -->
                    @if(isset($sisemar))
                        <div class="border-2 border-green-500 rounded-xl p-6 bg-green-50 animate-fade-in-down">
                            <div class="flex items-center justify-between mb-4 border-b border-green-200 pb-2">
                                <h3 class="text-lg font-bold text-green-800 flex items-center">
                                    <i class="fas fa-check-circle mr-2"></i> E-TICKET VALID
                                </h3>
                                <a href="{{ route('admin.sisemar.redemption.scan') }}"
                                    class="text-sm text-gray-500 underline hover:text-gray-800">
                                    Batal / Reset
                                </a>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-bold">Nama Peserta</p>
                                    <p class="text-lg font-bold text-gray-900">{{ $sisemar->name }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-bold">Asal Sekolah</p>
                                    <p class="text-gray-800">{{ $sisemar->school }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-bold">Pilihan Jurusan</p>
                                    <p class="text-sm">1. {{ $sisemar->major_preference_1 }}</p>
                                    <p class="text-sm">2. {{ $sisemar->major_preference_2 }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-bold">Status Pembayaran</p>
                                    <span
                                        class="px-2 py-1 rounded text-xs font-bold {{ $sisemar->payment_status == 'LUNAS' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                        {{ $sisemar->payment_status }}
                                    </span>
                                </div>
                            </div>

                            <hr class="border-green-200 my-4">

                            <!-- Form Input Tiket Fisik -->
                            <div class="text-center mb-4">
                                <h4 class="text-md font-bold text-gray-800 mb-1">LANGKAH 2: Berikan Tiket Fisik</h4>
                                <button onclick="startScanner('physical')"
                                    class="mt-2 bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded text-sm hover:bg-gray-300">
                                    <i class="fas fa-camera mr-2"></i> Gunakan Kamera
                                </button>
                                <div id="reader-container-physical" class="hidden mt-4">
                                    <div id="reader-physical" width="600px"
                                        class="bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 mx-auto max-w-sm">
                                    </div>
                                    <button onclick="stopScanner('physical')"
                                        class="mt-2 text-red-600 text-sm hover:underline">Tutup Kamera</button>
                                </div>
                                <p class="text-sm text-gray-600 mt-2">Scan barcode yang ada di <strong>Tiket Fisik
                                        (Gelang/Kertas)</strong>.</p>
                            </div>

                            <form id="scan-physical-form" action="{{ route('admin.sisemar.redemption.process') }}"
                                method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="sisemar_id" value="{{ $sisemar->id }}">

                                <div>
                                    <input type="text" name="physical_ticket_code" id="physical_ticket_code"
                                        class="w-full text-center text-xl font-mono tracking-widest border-2 border-green-500 rounded-lg p-3 focus:ring-4 focus:ring-green-200 uppercase bg-white"
                                        placeholder="ATAU TIKET FISIK DI SINI..." autofocus autocomplete="off" required>
                                </div>

                                <button type="submit"
                                    class="w-full bg-green-600 text-white font-bold py-3 rounded-lg hover:bg-green-700 transition shadow-lg">
                                    <i class="fas fa-save mr-2"></i> SIMPAN & SELESAI
                                </button>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    {{-- Auto-check script for barcode scanners --}}
    <script>
        // Simple heuristic: if scanned quickly (length > 5 in <100ms), auto submit? 
        // Or just rely on standard Enter key sent by scanner. Most scanners send Enter.
        document.addEventListener("DOMContentLoaded", function () {
            const input = document.getElementById("e_ticket_code") || document.getElementById("physical_ticket_code");
            if (input) {
                input.focus();
                // Prevent losing focus
                document.addEventListener('click', function (e) {
                    // Hanya focus balik jika tidak sedang mengklik tombol atau link
                    if (!e.target.closest('button') && !e.target.closest('a')) {
                        input.focus();
                    }
                });
            }
        });

        // --- Camera Scanner Logic ---
        let html5QrcodeScanner = null;
        let currentScanType = 'email'; // 'email' or 'physical'
        const beepSound = new Audio('https://www.soundjay.com/button/beep-07.wav');

        function startScanner(type = 'email') {
            currentScanType = type;
            const containerId = type === 'email' ? 'reader-container' : 'reader-container-physical';
            const readerId = type === 'email' ? 'reader' : 'reader-physical';

            document.getElementById(containerId).classList.remove('hidden');

            // Inisialisasi Scanner
            if (!html5QrcodeScanner) {
                html5QrcodeScanner = new Html5QrcodeScanner(
                    readerId,
                    { fps: 10, qrbox: { width: 250, height: 250 } },
                    /* verbose= */ false
                );
            }
            // Render di elemen yang sesuai (harus clear dulu jika pindah elemen, tapi library ini agak tricky kalau reuse instance di beda div)
            // Cara aman: jika elemen beda, mungkin create new instance atau pastikan clear selesai.
            // Untuk simplifikasi, kita asumsikan user tidak buka dua-duanya sekaligus (karena step by step).
            // Tapi karena div-nya beda, kita perlu hati-hati. Lebih aman destroy instance lama.

            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        }

        function stopScanner(type = 'email') {
            const containerId = type === 'email' ? 'reader-container' : 'reader-container-physical';

            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear().then(_ => {
                    document.getElementById(containerId).classList.add('hidden');
                }).catch(error => {
                    console.error("Failed to clear html5QrcodeScanner. ", error);
                    document.getElementById(containerId).classList.add('hidden');
                });
            } else {
                document.getElementById(containerId).classList.add('hidden');
            }
        }

        function onScanSuccess(decodedText, decodedResult) {
            // Mainkan suara beep
            beepSound.play();

            let inputId = '';
            let formId = '';

            if (currentScanType === 'email') {
                inputId = 'e_ticket_code';
                formId = 'scan-form';
            } else {
                inputId = 'physical_ticket_code';
                formId = 'scan-physical-form';
            }

            // Isi input field
            const input = document.getElementById(inputId);
            if (input) {
                input.value = decodedText;

                // Submit form otomatis
                const form = document.getElementById(formId);
                if (form) form.submit();

                // Stop scanner setelah sukses scan
                stopScanner(currentScanType);
            }
        }

        function onScanFailure(error) {
            // handle error if needed, usually ignore
        }
    </script>
</x-app-layout>