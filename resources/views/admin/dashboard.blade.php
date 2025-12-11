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
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama & Instansi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti Bayar</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
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
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ asset('storage/' . $reg->payment_proof) }}" target="_blank" class="text-blue-600 hover:text-blue-900 text-sm underline">
                                            Lihat Foto
                                        </a>
                                        <div class="text-xs text-gray-500 mt-1">{{ $reg->payment_method }}</div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($reg->status == 'pending')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                        @elseif($reg->status == 'confirmed')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Confirmed</span>
                                            <div class="text-xs text-gray-500 mt-1">{{ $reg->ticket_code }}</div>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if($reg->status == 'pending')
                                            <div class="flex space-x-2">
                                                <form action="{{ route('admin.approve', $reg->id) }}" method="POST" onsubmit="return confirm('Yakin validasi?');">
                                                    @csrf @method('PATCH')
                                                    <button type="submit" class="text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded-md text-xs">✓ Terima</button>
                                                </form>
                                                <form action="{{ route('admin.reject', $reg->id) }}" method="POST" onsubmit="return confirm('Tolak?');">
                                                    @csrf @method('PATCH')
                                                    <button type="submit" class="text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded-md text-xs">✕ Tolak</button>
                                                </form>
                                                <a href="{{ route('admin.edit', $reg->id) }}" class="text-blue-600 hover:text-blue-900 px-2 py-1 text-xs border border-blue-600 rounded">✎ Edit</a>
                                            </div>
                                        @elseif($reg->status == 'confirmed')
                                            <div class="flex flex-col space-y-1">
                                                
                                                <form action="{{ route('admin.resend', $reg->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-blue-600 hover:text-blue-800 text-xs font-bold underline">
                                                        📩 Kirim Ulang Email
                                                    </button>
                                                </form>

                                                <a href="{{ route('admin.edit', $reg->id) }}" class="text-gray-500 hover:text-gray-700 text-xs">
                                                    ✎ Edit Data / Email
                                                </a>
                                            </div>
                                        @else
                                            <span class="text-red-500 text-xs">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        <div class="mt-4">
                            {{ $registrations->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>