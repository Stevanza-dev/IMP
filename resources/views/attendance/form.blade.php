<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Rapat</title>
    <link rel="icon" href="{{ asset('images/logonocap.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">

    <div class="bg-white w-full max-w-md rounded-2xl shadow-xl overflow-hidden">

        <div class="bg-blue-600 p-6 text-white text-center">
            <h2 class="text-xl font-bold uppercase tracking-wide">{{ $meeting->title }}</h2>
            <p class="text-sm opacity-80 mt-1">{{ \Carbon\Carbon::parse($meeting->date)->translatedFormat('l, d F Y') }}
            </p>
        </div>

        <div class="p-6">

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                    <p class="font-bold">✅ SUKSES!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded">
                    <p class="font-bold">❌ GAGAL!</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @if(!session('success'))
                <form action="{{ route('attendance.store', $meeting->token) }}" method="POST" id="absenForm">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Panitia</label>
                        <select name="member_id" id="member_select"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none"
                            required>
                            <option value="" selected disabled>-- Pilih Nama Anda --</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}" data-division="{{ $member->division }}">
                                    {{ $member->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Sie / Divisi</label>
                        <input type="text" id="division_display"
                            class="w-full bg-gray-100 border border-gray-300 rounded-lg p-3 text-gray-500 cursor-not-allowed"
                            readonly placeholder="Otomatis terisi..." required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Status Kehadiran</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="status" value="present" checked
                                    class="w-5 h-5 text-blue-600 focus:ring-blue-500" onclick="toggleStatus('present')">
                                <span class="text-gray-700 font-medium">Hadir</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="status" value="permission"
                                    class="w-5 h-5 text-blue-600 focus:ring-blue-500" onclick="toggleStatus('permission')">
                                <span class="text-gray-700 font-medium">Izin / Sakit</span>
                            </label>
                        </div>
                    </div>

                    <div id="notes-container" class="mb-4 hidden">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Alasan Izin</label>
                        <textarea name="notes" id="notes" rows="3"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none"
                            placeholder="Tuliskan alasan izin Anda..."></textarea>
                    </div>

                    <div id="location-container"
                        class="mb-6 p-3 bg-blue-50 rounded-lg text-sm text-center border border-blue-200">
                        <p id="location-status" class="text-blue-800 font-semibold animate-pulse">📡 Mencari lokasi Anda...
                        </p>
                    </div>

                    <input type="hidden" name="latitude" id="lat">
                    <input type="hidden" name="longitude" id="lng">

                    <button type="submit" id="btn-submit" disabled
                        class="w-full bg-gray-400 text-white font-bold py-3 rounded-lg shadow transition duration-300 cursor-not-allowed">
                        KIRIM ABSENSI
                    </button>
                </form>
            @endif

        </div>
    </div>

    <script>
        // 1. Auto-fill Divisi saat Nama dipilih
        const memberSelect = document.getElementById('member_select');
        const divisionInput = document.getElementById('division_display');

        memberSelect.addEventListener('change', function () {
            // Ambil data-division dari option yang dipilih
            const selectedOption = memberSelect.options[memberSelect.selectedIndex];
            const division = selectedOption.getAttribute('data-division');

            // Isi ke input divisi
            divisionInput.value = division ? division : '';
        });

        // 2. Logic Status & Lokasi
        const statusTxt = document.getElementById('location-status');
        const latInput = document.getElementById('lat');
        const lngInput = document.getElementById('lng');
        const btnSubmit = document.getElementById('btn-submit');
        const notesContainer = document.getElementById('notes-container');
        const notesInput = document.getElementById('notes');
        const locationContainer = document.getElementById('location-container');

        let isLocationFound = false;

        function toggleStatus(status) {
            if (status === 'present') {
                // Mode Hadir: Wajib Lokasi
                notesContainer.classList.add('hidden');
                notesInput.required = false;

                locationContainer.classList.remove('hidden');

                checkSubmitButton();
            } else {
                // Mode Izin: Skip Lokasi, Wajib Alasan
                notesContainer.classList.remove('hidden');
                notesInput.required = true;

                locationContainer.classList.add('hidden');

                // Selalu enable submit jika izin (asalkan nama dipilih)
                checkSubmitButton();
            }
        }

        function checkSubmitButton() {
            const status = document.querySelector('input[name="status"]:checked').value;

            if (status === 'present') {
                if (isLocationFound) {
                    enableButton();
                } else {
                    disableButton();
                }
            } else {
                // Izin -> Enable button directly (validation handled by HTML 'required' on notes/member select)
                enableButton();
            }
        }

        function enableButton() {
            btnSubmit.disabled = false;
            btnSubmit.classList.remove('bg-gray-400', 'cursor-not-allowed');
            btnSubmit.classList.add('bg-blue-600', 'hover:bg-blue-700');
        }

        function disableButton() {
            btnSubmit.disabled = true;
            btnSubmit.classList.add('bg-gray-400', 'cursor-not-allowed');
            btnSubmit.classList.remove('bg-blue-600', 'hover:bg-blue-700');
        }

        // Ambil Lokasi GPS User (Otomatis saat load)
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                // Jika Sukses
                function (position) {
                    latInput.value = position.coords.latitude;
                    lngInput.value = position.coords.longitude;
                    isLocationFound = true;

                    statusTxt.innerHTML = "✅ Lokasi Ditemukan. Siap Absen.";
                    statusTxt.classList.remove('animate-pulse', 'text-blue-800');
                    statusTxt.classList.add('text-green-700');

                    checkSubmitButton();
                },
                // Jika Gagal/Ditolak
                function (error) {
                    let msg = "Gagal mengambil lokasi.";
                    if (error.code == 1) msg = "❌ Izin Lokasi Ditolak. Mohon Izinkan!";
                    else if (error.code == 2) msg = "❌ GPS Mati / Sinyal Lemah.";

                    statusTxt.innerHTML = msg;
                    statusTxt.classList.add('text-red-600');
                    isLocationFound = false;
                    checkSubmitButton();
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        } else {
            statusTxt.innerHTML = "Browser Anda tidak mendukung GPS.";
            isLocationFound = false;
        }
    </script>
</body>

</html>