<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pendaftaran AMPERA 2026') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Filter & Search -->
                    <form method="GET" action="{{ route('admin.ampera.dashboard') }}"
                        class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
                        <div class="flex items-center space-x-2">
                            <select name="filter" class="rounded border-gray-200 px-3 py-2 text-sm">
                                <option value="" {{ empty($filter) ? 'selected' : '' }}>Semua</option>
                                <option value="confirmed" {{ (isset($filter) && $filter === 'confirmed') ? 'selected' : '' }}>Sudah Dikonfirmasi</option>
                                <option value="pending" {{ (isset($filter) && $filter === 'pending') ? 'selected' : '' }}>
                                    Belum Dikonfirmasi</option>
                            </select>
                            <button type="submit"
                                class="bg-emerald-600 text-white px-3 py-2 rounded text-sm">Filter</button>
                        </div>

                        <div class="flex items-center space-x-2">
                            <input type="search" name="q" value="{{ $q ?? '' }}" placeholder="Cari nama..."
                                class="rounded border-gray-200 px-3 py-2 text-sm" />
                            <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded text-sm">Cari</button>
                        </div>
                    </form>

                    <!-- Statistics -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                        <div class="bg-white p-4 rounded-lg shadow-sm border flex items-center justify-between">
                            <div>
                                <div class="text-xs text-gray-500 uppercase font-semibold">Total Pendaftar</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $totalCount ?? 0 }}</div>
                            </div>
                            <div class="text-3xl text-emerald-600">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-lg shadow-sm border flex items-center justify-between">
                            <div>
                                <div class="text-xs text-gray-500 uppercase font-semibold">Sudah Dikonfirmasi</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $confirmedCount ?? 0 }}</div>
                            </div>
                            <div class="text-3xl text-green-600">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-lg shadow-sm border flex items-center justify-between">
                            <div>
                                <div class="text-xs text-gray-500 uppercase font-semibold">Belum Dikonfirmasi</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $pendingCount ?? 0 }}</div>
                            </div>
                            <div class="text-3xl text-yellow-600">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Mobile: stacked cards --}}
                    <div class="md:hidden space-y-4">
                        @foreach ($registrations as $reg)
                            <div class="bg-white p-4 rounded-lg shadow-sm border">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">{{ $reg->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $reg->institution }}</div>
                                    </div>
                                    <div class="text-right">
                                        @if($reg->status == 'pending')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                        @elseif($reg->status == 'confirmed')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Confirmed</span>
                                        @else
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-3 text-sm text-gray-700">
                                    <div><strong>Email:</strong> {{ $reg->email }}</div>
                                    <div class="mt-1"><strong>Phone:</strong> {{ $reg->phone }}</div>
                                    <div class="mt-1 text-xs text-gray-500 truncate" title="{{ $reg->address }}">
                                        {{ Str::limit($reg->address, 80) }}</div>
                                </div>

                                <div class="mt-3 flex items-center justify-between">
                                    <div class="text-sm">
                                        <img src="{{ $reg->payment_url ?? '' }}" data-full="{{ $reg->payment_url ?? '' }}"
                                            alt="Bukti Pembayaran"
                                            class="w-16 h-16 object-cover rounded cursor-pointer border"
                                            onclick="openImageModal(this.dataset.full)">
                                        <div class="text-xs text-gray-500 mt-1">{{ $reg->payment_method }}</div>
                                    </div>

                                    <div class="flex items-center space-x-2">
                                        @if($reg->status == 'pending')
                                            <form action="{{ route('admin.approve', $reg->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin validasi data ini?');">
                                                @csrf @method('PATCH')
                                                <button type="submit"
                                                    class="text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded text-sm"
                                                    title="Terima">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.reject', $reg->id) }}" method="POST"
                                                onsubmit="return confirm('Tolak pendaftaran ini?');">
                                                @csrf @method('PATCH')
                                                <button type="submit"
                                                    class="text-white bg-yellow-500 hover:bg-yellow-600 px-3 py-1 rounded text-sm"
                                                    title="Tolak">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>

                                            <a href="{{ route('admin.edit', $reg->id) }}"
                                                class="text-white bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded text-sm"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @elseif($reg->status == 'confirmed')
                                            <form action="{{ route('admin.resend', $reg->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="text-blue-600 hover:text-blue-800 text-sm font-bold underline">
                                                    <i class="fas fa-envelope"></i>
                                                </button>
                                            </form>
                                            <a href="{{ route('admin.edit', $reg->id) }}"
                                                class="text-gray-500 hover:text-gray-700 text-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @else
                                            <span class="text-red-500 text-sm">Ditolak</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-3 border-t pt-2">
                                    <form action="{{ route('admin.destroy', $reg->id) }}" method="POST"
                                        onsubmit="return confirm('PERINGATAN: Data akan dihapus permanen dan tidak bisa dikembalikan. Lanjutkan?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-500 hover:text-red-700 text-sm flex items-center gap-2">
                                            <i class="fas fa-trash"></i> Hapus Data
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
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama & Instansi</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kontak</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Bukti Bayar</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($registrations as $reg)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $reg->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $reg->institution }}</div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $reg->email }}</div>
                                            <div class="text-sm text-gray-500">{{ $reg->phone }}</div>
                                            <div class="text-xs text-gray-400 mt-1 truncate w-32"
                                                title="{{ $reg->address }}">
                                                {{ Str::limit($reg->address, 30) }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <img src="{{ $reg->payment_url ?? '' }}"
                                                data-full="{{ $reg->payment_url ?? '' }}" alt="Bukti Pembayaran"
                                                class="w-20 h-20 object-cover rounded cursor-pointer border"
                                                onclick="openImageModal(this.dataset.full)">
                                            <div class="text-xs text-gray-500 mt-2">{{ $reg->payment_method }}</div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($reg->status == 'pending')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                            @elseif($reg->status == 'confirmed')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Confirmed</span>
                                                <div class="text-xs text-gray-500 mt-1">{{ $reg->ticket_code }}</div>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex flex-col space-y-2">

                                                @if($reg->status == 'pending')
                                                    <div class="flex space-x-2">
                                                        <form action="{{ route('admin.approve', $reg->id) }}" method="POST"
                                                            onsubmit="return confirm('Yakin validasi data ini?');">
                                                            @csrf @method('PATCH')
                                                            <button type="submit"
                                                                class="text-white bg-green-600 hover:bg-green-700 px-2 py-1 rounded text-xs"
                                                                title="Terima">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>

                                                        <form action="{{ route('admin.reject', $reg->id) }}" method="POST"
                                                            onsubmit="return confirm('Tolak pendaftaran ini?');">
                                                            @csrf @method('PATCH')
                                                            <button type="submit"
                                                                class="text-white bg-yellow-500 hover:bg-yellow-600 px-2 py-1 rounded text-xs"
                                                                title="Tolak">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>

                                                        <a href="{{ route('admin.edit', $reg->id) }}"
                                                            class="text-white bg-blue-500 hover:bg-blue-600 px-2 py-1 rounded text-xs"
                                                            title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    </div>

                                                @elseif($reg->status == 'confirmed')
                                                    <form action="{{ route('admin.resend', $reg->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                            class="text-blue-600 hover:text-blue-800 text-xs font-bold underline">
                                                            <i class="fas fa-envelope"></i> Kirim Ulang Email
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('admin.edit', $reg->id) }}"
                                                        class="text-gray-500 hover:text-gray-700 text-xs block">
                                                        <i class="fas fa-edit"></i> Edit Data
                                                    </a>

                                                @else
                                                    <span class="text-red-500 text-xs">Ditolak</span>
                                                @endif

                                                <div class="border-t border-gray-100 pt-1 mt-1">
                                                    <form action="{{ route('admin.destroy', $reg->id) }}" method="POST"
                                                        onsubmit="return confirm('PERINGATAN: Data akan dihapus permanen dan tidak bisa dikembalikan. Lanjutkan?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-500 hover:text-red-700 text-xs flex items-center gap-1">
                                                            <i class="fas fa-trash"></i> Hapus Data
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $registrations->links() }}
                    </div>

                    <!-- Image modal (opens in-page) -->
                    <div id="image-modal"
                        class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 hidden z-50">
                        <div class="max-w-3xl w-full">
                            <div class="flex justify-end mb-2">
                                <button onclick="closeImageModal()"
                                    class="text-white bg-gray-800 bg-opacity-30 hover:bg-opacity-50 px-3 py-1 rounded">Tutup</button>
                            </div>
                            <img id="image-modal-img" src="" alt="Bukti Pembayaran"
                                class="w-full h-auto rounded shadow-lg" />
                        </div>
                    </div>

                    <script>
                        function openImageModal(src) {
                            var modal = document.getElementById('image-modal');
                            var img = document.getElementById('image-modal-img');
                            img.src = src;
                            modal.classList.remove('hidden');
                        }
                        function closeImageModal() {
                            var modal = document.getElementById('image-modal');
                            var img = document.getElementById('image-modal-img');
                            img.src = '';
                            modal.classList.add('hidden');
                        }
                        // close modal on ESC
                        document.addEventListener('keydown', function (e) {
                            if (e.key === 'Escape') closeImageModal();
                        });
                        // close when clicking outside image
                        document.getElementById('image-modal')?.addEventListener('click', function (e) {
                            if (e.target.id === 'image-modal') closeImageModal();
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>