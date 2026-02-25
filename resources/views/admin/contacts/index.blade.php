<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Kontak</h2>
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
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Nomor HP/WA</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($contacts as $contact)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-800">
                                        {{ $contact->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $contact->phone }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium flex justify-center gap-2">
                                        <a href="{{ route('contacts.edit', $contact->id) }}"
                                            class="text-blue-600 hover:text-blue-900 bg-blue-50 px-3 py-1 rounded">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                            @if($contacts->isEmpty())
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                        Belum ada kontak.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
