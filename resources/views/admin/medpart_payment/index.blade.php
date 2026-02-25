<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Metode Pembayaran</h2>
            <a href="{{ route('medpart-payments.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-bold shadow transition">
                + Tambah Pembayaran
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Bank / E-Wallet</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Nomor Rekening</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Atas Nama</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Aktif</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($payments as $payment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-bold text-gray-800">
                                        {{ $payment->bank_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-lg text-blue-700 font-mono tracking-wider font-bold">
                                        {{ $payment->account_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700 font-semibold uppercase">
                                        {{ $payment->account_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($payment->is_active)
                                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">Aktif</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('medpart-payments.edit', $payment->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 px-3 py-1 rounded">Edit</a>
                                            <form action="{{ route('medpart-payments.destroy', $payment->id) }}" method="POST" onsubmit="return confirm('Hapus metode pembayaran ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 px-3 py-1 rounded">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
