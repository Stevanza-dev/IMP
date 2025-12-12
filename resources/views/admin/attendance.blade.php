<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Rekap Absensi Peserta') }}
            </h2>
            <a href="{{ route('admin.attendance') }}" class="text-sm text-blue-600 hover:underline">
                <i class="fas fa-sync"></i> Refresh Data
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 text-sm font-medium">TOTAL TIKET TERJUAL</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $totalPeserta }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-green-600 text-sm font-bold">SUDAH HADIR (CHECK-IN)</div>
                    <div class="text-3xl font-bold text-green-700">{{ $sudahHadir }}</div>
                    <div class="text-xs text-gray-400 mt-1">
                        {{ $totalPeserta > 0 ? round(($sudahHadir / $totalPeserta) * 100) : 0 }}% Kehadiran
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-gray-300">
                    <div class="text-gray-500 text-sm font-medium">BELUM DATANG</div>
                    <div class="text-3xl font-bold text-gray-400">{{ $belumHadir }}</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Kehadiran Real-time</h3>
                    
                    {{-- Mobile: stacked attendee cards --}}
                    <div class="md:hidden space-y-4">
                        @foreach ($attendees as $guest)
                        <div class="bg-white p-4 rounded-lg shadow-sm border {{ $guest->checked_in_at ? 'border-green-200' : '' }}">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $guest->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $guest->institution }}</div>
                                </div>
                                <div class="text-right">
                                    @if($guest->checked_in_at)
                                        <div class="text-sm font-bold text-green-700">{{ $guest->checked_in_at->format('H:i') }} WIB</div>
                                        <div class="text-xs text-green-600">✅ HADIR</div>
                                    @else
                                        <div class="text-sm text-gray-400">-</div>
                                        <div class="text-xs text-gray-500">Belum Hadir</div>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-3 flex items-center justify-between">
                                <div class="text-xs text-gray-600 font-mono">{{ $guest->ticket_code }}</div>
                                <div class="text-xs text-gray-400">&nbsp;</div>
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
                                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Kode Tiket</th>
                                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($attendees as $guest)
                                <tr class="{{ $guest->checked_in_at ? 'bg-green-50' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($guest->checked_in_at)
                                            <span class="text-green-700 font-bold">
                                                {{ $guest->checked_in_at->format('H:i') }} WIB
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">{{ $guest->name }}</div>
                                        <div class="text-gray-500 text-xs">{{ $guest->institution }}</div>
                                    </td>

                                    <td class="px-6 py-4 font-mono text-gray-600">
                                        {{ $guest->ticket_code }}
                                    </td>

                                    <td class="px-6 py-4">
                                        @if($guest->checked_in_at)
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                ✅ HADIR
                                            </span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-500">
                                                Belum Hadir
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($attendees->isEmpty())
                        <div class="text-center py-10 text-gray-500">
                            Belum ada peserta yang terdaftar.
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>