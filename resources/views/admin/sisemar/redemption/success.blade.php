<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Penukaran Berhasil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 text-center bg-white p-12 rounded-lg shadow-lg">

            <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-check text-5xl text-green-600"></i>
            </div>

            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">SUKSES!</h1>
            <p class="text-lg text-gray-600 mb-8">Tiket fisik berhasil tercatat untuk:</p>

            <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 mb-8 max-w-md mx-auto">
                <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $sisemar->name }}</h3>
                <p class="text-gray-500 mb-4">{{ $sisemar->school }}</p>

                <div class="space-y-2 text-sm text-left px-4">
                    <div class="flex justify-between border-b border-gray-200 pb-2">
                        <span class="text-gray-500">E-Ticket</span>
                        <span class="font-mono font-bold">{{ $sisemar->e_ticket_code }}</span>
                    </div>
                    <div class="flex justify-between pt-2">
                        <span class="text-gray-500">Tiket Fisik</span>
                        <span class="font-mono font-bold text-green-600">{{ $sisemar->physical_ticket_code }}</span>
                    </div>
                </div>
            </div>

            <a href="{{ route('admin.sisemar.redemption.scan') }}"
                class="inline-flex items-center justify-center px-8 py-4 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition transform hover:scale-105 shadow-lg">
                <i class="fas fa-qrcode mr-2"></i> SCAN BERIKUTNYA
            </a>

        </div>
    </div>
</x-app-layout>