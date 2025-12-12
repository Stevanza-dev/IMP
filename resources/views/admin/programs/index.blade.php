<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Program Kerja</h2>
            <a href="{{ route('programs.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded text-sm font-bold">+ Tambah Proker</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
                @endif

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Nama Proker</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Divisi</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($programs as $program)
                            <tr>
                                <td class="px-6 py-4">{{ $program->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $program->division->name }}</td>
                                <td class="px-6 py-4 text-sm">{{ $program->execution_date }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 rounded text-xs text-white {{ $program->is_active ? 'bg-green-500' : 'bg-gray-400' }}">
                                        {{ $program->is_active ? 'Aktif' : 'Selesai' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 flex justify-center gap-2">
                                    <a href="{{ route('programs.edit', $program->id) }}"
                                        class="text-blue-600 hover:text-blue-900">Edit</a>
                                    <form action="{{ route('programs.destroy', $program->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus proker ini?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>