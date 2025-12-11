<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Scan Tiket Hari H') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div id="reader" width="600px" class="bg-gray-100 rounded-lg overflow-hidden border-2 border-dashed border-gray-300"></div>

                <div id="result-container" class="mt-6 hidden text-center p-4 rounded-lg">
                    <h3 id="result-title" class="text-2xl font-bold mb-2"></h3>
                    <p id="result-message" class="text-lg"></p>
                </div>

                <button id="btn-reset" onclick="resetScanner()" class="hidden w-full mt-4 bg-gray-600 text-white py-3 rounded-lg font-bold">
                    SCAN BERIKUTNYA
                </button>

            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    
    <script>
        const csrfToken = "{{ csrf_token() }}";
        const verifyUrl = "{{ route('admin.scan.verify') }}";
        let html5QrcodeScanner;
        
        // Suara Beep saat scan berhasil
        const beepSound = new Audio('https://www.soundjay.com/button/beep-07.wav'); 

        function onScanSuccess(decodedText, decodedResult) {
            // Stop scanning sementara agar tidak double request
            html5QrcodeScanner.clear();
            
            // Mainkan suara beep
            beepSound.play();

            // Tampilkan Loading
            showResult('loading', 'Memeriksa data...', 'gray');

            // Kirim ke Backend Laravel via Fetch API
            fetch(verifyUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ code: decodedText })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showResult('success', data.message, 'green');
                } else if (data.status === 'warning') {
                    showResult('warning', data.message, 'yellow');
                } else {
                    showResult('error', data.message, 'red');
                }
            })
            .catch(error => {
                showResult('error', 'Terjadi kesalahan sistem!', 'red');
                console.error('Error:', error);
            });
        }

        function onScanFailure(error) {
            // Biarkan saja, ini trigger terus menerus kalau tidak ada QR
        }

        // Fungsi Menampilkan Hasil Visual
        function showResult(type, message, color) {
            const container = document.getElementById('result-container');
            const title = document.getElementById('result-title');
            const msg = document.getElementById('result-message');
            const btn = document.getElementById('btn-reset');

            container.classList.remove('hidden', 'bg-green-100', 'text-green-800', 'bg-red-100', 'text-red-800', 'bg-yellow-100', 'text-yellow-800', 'bg-gray-100');
            
            // Set Warna sesuai status
            if(color === 'green') {
                container.classList.add('bg-green-100', 'text-green-800');
                title.innerText = "✅ SUKSES";
            } else if (color === 'red') {
                container.classList.add('bg-red-100', 'text-red-800');
                title.innerText = "❌ GAGAL";
            } else if (color === 'yellow') {
                container.classList.add('bg-yellow-100', 'text-yellow-800');
                title.innerText = "⚠️ PERINGATAN";
            } else {
                container.classList.add('bg-gray-100');
                title.innerText = "⏳ Loading...";
            }

            msg.innerText = message;
            container.classList.remove('hidden');
            
            // Tampilkan tombol reset agar bisa scan lagi
            if(type !== 'loading') {
                btn.classList.remove('hidden');
            }
        }

        // Fungsi Reset Scanner untuk peserta berikutnya
        function resetScanner() {
            document.getElementById('result-container').classList.add('hidden');
            document.getElementById('btn-reset').classList.add('hidden');
            
            // Mulai ulang kamera
            initScanner();
        }

        function initScanner() {
            html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", 
                { fps: 10, qrbox: {width: 250, height: 250} },
                /* verbose= */ false
            );
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        }

        // Jalankan saat halaman load
        document.addEventListener('DOMContentLoaded', initScanner);

    </script>
</x-app-layout>