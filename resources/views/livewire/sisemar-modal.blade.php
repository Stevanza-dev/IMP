<div>
    {{-- Success/Error Messages --}}
    @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            <p class="font-bold">✅ Berhasil</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <p class="font-bold">❌ Error</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    {{-- Statistik & Filter --}}
    <div class="mb-6 space-y-4">
        {{-- Statistik kartu --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="p-4 bg-white border rounded-lg shadow-sm">
                <p class="text-xs font-semibold text-gray-500 uppercase">Semua Peserta</p>
                <p class="mt-1 text-2xl font-bold text-gray-900">{{ $totalAll ?? 0 }}</p>
            </div>

            <div class="p-4 bg-green-50 border border-green-200 rounded-lg shadow-sm">
                <p class="text-xs font-semibold text-green-700 uppercase">Sudah ACC</p>
                <p class="mt-1 text-2xl font-bold text-green-700">{{ $totalApproved ?? 0 }}</p>
            </div>

            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg shadow-sm">
                <p class="text-xs font-semibold text-yellow-700 uppercase">Belum ACC</p>
                <p class="mt-1 text-2xl font-bold text-yellow-700">{{ $totalPending ?? 0 }}</p>
            </div>
        </div>

        {{-- Filter status & search nama --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div class="inline-flex rounded-md shadow-sm" role="group">
                <button
                    type="button"
                    wire:click="$set('statusFilter','all')"
                    class="px-4 py-2 text-xs font-medium border rounded-l-md focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-indigo-500 {{ $statusFilter === 'all' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
                    Semua
                </button>
                <button
                    type="button"
                    wire:click="$set('statusFilter','confirmed')"
                    class="px-4 py-2 text-xs font-medium border-t border-b focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-indigo-500 {{ $statusFilter === 'confirmed' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
                    Sudah ACC
                </button>
                <button
                    type="button"
                    wire:click="$set('statusFilter','pending')"
                    class="px-4 py-2 text-xs font-medium border rounded-r-md focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-indigo-500 {{ $statusFilter === 'pending' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
                    Belum ACC
                </button>
            </div>

            <div class="w-full md:w-64">
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari nama peserta..."
                    class="block w-full rounded-md border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                >
            </div>
        </div>
    </div>

    {{-- Loading Indicator --}}
    <div wire:loading.flex class="items-center justify-center gap-2 mb-4 text-blue-600">
        <i class="fas fa-spinner fa-spin"></i>
        <span>Memuat data...</span>
    </div>

    {{-- Mobile: stacked cards --}}
    <div class="md:hidden space-y-4" wire:loading.remove>
        @foreach ($sisemars as $sisemar)
            <div class="bg-white p-4 rounded-lg shadow-sm border">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="text-sm font-semibold text-gray-900">{{ $sisemar->name }}</div>
                        <div class="text-xs text-gray-500">{{ $sisemar->school }}</div>
                    </div>
                    <div class="text-right">
                        @if($sisemar->status == 'pending')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                        @elseif($sisemar->status == 'confirmed')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Confirmed</span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                        @endif
                    </div>
                </div>

                <div class="mt-3 text-sm text-gray-700 space-y-1">
                    <div class="flex flex-col">
                        <span class="text-xs text-gray-500">Kontak</span>
                        <span>{{ $sisemar->email }}</span>
                        <span>{{ $sisemar->wa_number }}</span>
                    </div>

                    <div class="flex flex-col mt-2">
                        <span class="text-xs text-gray-500">Pilihan Jurusan</span>
                        <span>1. {{ $sisemar->major_preference_1 }}</span>
                        <span>2. {{ $sisemar->major_preference_2 }}</span>
                    </div>

                    <div class="flex flex-col mt-2">
                        <span class="text-xs text-gray-500">Pembayaran</span>
                        <span>{{ $sisemar->payment }} ({{ $sisemar->payment_status }})</span>
                        @if($sisemar->free_consultation == 'Iya')
                            <span class="text-xs text-blue-600 font-semibold">+ Consultation</span>
                        @endif
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t flex items-center justify-between">
                    <div class="text-xs text-gray-500">
                        @if($sisemar->e_ticket_code)
                            Ticket: <span class="font-mono text-gray-700">{{ $sisemar->e_ticket_code }}</span>
                        @endif
                    </div>

                    <div class="flex items-center space-x-2">
                        @if($sisemar->status == 'pending')
                            @if($sisemar->payment_status === 'DP')
                                <button wire:click="openPaymentModal({{ $sisemar->id }})"
                                    class="text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded text-sm"
                                    title="Update Pembayaran">
                                    <i class="fas fa-money-bill"></i>
                                </button>
                            @endif

                            @if($sisemar->payment_status === 'LUNAS')
                                <button wire:click="openApproveModal({{ $sisemar->id }})"
                                    class="text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded text-sm"
                                    title="Terima">
                                    <i class="fas fa-check"></i>
                                </button>
                            @else
                                <span class="text-orange-500 text-xs font-bold px-2 py-1 bg-orange-100 rounded">
                                    Harus LUNAS dulu
                                </span>
                            @endif
                        @endif

                        <button wire:click="openDeleteModal({{ $sisemar->id }})"
                            class="text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-sm"
                            title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Desktop: table view (md+) --}}
    <div class="hidden md:block overflow-x-auto" wire:loading.remove>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama / Sekolah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak / Jurusan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pembayaran</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status / Tiket</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($sisemars as $sisemar)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $sisemar->name }}</div>
                            <div class="text-sm text-gray-500">{{ $sisemar->school }}</div>
                        </td>

                        <td class="px-6 py-4 max-w-xs">
                            <div class="text-sm text-gray-900">{{ $sisemar->email }}</div>
                            <div class="text-sm text-gray-500">{{ $sisemar->wa_number }}</div>
                            <div class="text-xs text-gray-400 mt-2">
                                <div class="truncate">1. {{ $sisemar->major_preference_1 }}</div>
                                <div class="truncate">2. {{ $sisemar->major_preference_2 }}</div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $sisemar->payment }}</div>
                            <div class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $sisemar->payment_status === 'LUNAS' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                                    {{ $sisemar->payment_status }}
                                </span>
                            </div>
                            @if($sisemar->free_consultation == 'Iya')
                                <div class="mt-1 text-xs text-blue-600 font-bold">+ Free Consult</div>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($sisemar->status == 'pending')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            @elseif($sisemar->status == 'confirmed')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Confirmed</span>
                                <div class="text-xs text-gray-500 mt-1 font-mono">{{ $sisemar->e_ticket_code ?? '-' }}</div>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex flex-col space-y-2">
                                @if($sisemar->status == 'pending')
                                    <div class="flex space-x-2">
                                        @if($sisemar->payment_status === 'DP')
                                            <button wire:click="openPaymentModal({{ $sisemar->id }})"
                                                class="text-white bg-blue-600 hover:bg-blue-700 px-2 py-1 rounded text-xs"
                                                title="Update Pembayaran">
                                                <i class="fas fa-money-bill"></i>
                                            </button>
                                        @endif

                                        @if($sisemar->payment_status === 'LUNAS')
                                            <button wire:click="openApproveModal({{ $sisemar->id }})"
                                                class="text-white bg-green-600 hover:bg-green-700 px-2 py-1 rounded text-xs"
                                                title="Terima">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @else
                                            <span class="text-xs text-orange-600 bg-orange-100 px-2 py-1 rounded font-bold cursor-help">
                                                Lunasi Dulu
                                            </span>
                                        @endif
                                    </div>
                                @endif

                                <button wire:click="openDeleteModal({{ $sisemar->id }})"
                                    class="text-white bg-red-600 hover:bg-red-700 px-2 py-1 rounded text-xs"
                                    title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4" wire:loading.remove>
        {{ $sisemars->links() }}
    </div>

    {{-- Approve Modal --}}
    @if($showApproveModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30 p-4"
             wire:click="closeApproveModal">
            <div class="bg-white rounded-lg shadow-xl max-w-sm w-full" wire:click.stop>
                <div class="p-6">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-green-100 rounded-full">
                        <i class="fas fa-check text-green-600 text-lg"></i>
                    </div>

                    <h3 class="mt-4 text-lg font-medium text-gray-900 text-center">
                        Setujui Pendaftaran
                    </h3>

                    <p class="mt-2 text-sm text-gray-500 text-center">
                        Apakah Anda yakin ingin menerima pendaftaran <strong>{{ $selectedSisemar?->name ?? '' }}</strong>? 
                        E-Ticket akan dikirim ke emailnya.
                    </p>

                    <div class="mt-6 flex space-x-3">
                        <button wire:click="closeApproveModal()"
                            class="flex-1 bg-gray-200 text-gray-800 py-2 px-4 rounded-lg hover:bg-gray-300 font-medium">
                            Batal
                        </button>

                        {{-- TOMBOL KONFIRMASI DENGAN LOADING --}}
                        <button
                            wire:click="approveConfirm"
                            wire:loading.attr="disabled"
                            wire:target="approveConfirm"
                            class="flex-1 bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 font-medium flex items-center justify-center"
                        >
                            {{-- Teks normal (saat tidak loading) --}}
                            <span wire:loading.remove wire:target="approveConfirm">
                                Ya, Terima
                            </span>

                            {{-- Teks + spinner saat loading --}}
                            <span wire:loading wire:target="approveConfirm" class="inline-flex items-center">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                          d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                                <span class="ml-2 text-sm">
                                    Mengirim email...
                                </span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Delete Modal --}}
    @if($showDeleteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30 p-4"
             wire:click="closeDeleteModal">
            <div class="bg-white rounded-lg shadow-xl max-w-sm w-full" wire:click.stop>
                <div class="p-6">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full">
                        <i class="fas fa-exclamation text-red-600 text-lg"></i>
                    </div>

                    <h3 class="mt-4 text-lg font-medium text-gray-900 text-center">
                        Hapus Data Peserta
                    </h3>

                    <p class="mt-2 text-sm text-gray-500 text-center">
                        Apakah Anda yakin ingin menghapus data <strong>{{ $selectedSisemar?->name ?? '' }}</strong>? 
                        Tindakan ini tidak dapat dibatalkan.
                    </p>

                    <div class="mt-6 flex space-x-3">
                        <button wire:click="closeDeleteModal()"
                            class="flex-1 bg-gray-200 text-gray-800 py-2 px-4 rounded-lg hover:bg-gray-300 font-medium">
                            Batal
                        </button>
                        <button wire:click="deleteConfirm()"
                            class="flex-1 bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 font-medium">
                            Ya, Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Payment Modal --}}
    @if($showPaymentModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30 p-4"
             wire:click="closePaymentModal">
            <div class="bg-white rounded-lg shadow-xl max-w-sm w-full" wire:click.stop>
                <div class="p-6">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-blue-100 rounded-full">
                        <i class="fas fa-money-bill text-blue-600 text-lg"></i>
                    </div>

                    <h3 class="mt-4 text-lg font-medium text-gray-900 text-center">
                        Ubah Status Pembayaran
                    </h3>

                    <p class="mt-2 text-sm text-gray-500 text-center">
                        Ubah status pembayaran <strong>{{ $selectedSisemar?->name ?? '' }}</strong> dari DP menjadi LUNAS?
                    </p>

                    <div class="mt-4 p-4 bg-blue-50 rounded-lg text-sm text-gray-700">
                        <strong>Nama:</strong> {{ $selectedSisemar?->name ?? '-' }} <br>
                        <strong>Metode:</strong> {{ $selectedSisemar?->payment ?? '-' }} <br>
                        <strong>Status Saat Ini:</strong> <span class="font-semibold">{{ $selectedSisemar?->payment_status ?? '-' }}</span>
                    </div>

                    <div class="mt-6 flex space-x-3">
                        <button wire:click="closePaymentModal()"
                            class="flex-1 bg-gray-200 text-gray-800 py-2 px-4 rounded-lg hover:bg-gray-300 font-medium">
                            Batal
                        </button>
                        <button wire:click="updatePaymentStatus()"
                            class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 font-medium">
                            Ya, Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
