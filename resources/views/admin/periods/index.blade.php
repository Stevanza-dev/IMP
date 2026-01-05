<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Periode') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-between items-center">
                <a href="{{ route('periods.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    + Tambah Periode
                </a>

                @if (session('status'))
                    <p class="text-sm text-green-600">{{ session('status') }}</p>
                @endif
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700">#</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700">Tahun</th>
                                <th class="px-4 py-2 text-right font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($periods as $period)
                                <tr>
                                    <td class="px-4 py-2">{{ $loop->iteration + ($periods->currentPage() - 1) * $periods->perPage() }}</td>
                                    <td class="px-4 py-2">{{ $period->tahun }}</td>
                                    <td class="px-4 py-2 text-right space-x-2">
                                        <a href="{{ route('periods.edit', $period) }}"
                                            class="inline-flex items-center px-3 py-1 bg-yellow-500 text-white text-xs font-semibold rounded-md hover:bg-yellow-600">Edit</a>
                                        <form action="{{ route('periods.destroy', $period) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Hapus periode ini?')"
                                                class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-xs font-semibold rounded-md hover:bg-red-700">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-4 text-center text-gray-500">Belum ada data periode.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $periods->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
