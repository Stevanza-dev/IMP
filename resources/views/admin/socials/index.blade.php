<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Sosial Media</h2>
            <a href="{{ route('socials.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-bold shadow transition">
                + Tambah Sosmed
            </a>
        </div>
    </x-slot>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Preview</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Platform</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">URL Link</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($socials as $social)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-center w-16">
                                        <div
                                            class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                                            <i class="{{ $social->icon_class }}"></i>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-800">
                                        {{ $social->name }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 hover:underline max-w-xs truncate">
                                        <a href="{{ $social->url }}" target="_blank">{{ $social->url }}</a>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium flex justify-center gap-2">
                                        <a href="{{ route('socials.edit', $social->id) }}"
                                            class="text-blue-600 hover:text-blue-900 bg-blue-50 px-3 py-1 rounded">Edit</a>

                                        <form action="{{ route('socials.destroy', $social->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus sosmed ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900 bg-red-50 px-3 py-1 rounded">Hapus</button>
                                        </form>
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