<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('QR Code Absensi') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-800 min-h-screen"> <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 text-center">
            
            <div class="bg-white p-10 rounded-2xl shadow-2xl inline-block">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $meeting->title }}</h1>
                <p class="text-gray-500 mb-6">{{ \Carbon\Carbon::parse($meeting->date)->translatedFormat('l, d F Y') }}</p>

                <div class="border-4 border-gray-900 p-4 rounded-xl inline-block mb-6">
                    {!! QrCode::size(300)->generate($attendanceUrl) !!}
                </div>

                <p class="text-lg font-semibold text-blue-600 mb-2">Scan untuk Presensi</p>
                <p class="text-sm text-gray-400">Pastikan Anda berada dalam radius 20 meter dari lokasi rapat.</p>
                
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <p class="text-xs text-gray-400">Link Absensi: {{ $attendanceUrl }}</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>