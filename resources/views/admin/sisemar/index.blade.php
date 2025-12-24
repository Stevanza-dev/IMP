<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pendaftaran SI SEMAR 2026') }}
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

                    {{-- Mobile: stacked cards --}}
                    <div class="md:hidden space-y-4">
                        @foreach ($sisemars as $sisemar)
                            <div class="bg-white p-4 rounded-lg shadow-sm border">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">{{ $sisemar->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $sisemar->school }}</div>
                                    </div>
                                    <div class="text-right">
                                        @if($sisemar->status == 'pending')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                        @elseif($sisemar->status == 'confirmed')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Confirmed</span>
                                        @else
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
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
                                        @if($sisemar->payment_status === 'LUNAS')
                                            <form action="{{ route('admin.sisemar.approve', $sisemar->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin validasi data ini?');">
                                                @csrf
                                                <button type="submit"
                                                    class="text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded text-sm"
                                                    title="Terima">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-orange-500 text-xs font-bold px-2 py-1 bg-orange-100 rounded">
                                                Harus LUNAS dulu
                                            </span>
                                        @endif

                                            <form action="{{ route('admin.sisemar.reject', $sisemar->id) }}" method="POST"
                                                onsubmit="return confirm('Tolak pendaftaran ini?');">
                                                @csrf
                                                <button type="submit"
                                                    class="text-white bg-yellow-500 hover:bg-yellow-600 px-3 py-1 rounded text-sm"
                                                    title="Tolak">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
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
                                        Nama / Sekolah</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kontak / Jurusan</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pembayaran</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status / Tiket</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($sisemars as $sisemar)
                                    <tr>
                                        <!-- Nama & Sekolah -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $sisemar->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $sisemar->school }}</div>
                                        </td>

                                        <!-- Kontak & Jurusan -->
                                        <td class="px-6 py-4 max-w-xs">
                                            <div class="text-sm text-gray-900">{{ $sisemar->email }}</div>
                                            <div class="text-sm text-gray-500">{{ $sisemar->wa_number }}</div>
                                            <div class="text-xs text-gray-400 mt-2">
                                                <div class="truncate" title="Jurusan 1: {{ $sisemar->major_preference_1 }}">
                                                    1. {{ $sisemar->major_preference_1 }}</div>
                                                <div class="truncate" title="Jurusan 2: {{ $sisemar->major_preference_2 }}">
                                                    2. {{ $sisemar->major_preference_2 }}</div>
                                            </div>
                                        </td>

                                        <!-- Pembayaran -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $sisemar->payment }}</div>
                                            <div class="mt-1">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                                {{ $sisemar->payment_status === 'LUNAS' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                                                    {{ $sisemar->payment_status }}
                                                </span>
                                            </div>
                                            @if($sisemar->free_consultation == 'Iya')
                                                <div class="mt-1 text-xs text-blue-600 font-bold">+ Free Consult</div>
                                            @endif
                                        </td>

                                        <!-- Status & Tiket -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($sisemar->status == 'pending')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                            @elseif($sisemar->status == 'confirmed')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Confirmed</span>
                                                <div class="text-xs text-gray-500 mt-1 font-mono">
                                                    {{ $sisemar->e_ticket_code ?? '-' }}
                                                </div>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                            @endif
                                        </td>

                                        <!-- Aksi -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex flex-col space-y-2">
                                                @if($sisemar->status == 'pending')
                                                    <div class="flex space-x-2">
                                                        @if($sisemar->payment_status === 'LUNAS')
                                                            <form action="{{ route('admin.sisemar.approve', $sisemar->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Yakin validasi data ini?');">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="text-white bg-green-600 hover:bg-green-700 px-2 py-1 rounded text-xs"
                                                                    title="Terima">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <span class="text-xs text-orange-600 bg-orange-100 px-2 py-1 rounded font-bold cursor-help" 
                                                                  title="Status Pembayaran harus LUNAS untuk bisa dikonfirmasi">
                                                                Lunasi Dulu
                                                            </span>
                                                        @endif

                                                        <form action="{{ route('admin.sisemar.reject', $sisemar->id) }}"
                                                            method="POST" onsubmit="return confirm('Tolak pendaftaran ini?');">
                                                            @csrf
                                                            <button type="submit"
                                                                class="text-white bg-yellow-500 hover:bg-yellow-600 px-2 py-1 rounded text-xs"
                                                                title="Tolak">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $sisemars->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>