<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Status Penukaran Tiket Si Semar') }}
        </h2>
    </x-slot>

    <div class="py-6 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-6">
                <!-- Total Peserta Terkonfirmasi -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 md:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-2 md:p-3">
                                <svg class="h-5 w-5 md:h-6 md:w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-3 md:ml-4">
                                <p class="text-xs md:text-sm font-medium text-gray-500">Total Terkonfirmasi</p>
                                <p class="text-xl md:text-2xl font-semibold text-gray-900">{{ $stats['total_confirmed'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sudah Ditukar -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 md:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-2 md:p-3">
                                <svg class="h-5 w-5 md:h-6 md:w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-3 md:ml-4">
                                <p class="text-xs md:text-sm font-medium text-gray-500">Sudah Ditukar</p>
                                <p class="text-xl md:text-2xl font-semibold text-gray-900">{{ $stats['redeemed'] }}</p>
                                <p class="text-xs text-gray-500">{{ $stats['redeemed_percentage'] }}%</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Belum Ditukar -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 md:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-2 md:p-3">
                                <svg class="h-5 w-5 md:h-6 md:w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3 md:ml-4">
                                <p class="text-xs md:text-sm font-medium text-gray-500">Menunggu Penukaran</p>
                                <p class="text-xl md:text-2xl font-semibold text-gray-900">{{ $stats['pending_redemption'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Data Peserta -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 md:p-6">
                    <h3 class="text-base md:text-lg font-medium text-gray-900 mb-4">Daftar Peserta</h3>

                    {{-- Mobile: Card Layout --}}
                    <div class="md:hidden space-y-4">
                        @forelse($participants as $index => $participant)
                            <div class="participant-row bg-white p-4 rounded-lg shadow-sm border {{ $participant->hasRedeemedTicket() ? 'border-green-200 bg-green-50' : 'border-yellow-200 bg-yellow-50' }}"
                                data-status="{{ $participant->hasRedeemedTicket() ? 'redeemed' : 'pending' }}">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex-1">
                                        <div class="text-sm font-semibold text-gray-900">{{ $index + 1 }}. {{ $participant->name }}</div>
                                        <div class="text-xs text-gray-500 mt-1">{{ $participant->school }}</div>
                                    </div>
                                    <div>
                                        @if ($participant->hasRedeemedTicket())
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                ✓ Sudah Ditukar
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                ⏳ Menunggu
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-500">E-Ticket:</span>
                                        @if ($participant->e_ticket_code)
                                            <span class="px-2 py-1 text-xs font-mono font-semibold rounded bg-green-100 text-green-800">
                                                {{ $participant->e_ticket_code }}
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400">-</span>
                                        @endif
                                    </div>

                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-500">Tiket Fisik:</span>
                                        @if ($participant->physical_ticket_code)
                                            <span class="px-2 py-1 text-xs font-mono font-semibold rounded bg-purple-100 text-purple-800">
                                                {{ $participant->physical_ticket_code }}
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400">Belum</span>
                                        @endif
                                    </div>

                                    @if ($participant->ticket_redeemed_at)
                                        <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                                            <span class="text-xs text-gray-500">Waktu Penukaran:</span>
                                            <span class="text-xs text-gray-700">{{ $participant->ticket_redeemed_at->format('d M Y H:i') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 text-gray-500">
                                Belum ada peserta terkonfirmasi
                            </div>
                        @endforelse
                    </div>

                    {{-- Desktop: Table View --}}
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200" id="participantsTable">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        E-Ticket</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tiket Fisik</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Waktu Penukaran</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($participants as $index => $participant)
                                    <tr class="participant-row" data-status="{{ $participant->hasRedeemedTicket() ? 'redeemed' : 'pending' }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $participant->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $participant->school }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($participant->e_ticket_code)
                                                <span
                                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ $participant->e_ticket_code }}
                                                </span>
                                            @else
                                                <span class="text-sm text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($participant->physical_ticket_code)
                                                <span
                                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                                    {{ $participant->physical_ticket_code }}
                                                </span>
                                            @else
                                                <span class="text-sm text-gray-400">Belum</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($participant->hasRedeemedTicket())
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    ✓ Sudah Ditukar
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    ⏳ Menunggu
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $participant->ticket_redeemed_at ? $participant->ticket_redeemed_at->format('d M Y H:i') : '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Belum ada peserta terkonfirmasi
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
