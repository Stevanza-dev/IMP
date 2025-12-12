<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Panitia AMPERA 2026') }}
            </h2>
            <a href="{{ route('members.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-bold shadow transition">
                + Tambah Panitia
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Total Personil</h3>
                        <p class="text-gray-500 text-sm">Panitia Terdaftar</p>
                    </div>
                    <div class="text-3xl font-bold text-blue-600">
                        {{ $groupedMembers->flatten()->count() }}
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                @foreach($groupedMembers as $divisionName => $members)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                            <h3 class="font-bold text-gray-800 uppercase tracking-wide">{{ $divisionName }}</h3>
                            <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded-full">
                                {{ $members->count() }} Orang
                            </span>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach($members as $member)
                                    <div
                                        class="relative group p-3 rounded-lg border border-gray-100 hover:bg-blue-50 hover:border-blue-200 transition">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm">
                                                {{ substr($member->name, 0, 1) }}
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-bold text-gray-900 truncate">{{ $member->name }}</p>
                                                <p class="text-xs text-gray-500 truncate">{{ $member->division }}</p>
                                            </div>
                                        </div>
                                        <div class="absolute top-2 right-2 hidden group-hover:flex space-x-1">
                                            <a href="{{ route('members.edit', $member->id) }}"
                                                class="bg-yellow-400 text-white p-1 rounded hover:bg-yellow-500 transition"
                                                title="Edit">
                                                <i class="fas fa-pencil-alt text-xs"></i>
                                            </a>
                                            <form action="{{ route('members.destroy', $member->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus panitia ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 text-white p-1 rounded hover:bg-red-600 transition"
                                                    title="Hapus">
                                                    <i class="fas fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>