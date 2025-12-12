<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Rapat & Absensi') }}
            </h2>
            <a href="{{ route('meetings.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-bold flex items-center gap-2">
                <i class="fas fa-plus"></i> Buat Rapat Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if($meetings->isEmpty())
                        <div class="text-center py-10">
                            <div class="mb-4 text-gray-300 text-6xl">
                                <i class="fas fa-calendar-times"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Belum ada rapat yang dibuat</h3>
                            <p class="text-gray-500 mb-6">Silakan buat jadwal rapat baru untuk mulai menggunakan sistem absensi.</p>
                            <a href="{{ route('meetings.create') }}" class="text-blue-600 hover:underline font-bold">Buat Rapat Sekarang &rarr;</a>
                        </div>
                    @else
                        {{-- Mobile: stacked meeting cards --}}
                        <div class="md:hidden space-y-4">
                            @foreach($meetings as $meeting)
                            <div class="bg-white p-4 rounded-lg shadow-sm border">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">{{ $meeting->title }}</div>
                                        <div class="text-xs text-gray-500">Token: {{ substr($meeting->token, 0, 8) }}...</div>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $meeting->attendances->count() }} Hadir
                                    </span>
                                </div>

                                <div class="mt-3 text-sm text-gray-700 space-y-1">
                                    <div><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($meeting->date)->translatedFormat('d F Y') }}</div>
                                    <div class="text-xs text-gray-500">Dibuat: {{ $meeting->created_at->diffForHumans() }}</div>
                                </div>

                                <div class="mt-3 flex items-center justify-between gap-2">
                                    <a href="https://www.google.com/maps?q={{ $meeting->latitude }},{{ $meeting->longitude }}" target="_blank" class="text-blue-600 hover:underline text-sm flex items-center gap-1">
                                        <i class="fas fa-map-marker-alt"></i> Cek Peta
                                    </a>
                                </div>

                                <div class="mt-3 flex gap-2">
                                    <a href="{{ route('meetings.show', $meeting->id) }}" class="text-white bg-blue-500 hover:bg-blue-600 px-3 py-1.5 rounded text-xs flex items-center gap-1 flex-1 justify-center">
                                        <i class="fas fa-qrcode"></i> QR
                                    </a>

                                    <a href="{{ route('meetings.recap', $meeting->id) }}" class="text-white bg-purple-500 hover:bg-purple-600 px-3 py-1.5 rounded text-xs flex items-center gap-1 flex-1 justify-center">
                                        <i class="fas fa-file-alt"></i> Rekap
                                    </a>

                                    <form action="{{ route('meetings.destroy', $meeting->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data rapat ini? Seluruh data absensi peserta di rapat ini juga akan terhapus.');" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full text-white bg-red-500 hover:bg-red-600 px-3 py-1.5 rounded text-xs flex items-center gap-1 justify-center">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        {{-- Desktop: table view (md+) --}}
                        <div class="hidden md:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Rapat</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu & Tanggal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi Pusat</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kehadiran</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($meetings as $meeting)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900">{{ $meeting->title }}</div>
                                            <div class="text-xs text-gray-500">Token: {{ substr($meeting->token, 0, 8) }}...</div>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center text-sm text-gray-900">
                                                <i class="far fa-calendar-alt mr-2 text-blue-500"></i>
                                                {{ \Carbon\Carbon::parse($meeting->date)->translatedFormat('d F Y') }}
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                Dibuat: {{ $meeting->created_at->diffForHumans() }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <a href="https://www.google.com/maps?q={{ $meeting->latitude }},{{ $meeting->longitude }}" target="_blank" class="text-blue-600 hover:underline flex items-center gap-1">
                                                <i class="fas fa-map-marker-alt"></i> Cek Peta
                                            </a>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ $meeting->attendances->count() }} Hadir
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex justify-center space-x-2">
                                                <a href="{{ route('meetings.show', $meeting->id) }}" class="text-white bg-blue-500 hover:bg-blue-600 px-3 py-1.5 rounded text-xs flex items-center gap-1" title="Tampilkan QR Code">
                                                    <i class="fas fa-qrcode"></i> QR
                                                </a>

                                                <a href="{{ route('meetings.recap', $meeting->id) }}" class="text-white bg-purple-500 hover:bg-purple-600 px-3 py-1.5 rounded text-xs flex items-center gap-1" title="Lihat Laporan Absensi">
                                                    <i class="fas fa-file-alt"></i> Rekap
                                                </a>

                                                <form action="{{ route('meetings.destroy', $meeting->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data rapat ini? Seluruh data absensi peserta di rapat ini juga akan terhapus.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-white bg-red-500 hover:bg-red-600 px-3 py-1.5 rounded text-xs flex items-center gap-1" title="Hapus Rapat">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            {{ $meetings->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>