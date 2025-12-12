<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Jadwal Rapat Baru') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('meetings.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Judul Rapat</label>
                        <input type="text" name="title" placeholder="Contoh: Rapat Pleno 1"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Rapat</label>
                        <input type="date" name="date"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition"
                            required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Lokasi Rapat (Titik Pusat)</label>

                        <div id="map" class="w-full h-[400px] rounded-lg border-2 border-gray-300 mb-3 z-0"></div>

                        <div class="flex justify-between items-center bg-blue-50 p-3 rounded-lg border border-blue-100">
                            <div class="text-sm text-blue-800">
                                <i class="fas fa-info-circle mr-1"></i>
                                <span id="location-status">Klik tombol untuk ambil lokasi saat ini, atau geser pin di
                                    peta.</span>
                            </div>
                            <button type="button" onclick="getMyLocation()"
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 font-bold text-sm flex items-center gap-2 transition">
                                <i class="fas fa-location-arrow"></i> Ambil Lokasi Saya
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="text-xs text-gray-500 font-bold uppercase">Latitude</label>
                            <input type="text" name="latitude" id="latitude"
                                class="w-full bg-gray-100 text-sm border-gray-300 rounded" readonly required>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 font-bold uppercase">Longitude</label>
                            <input type="text" name="longitude" id="longitude"
                                class="w-full bg-gray-100 text-sm border-gray-300 rounded" readonly required>
                        </div>
                    </div>

                    <button type="submit" id="btn-submit"
                        class="w-full bg-gray-800 text-white py-3 rounded-lg font-bold hover:bg-gray-700 transition opacity-50 cursor-not-allowed"
                        disabled>
                        SIMPAN & GENERATE QR
                    </button>
                </form>

            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        // 1. Inisialisasi Peta (Default: Alun-alun Pati agar relevan)
        // Koordinat default (bisa diganti sembarang, nanti akan ketimpa saat 'Ambil Lokasi' diklik)
        const defaultLat = -6.7443;
        const defaultLng = 111.0392;

        var map = L.map('map').setView([defaultLat, defaultLng], 13);

        // 2. Tambahkan Tile Layer (Peta Jalan OpenStreetMap)
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // 3. Tambahkan Marker yang BISA DIGESER (Draggable)
        var marker = L.marker([defaultLat, defaultLng], {
            draggable: true
        }).addTo(map);

        // Event: Saat marker digeser manual oleh user
        marker.on('dragend', function (e) {
            var position = marker.getLatLng();
            updateInput(position.lat, position.lng, "📍 Lokasi disesuaikan manual");
        });

        // Event: Saat peta diklik, pindahkan marker ke sana
        map.on('click', function (e) {
            var position = e.latlng;
            marker.setLatLng(position);
            updateInput(position.lat, position.lng, "📍 Lokasi dipilih dari peta");
        });

        // Fungsi Utama: Ambil Lokasi GPS Browser
        function getMyLocation() {
            const status = document.getElementById('location-status');

            if (!navigator.geolocation) {
                status.innerHTML = "❌ Browser tidak mendukung GPS.";
                return;
            }

            status.innerHTML = "⏳ Sedang mencari koordinat...";

            navigator.geolocation.getCurrentPosition(
                // Sukses
                function (position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    // Pindahkan Peta & Marker
                    map.setView([lat, lng], 18); // Zoom diperbesar (18) agar detail
                    marker.setLatLng([lat, lng]);

                    updateInput(lat, lng, `✅ Akurasi GPS: ${Math.round(position.coords.accuracy)} meter. Geser pin jika kurang pas.`);
                },
                // Gagal
                function () {
                    status.innerHTML = "❌ Gagal mengambil lokasi. Pastikan GPS aktif.";
                    alert('Tidak bisa mengakses lokasi. Silakan geser pin di peta secara manual ke lokasi rapat.');
                },
                { enableHighAccuracy: true }
            );
        }

        // Fungsi Update Input Form & UI
        function updateInput(lat, lng, message) {
            document.getElementById('latitude').value = lat.toFixed(7);
            document.getElementById('longitude').value = lng.toFixed(7);
            document.getElementById('location-status').innerHTML = message;

            // Aktifkan tombol submit
            const btn = document.getElementById('btn-submit');
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    </script>
</x-app-layout>