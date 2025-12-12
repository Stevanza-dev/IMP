<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($social) ? 'Edit Sosial Media' : 'Tambah Sosial Media' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-lg shadow-md">

                <form action="{{ isset($social) ? route('socials.update', $social->id) : route('socials.store') }}"
                    method="POST">
                    @csrf
                    @if(isset($social)) @method('PUT') @endif

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Platform</label>
                        <input type="text" name="name" value="{{ old('name', $social->name ?? '') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                            placeholder="Contoh: Instagram" required>
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Link URL</label>
                        <input type="url" name="url" value="{{ old('url', $social->url ?? '') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                            placeholder="https://instagram.com/imp_pati" required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            Class Icon FontAwesome
                            <a href="https://fontawesome.com/search?o=r&m=free" target="_blank"
                                class="text-blue-500 text-xs font-normal hover:underline ml-2">
                                (Cari Icon Disini <i class="fas fa-external-link-alt"></i>)
                            </a>
                        </label>
                        <input type="text" name="icon_class" value="{{ old('icon_class', $social->icon_class ?? '') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 font-mono text-sm bg-gray-50"
                            placeholder="Contoh: fab fa-instagram" required>
                        <p class="text-xs text-gray-400 mt-1">Gunakan class 'fab' untuk brand (ig, tiktok) dan 'fas'
                            untuk icon umum (email, web).</p>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('socials.index') }}"
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