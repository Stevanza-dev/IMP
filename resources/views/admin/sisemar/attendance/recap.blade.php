<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Rekap Kehadiran SI SEMAR') }}
            </h2>
            <a href="{{ route('admin.sisemar.attendance.recap') }}" class="text-sm text-blue-600 hover:underline">
                <i class="fas fa-sync"></i> Refresh Data
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 text-sm font-medium">TOTAL PESERTA</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $stats['total'] }}</div>
                    <div class="text-xs text-gray-400 mt-1">Terkonfirmasi</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-green-600 text-sm font-bold">SUDAH HADIR</div>
                    <div class="text-3xl font-bold text-green-700">{{ $stats['checked_in'] }}</div>
                    <div class="text-xs text-gray-400 mt-1">
                        {{ $stats['redeemed'] > 0 ? round(($stats['checked_in'] / $stats['redeemed']) * 100) : 0 }}% dari yang punya tiket
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-yellow-600 text-sm font-bold">BELUM HADIR</div>
                    <div class="text-3xl font-bold text-yellow-700">{{ $stats['not_checked_in'] }}</div>
                    <div class="text-xs text-gray-400 mt-1">Punya tiket tapi belum datang</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Kehadiran Real-time</h3>
                    
                    {{-- Mobile: stacked attendee cards --}}
                    <div class="md:hidden space-y-4">
                        @foreach ($attendees as $person)
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-green-200">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">{{ $person->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $person->school }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm font-bold text-green-700">{{ $person->checked_in_at->format('H:i') }} WIB</div>
                                        <div class="text-xs text-green-600">✅ HADIR</div>
                                    </div>
                                </div>

                                <div class="mt-3 flex items-center justify-between">
                                    <div class="text-xs text-gray-600 font-mono">{{ $person->physical_ticket_code }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Desktop: table view (md+) --}}
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Waktu Masuk</th>
                                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Nama Peserta</th>
                                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Kode Tiket Fisik</th>
                                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($attendees as $person)
                                    <tr class="bg-green-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-green-700 font-bold">
                                                {{ $person->checked_in_at->format('H:i') }} WIB
                                            </span>
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="font-medium text-gray-900">{{ $person->name }}</div>
                                            <div class="text-gray-500 text-xs">{{ $person->school }}</div>
                                        </td>

                                        <td class="px-6 py-4 font-mono text-gray-600">
                                            {{ $person->physical_ticket_code }}
                                        </td>

                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                ✅ HADIR
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($attendees->isEmpty())
                        <div class="text-center py-10 text-gray-500">
                            Belum ada peserta yang masuk.
                        </div>
                    @endif

                </div>
            </div>

            <!-- Daftar Peserta Belum Hadir -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-8">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Peserta Belum Hadir</h3>
                    </div>

                    {{-- Mobile: stacked cards --}}
                    <div class="md:hidden space-y-4">
                        @foreach ($notCheckedIn as $person)
                            <div class="bg-yellow-50 p-4 rounded-lg shadow-sm border border-yellow-200">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">{{ $person->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $person->school }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xs text-yellow-600 font-semibold">⏳ BELUM HADIR</div>
                                    </div>
                                </div>

                                <div class="mt-3 flex items-center justify-between">
                                    <div class="text-xs text-gray-600 font-mono">{{ $person->physical_ticket_code }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Desktop: table view --}}
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">No</th>
                                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Nama Peserta</th>
                                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Asal Sekolah</th>
                                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Kode Tiket Fisik</th>
                                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($notCheckedIn as $index => $person)
                                    <tr class="bg-yellow-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                            {{ $index + 1 }}
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="font-medium text-gray-900">{{ $person->name }}</div>
                                            <div class="text-gray-500 text-xs">{{ $person->email }}</div>
                                        </td>

                                        <td class="px-6 py-4 text-gray-600">
                                            {{ $person->school }}
                                        </td>

                                        <td class="px-6 py-4 font-mono text-gray-700">
                                            {{ $person->physical_ticket_code }}
                                        </td>

                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                ⏳ BELUM HADIR
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($notCheckedIn->isEmpty())
                        <div class="text-center py-10 text-gray-500">
                            🎉 Semua peserta yang sudah punya tiket fisik telah hadir!
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
