<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($division) ? 'Edit Divisi' : 'Tambah Divisi Baru' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-lg shadow-md">

                <form
                    action="{{ isset($division) ? route('divisions.update', $division->id) : route('divisions.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($division)) @method('PUT') @endif

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Divisi</label>
                        <input type="text" name="name" value="{{ old('name', $division->name ?? '') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition"
                            placeholder="Contoh: Departemen Humas" required>
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Tugas</label>
                        <textarea name="description" rows="4"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition"
                            required>{{ old('description', $division->description ?? '') }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Logo Divisi (Opsional)</label>

                        @if(isset($division) && $division->logo)
                            <div class="mb-2 flex items-center gap-2">
                                <img src="{{ asset('storage/' . $division->logo) }}" class="h-12 w-12 rounded border p-1">
                                <span class="text-xs text-gray-500">Logo saat ini</span>
                            </div>
                        @endif

                        <input type="file" name="logo" accept="image/*" class="w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-50 file:text-blue-700
                            hover:file:bg-blue-100 cursor-pointer">
                        <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG. Maks 2MB.</p>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('divisions.index') }}"
                            class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition">Batal</a>
                        <button type="submit"
                            class="px-5 py-2.5 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition shadow-lg">
                            {{ isset($division) ? 'Simpan Perubahan' : 'Buat Divisi' }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>