<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('QR Code Absensi') }}
            </h2>
            <a href="{{ route('meetings.index') }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-800 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-white p-6 sm:p-10 rounded-2xl shadow-2xl">
                <div class="text-center">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">{{ $meeting->title }}</h1>
                    <p class="text-gray-500 mb-6">{{ \Carbon\Carbon::parse($meeting->date)->translatedFormat('l, d F Y') }}</p>

                    <div class="flex justify-center mb-6">
                        <div class="border-4 border-gray-900 p-4 rounded-xl inline-block">
                            {!! QrCode::size(250)->generate($attendanceUrl) !!}
                        </div>
                    </div>

                    <p class="text-lg font-semibold text-blue-600 mb-2">Scan untuk Presensi</p>
                    <p class="text-sm text-gray-400">Pastikan Anda berada dalam radius 20 meter dari lokasi rapat.</p>
                    
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <p class="text-xs text-gray-500 mb-3">Link Absensi:</p>
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 px-2 sm:px-0">
                            <input type="text" id="attendance-link" value="{{ $attendanceUrl }}" readonly class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-xs sm:text-sm bg-gray-50 text-gray-700 truncate">
                            <button onclick="copyAttendanceLink()" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center justify-center gap-2">
                                <i class="fas fa-copy"></i> Salin
                            </button>
                        </div>
                        <div id="copy-message" class="hidden mt-2 text-green-600 text-xs font-medium">
                            ✓ Link berhasil disalin ke clipboard
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function copyAttendanceLink() {
            const linkInput = document.getElementById('attendance-link');
            const copyMessage = document.getElementById('copy-message');
            
            linkInput.select();
            linkInput.setSelectionRange(0, 99999);
            
            navigator.clipboard.writeText(linkInput.value).then(() => {
                copyMessage.classList.remove('hidden');
                setTimeout(() => {
                    copyMessage.classList.add('hidden');
                }, 3000);
            }).catch(() => {
                alert('Gagal menyalin link. Coba lagi.');
            });
        }
    </script>
</x-app-layout>