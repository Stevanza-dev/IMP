<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($member) ? 'Edit Data Panitia' : 'Tambah Panitia Baru' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-lg shadow-md">

                <form action="{{ isset($member) ? route('members.update', $member->id) : route('members.store') }}"
                    method="POST">
                    @csrf
                    @if(isset($member)) @method('PUT') @endif

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $member->name ?? '') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition"
                            placeholder="Nama Panitia" required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Sie / Divisi</label>
                        <input list="divisions" name="division" value="{{ old('division', $member->division ?? '') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition"
                            placeholder="Pilih Sie..." required>

                        <datalist id="divisions">
                            @foreach($divisions as $div)
                                <option value="{{ $div }}">
                            @endforeach
                        </datalist>
                        <p class="text-xs text-gray-400 mt-1">Pilih dari list atau ketik manual jika Sie belum
                            terdaftar.</p>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('members.index') }}"
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