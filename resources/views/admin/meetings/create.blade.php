<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Jadwal Rapat Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('meetings.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Judul Rapat</label>
                        <input type="text" name="title" placeholder="Contoh: Rapat Pleno 1" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg text-center">
                        <p class="text-sm text-blue-800 mb-2">Pastikan Anda berada di lokasi rapat sekarang.</p>
                        
                        <button type="button" onclick="getLocation()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 font-bold flex items-center justify-center mx-auto gap-2">
                            📍 Ambil Titik Lokasi Saya
                        </button>

                        <div id="location-status" class="mt-3 text-sm text-gray-500 italic">Menunggu input lokasi...</div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="text-xs text-gray-400">Latitude</label>
                            <input type="text" name="latitude" id="latitude" class="w-full bg-gray-100 text-xs" readonly required>
                        </div>
                        <div>
                            <label class="text-xs text-gray-400">Longitude</label>
                            <input type="text" name="longitude" id="longitude" class="w-full bg-gray-100 text-xs" readonly required>
                        </div>
                    </div>

                    <button type="submit" id="btn-submit" class="w-full bg-gray-800 text-white py-3 rounded-lg font-bold opacity-50 cursor-not-allowed" disabled>
                        BUAT RAPAT & GENERATE QR
                    </button>
                </form>

            </div>
        </div>
    </div>

    <script>
        function getLocation() {
            const status = document.getElementById('location-status');
            
            if (!navigator.geolocation) {
                status.innerHTML = "Browser Anda tidak mendukung Geolocation.";
                return;
            }

            status.innerHTML = "⏳ Sedang mengambil koordinat...";

            navigator.geolocation.getCurrentPosition(success, error, {
                enableHighAccuracy: true // Pakai mode GPS akurat
            });
        }

        function success(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            // Isi ke input form
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            // Update status visual
            document.getElementById('location-status').innerHTML = 
                `✅ Lokasi Terkunci: ${lat}, ${lng} (Akurasi: ${Math.round(position.coords.accuracy)}m)`;
            
            // Aktifkan tombol submit
            const btn = document.getElementById('btn-submit');
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
            btn.classList.add('hover:bg-gray-700');
        }

        function error() {
            document.getElementById('location-status').innerHTML = "❌ Gagal mengambil lokasi. Pastikan GPS aktif dan Izinkan akses browser.";
        }
    </script>
</x-app-layout>