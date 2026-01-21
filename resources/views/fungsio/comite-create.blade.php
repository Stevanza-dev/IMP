<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Kepanitiaan Baru') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Form Kepanitiaan</h3>
                        <p class="mt-1 text-sm text-gray-500">Pilih program kerja dan definisikan sie kepanitiaan.</p>
                    </div>
                    <a href="{{ route('fungsio.comite.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500">&larr; Kembali</a>
                </div>

                <div class="px-6 py-4">
                    <form method="POST" action="{{ route('fungsio.comite.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="work_program_id" value="Program Kerja" />
                            <select id="work_program_id" name="work_program_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">-- Pilih Program Kerja --</option>
                                @foreach ($workPrograms as $program)
                                    <option value="{{ $program->id }}" @selected(old('work_program_id') == $program->id)>
                                        {{ $program->name }} ({{ \Carbon\Carbon::parse($program->execution_date)->format('d M Y') }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('work_program_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="title" value="Nama Kepanitiaan (opsional)" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ old('title') }}" />
                            <p class="mt-1 text-xs text-gray-500">Jika dikosongkan, akan menggunakan nama program kerja + "Committee".</p>
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" value="Deskripsi (opsional)" />
                            <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label value="Daftar Sie" />
                            <p class="mt-1 text-xs text-gray-500">Isi nama sie yang dibutuhkan. Secara default terisi: Ketua Panitia, Penanggung Jawab, Steering Committee, Bendahara, Sekretaris, Acara. Anda tetap bisa mengubah atau menambah sie lain.</p>

                            @php
                                $defaultSies = ['Ketua Panitia', 'Penanggung Jawab', 'Steering Committee', 'Bendahara', 'Sekretaris', 'Acara'];
                                $oldSies = old('sies', []);
                            @endphp

                            <div id="sie-container" class="mt-3 space-y-2">
                                @foreach ($defaultSies as $index => $defaultSie)
                                    <div class="sie-item flex items-center gap-2">
                                        <x-text-input
                                            name="sies[]"
                                            type="text"
                                            class="block w-full"
                                            value="{{ $oldSies[$index] ?? $defaultSie }}"
                                            placeholder="Nama Sie"
                                        />
                                        <button
                                            type="button"
                                            class="remove-sie flex-shrink-0 inline-flex items-center justify-center w-8 h-8 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-md transition-colors"
                                            title="Hapus Sie"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach

                                @for ($i = count($defaultSies); $i < count($oldSies); $i++)
                                    <div class="sie-item flex items-center gap-2">
                                        <x-text-input
                                            name="sies[]"
                                            type="text"
                                            class="block w-full"
                                            value="{{ $oldSies[$i] }}"
                                            placeholder="Nama Sie"
                                        />
                                        <button
                                            type="button"
                                            class="remove-sie flex-shrink-0 inline-flex items-center justify-center w-8 h-8 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-md transition-colors"
                                            title="Hapus Sie"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                @endfor
                            </div>

                            <button
                                type="button"
                                id="add-sie"
                                class="mt-3 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Tambah Sie
                            </button>

                            <x-input-error :messages="$errors->get('sies')" class="mt-2" />
                        </div>

                        <div class="flex justify-end">
                            <x-primary-button>
                                Simpan &amp; Ajukan Verifikasi
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('sie-container');
        const addButton = document.getElementById('add-sie');
        const form = document.querySelector('form');

        if (!container || !addButton) return;

        // Fungsi untuk membuat sie item baru
        function createSieItem(value = '') {
            const div = document.createElement('div');
            div.className = 'sie-item flex items-center gap-2';
            div.innerHTML = `
                <input
                    type="text"
                    name="sies[]"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Nama Sie"
                    value="${value}"
                />
                <button
                    type="button"
                    class="remove-sie flex-shrink-0 inline-flex items-center justify-center w-8 h-8 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-md transition-colors"
                    title="Hapus Sie"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            `;
            return div;
        }

        // Event listener untuk tombol tambah sie
        addButton.addEventListener('click', function () {
            const newItem = createSieItem();
            container.appendChild(newItem);
            // Focus pada input baru
            newItem.querySelector('input').focus();
        });

        // Event delegation untuk tombol hapus
        container.addEventListener('click', function (e) {
            const removeButton = e.target.closest('.remove-sie');
            if (removeButton) {
                const sieItem = removeButton.closest('.sie-item');
                const sieCount = container.querySelectorAll('.sie-item').length;
                
                // Minimal harus ada 1 sie
                if (sieCount <= 1) {
                    alert('Minimal harus ada 1 sie!');
                    return;
                }
                
                sieItem.remove();
            }
        });

        // Validasi sebelum submit
        form.addEventListener('submit', function (e) {
            const sieInputs = container.querySelectorAll('input[name="sies[]"]');
            let hasEmpty = false;
            let hasValue = false;

            sieInputs.forEach(input => {
                const value = input.value.trim();
                if (value === '') {
                    hasEmpty = true;
                } else {
                    hasValue = true;
                }
            });

            if (!hasValue) {
                e.preventDefault();
                alert('Minimal harus ada 1 sie dengan nama yang diisi!');
                return false;
            }

            if (hasEmpty) {
                e.preventDefault();
                alert('Ada sie dengan nama kosong. Mohon isi atau hapus sie tersebut.');
                return false;
            }
        });
    });
</script>
