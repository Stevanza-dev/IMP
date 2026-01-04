<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Rekap Hasil Rapat') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('meetings.index', $meeting->id) }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded text-sm font-bold">
                    &larr; Kembali
                </a>
                <button onclick="window.print()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-bold flex items-center gap-2">
                    🖨️ Cetak Laporan
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 mb-6">
                <h1 class="text-2xl font-bold text-gray-800">{{ $meeting->title }}</h1>
                <p class="text-gray-500">{{ \Carbon\Carbon::parse($meeting->date)->translatedFormat('l, d F Y') }}</p>
                <div class="mt-4 flex items-center gap-2 text-sm text-gray-500">
                    <span>📍 Pusat Lokasi: {{ $meeting->latitude }}, {{ $meeting->longitude }}</span>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
                <div class="bg-white p-4 rounded shadow border-l-4 border-blue-500">
                    <p class="text-xs text-gray-500 uppercase font-bold">Total</p>
                    <p class="text-2xl font-bold">{{ $totalMembers }}</p>
                </div>
                <div class="bg-white p-4 rounded shadow border-l-4 border-green-500">
                    <p class="text-xs text-gray-500 uppercase font-bold">Hadir</p>
                    <p class="text-2xl font-bold text-green-600">{{ $totalPresent }}</p>
                </div>
                <div class="bg-white p-4 rounded shadow border-l-4 border-yellow-500">
                    <p class="text-xs text-gray-500 uppercase font-bold">Izin</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $totalPermission }}</p>
                </div>
                <div class="bg-white p-4 rounded shadow border-l-4 border-red-500">
                    <p class="text-xs text-gray-500 uppercase font-bold">Alpha</p>
                    <p class="text-2xl font-bold text-red-600">{{ $totalAbsent }}</p>
                </div>
                <div class="bg-white p-4 rounded shadow border-l-4 border-purple-500">
                    <p class="text-xs text-gray-500 uppercase font-bold">Hadir %</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $attendanceRate }}%</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- TABEL HADIR -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="bg-green-50 px-6 py-4 border-b border-green-100 flex justify-between items-center">
                        <h3 class="font-bold text-green-800">✅ HADIR ({{ $totalPresent }})</h3>
                    </div>
                    <div class="overflow-y-auto max-h-[500px]">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-50 sticky top-0">
                                <tr>
                                    <th class="px-4 py-2 text-left">Nama</th>
                                    <th class="px-4 py-2 text-left">Waktu</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($presentMembers as $data)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">
                                            <p class="font-bold text-gray-800">{{ $data->member->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $data->member->division }}</p>
                                            @if(in_array($data->status, ['present_location', 'present']) && !is_null($data->distance_in_meters))
                                                <p class="text-[10px] text-gray-400">Jarak:
                                                    {{ round($data->distance_in_meters) }}m (Hadir Lokasi)</p>
                                            @endif

                                            @if($data->status === 'present_photo' && $data->photo_url)
                                                <div class="mt-1 flex items-center gap-2">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                                        Hadir (Foto)
                                                    </span>
                                                    <a href="{{ $data->photo_url }}" target="_blank" class="block">
                                                        <img src="{{ $data->photo_url }}" alt="Foto Kehadiran"
                                                            class="w-16 h-16 object-cover rounded border border-gray-200 shadow-sm">
                                                    </a>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 font-mono text-green-700">
                                            {{ \Carbon\Carbon::parse($data->check_in_at)->format('H:i') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-4 py-4 text-center text-gray-400">Nihil</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TABEL IZIN -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="bg-yellow-50 px-6 py-4 border-b border-yellow-100 flex justify-between items-center">
                        <h3 class="font-bold text-yellow-800">📩 IZIN ({{ $totalPermission }})</h3>
                    </div>
                    <div class="overflow-y-auto max-h-[500px]">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-50 sticky top-0">
                                <tr>
                                    <th class="px-4 py-2 text-left">Nama</th>
                                    <th class="px-4 py-2 text-left">Alasan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($permissionMembers as $data)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">
                                            <p class="font-bold text-gray-800">{{ $data->member->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $data->member->division }}</p>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-600 italic">
                                            "{{Str::limit($data->notes, 50)}}"
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-4 py-4 text-center text-gray-400">Nihil</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TABEL ALPHA -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="bg-red-50 px-6 py-4 border-b border-red-100 flex justify-between items-center">
                        <h3 class="font-bold text-red-800">❌ ALPHA ({{ $totalAbsent }})</h3>
                    </div>
                    <div class="overflow-y-auto max-h-[500px]">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-50 sticky top-0">
                                <tr>
                                    <th class="px-4 py-2 text-left">Nama</th>
                                    <th class="px-4 py-2 text-left">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($absentMembers as $member)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 font-medium text-gray-700">
                                            {{ $member->name }}
                                            <p class="text-xs text-gray-500">{{ $member->division }}</p>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="px-2 py-1 bg-red-100 text-red-600 rounded text-xs font-bold">Alpha</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-4 py-4 text-center text-green-600 font-bold">Semua Hadir!
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

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .py-12,
            .py-12 * {
                visibility: visible;
            }

            .py-12 {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            button,
            a {
                display: none !important;
            }

            .max-h-\[500px\] {
                max-height: none !important;
                overflow: visible !important;
            }
        }
    </style>
</x-app-layout>