<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($contact) ? 'Edit Kontak' : 'Tambah Kontak' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-lg shadow-md">

                <form action="{{ isset($contact) ? route('contacts.update', $contact->id) : route('contacts.store') }}"
                    method="POST">
                    @csrf
                    @if(isset($contact)) @method('PUT') @endif

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Kontak</label>
                        <input type="text" name="name" value="{{ old('name', $contact->name ?? '') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                            placeholder="Contoh: Ketua Umum" required>
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nomor HP/WA</label>
                        <input type="text" name="phone" value="{{ old('phone', $contact->phone ?? '') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                            placeholder="Contoh: 0888888888" required>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('contacts.index') }}"
                            class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition">Batal</a>
                        <button type="submit"
                            class="px-5 py-2.5 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition shadow-lg">
                            Simpan Data
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
