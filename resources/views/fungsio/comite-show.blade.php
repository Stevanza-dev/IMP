<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Kepanitiaan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">{{ $comite->title ?? $comite->workProgram->name }}</h3>
                        <p class="mt-1 text-sm text-gray-500">Program Kerja: {{ $comite->workProgram->name ?? '-' }}</p>
                    </div>
                    <a href="{{ route('fungsio.comite.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500">&larr; Kembali</a>
                </div>

                <div class="px-6 py-4 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700">Status</h4>
                            <p class="mt-1 text-sm">
                                @switch($comite->status)
                                    @case('draft')
                                        <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-700">Draft</span>
                                        @break
                                    @case('pending')
                                        <span class="inline-flex items-center rounded-full bg-yellow-100 px-2 py-0.5 text-xs font-medium text-yellow-800">Menunggu Verifikasi</span>
                                        @break
                                    @case('approved')
                                        <span class="inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800">Disetujui</span>
                                        @break
                                    @case('rejected')
                                        <span class="inline-flex items-center rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800">Ditolak</span>
                                        @break
                                @endswitch
                            </p>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700">Verifikasi</h4>
                            <p class="mt-1 text-sm text-gray-600">
                                Dibuat oleh: {{ $comite->createdBy->nickname ?? $comite->createdBy->user->name ?? '-' }}<br>
                                @if ($comite->verified_at)
                                    @if ($comite->verifiedBy)
                                        Diverifikasi oleh: {{ $comite->verifiedBy->nickname ?? $comite->verifiedBy->user->name ?? '-' }}<br>
                                    @else
                                        Diverifikasi oleh: Ketua Panitia<br>
                                    @endif
                                    Pada: {{ $comite->verified_at?->format('d M Y, H:i') }}
                                @else
                                    <span class="text-yellow-700">Belum diverifikasi</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    @if ($comite->description)
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700">Deskripsi</h4>
                            <p class="mt-1 text-sm text-gray-700">{{ $comite->description }}</p>
                        </div>
                    @endif

                    <div>
                        <h4 class="text-sm font-semibold text-gray-700">Struktur Sie &amp; Anggota</h4>
                        <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse ($comite->sies as $sie)
                                <div class="rounded-lg border border-gray-200 p-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <h5 class="text-sm font-semibold text-gray-900">{{ $sie->name }}</h5>
                                    </div>

                                    <ul class="mt-2 space-y-1 text-sm text-gray-700">
                                        @forelse ($sie->members as $member)
                                            <li class="flex items-center justify-between">
                                                <div>
                                                    @if ($sie->name === 'Ketua Panitia')
                                                        <span class="font-semibold">Ketua Panitia:</span>
                                                    @elseif ($member->role === 'koor')
                                                        <span class="font-semibold">Koor:</span>
                                                    @else
                                                        <span class="text-gray-500">Anggota:</span>
                                                    @endif
                                                    {{ $member->fungsio->nickname ?? $member->fungsio->user->name ?? '-' }}
                                                </div>

                                                @if (in_array($comite->status, ['draft', 'pending']))
                                                    <form action="{{ route('fungsio.comite.members.destroy', [$comite->id, $member->id]) }}" method="POST" onsubmit="return confirm('Hapus anggota ini dari sie?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-xs text-red-600 hover:text-red-900">Hapus</button>
                                                    </form>
                                                @endif
                                            </li>
                                        @empty
                                            <li class="text-xs text-gray-400">Belum ada anggota.</li>
                                        @endforelse
                                    </ul>

                                    @if (in_array($comite->status, ['draft', 'pending']))
                                        <div class="mt-3 border-t border-dashed border-gray-200 pt-3">
                                            <form action="{{ route('fungsio.comite.members.store', $comite->id) }}" method="POST" class="space-y-3 member-form" data-sie-id="{{ $sie->id }}">
                                                @csrf
                                                <input type="hidden" name="comite_sie_id" value="{{ $sie->id }}">
                                                @php
                                                    $hasKoor = false;
                                                    foreach ($sie->members as $m) {
                                                        if ($m->role === 'koor') {
                                                            $hasKoor = true;
                                                            break;
                                                        }
                                                    }

                                                    $isKetuaPanitia = $sie->name === 'Ketua Panitia';
                                                    $noKoorSie = in_array($sie->name, ['Penanggung Jawab', 'Steering Committee']);
                                                    $hasAnyMember = $sie->members->count() > 0;

                                                    // Semua fungsio yang sudah menjadi anggota di sie manapun dalam komite ini
                                                    $assignedFungsioIds = $comite->sies
                                                        ->flatMap(function ($s) {
                                                            return $s->members;
                                                        })
                                                        ->pluck('fungsio_id')
                                                        ->unique()
                                                        ->toArray();
                                                    
                                                    // Available fungsios untuk sie ini (yang belum assigned)
                                                    $availableForThisSie = $availableFungsios->filter(function($f) use ($assignedFungsioIds) {
                                                        return !in_array($f->id, $assignedFungsioIds);
                                                    });
                                                @endphp

                                                @if ($isKetuaPanitia)
                                                    @if ($hasAnyMember)
                                                        <p class="text-xs text-gray-500">Ketua Panitia sudah terisi. Hapus terlebih dahulu jika ingin mengganti.</p>
                                                    @else
                                                        <div>
                                                            <label class="block text-xs font-medium text-gray-600 mb-2">Pilih Ketua Panitia</label>
                                                            <select
                                                                name="koor_id"
                                                                class="block w-full rounded-md border-gray-300 text-xs shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                                required
                                                            >
                                                                <option value="">-- Pilih Ketua --</option>
                                                                @foreach ($availableForThisSie as $f)
                                                                    <option value="{{ $f->id }}">{{ $f->nickname ?? $f->user->name ?? 'Fungsio #' . $f->id }}</option>
                                                                @endforeach
                                                            </select>
                                                            <p class="mt-2 text-xs text-gray-500">Peran akan disimpan sebagai Ketua Panitia.</p>
                                                        </div>
                                                        <div class="flex justify-end">
                                                            <button type="submit" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500">Simpan</button>
                                                        </div>
                                                    @endif
                                                @elseif($noKoorSie)
                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-600 mb-2">Tambah Anggota</label>
                                                        <div class="anggota-container space-y-2" data-sie-type="no-koor">
                                                            <div class="anggota-item flex items-center gap-2">
                                                                <select
                                                                    name="anggota_ids[]"
                                                                    class="block w-full rounded-md border-gray-300 text-xs shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                                    required
                                                                >
                                                                    <option value="">-- Pilih Anggota --</option>
                                                                    @foreach ($availableForThisSie as $f)
                                                                        <option value="{{ $f->id }}">{{ $f->nickname ?? $f->user->name ?? 'Fungsio #' . $f->id }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <button
                                                                    type="button"
                                                                    class="remove-anggota flex-shrink-0 inline-flex items-center justify-center w-7 h-7 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-md transition-colors"
                                                                    title="Hapus"
                                                                >
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <button
                                                            type="button"
                                                            class="add-anggota mt-2 inline-flex items-center px-2 py-1 border border-gray-300 text-xs font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50"
                                                        >
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                            </svg>
                                                            Tambah Anggota
                                                        </button>
                                                        <p class="mt-2 text-xs text-gray-500">Pada sie ini tidak ada koor, semua tercatat sebagai anggota.</p>
                                                    </div>
                                                    <div class="flex justify-end">
                                                        <button type="submit" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500">Simpan Anggota</button>
                                                    </div>
                                                @else
                                                    @if (!$hasKoor)
                                                        <div>
                                                            <label class="block text-xs font-medium text-gray-600 mb-2">Koordinator</label>
                                                            <select
                                                                name="koor_id"
                                                                class="block w-full rounded-md border-gray-300 text-xs shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                            >
                                                                <option value="">-- Pilih Koordinator --</option>
                                                                @foreach ($availableForThisSie as $f)
                                                                    <option value="{{ $f->id }}">{{ $f->nickname ?? $f->user->name ?? 'Fungsio #' . $f->id }}</option>
                                                                @endforeach
                                                            </select>
                                                            <p class="mt-1 text-xs text-gray-500">Pilih satu orang jika ingin menjadikannya koor.</p>
                                                        </div>
                                                    @else
                                                        <p class="text-xs text-gray-500">Sie ini sudah memiliki koor. Hapus terlebih dahulu jika ingin mengganti.</p>
                                                    @endif

                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-600 mb-2">Tambah Anggota</label>
                                                        <div class="anggota-container space-y-2" data-sie-type="regular">
                                                            <div class="anggota-item flex items-center gap-2">
                                                                <select
                                                                    name="anggota_ids[]"
                                                                    class="block w-full rounded-md border-gray-300 text-xs shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                                    required
                                                                >
                                                                    <option value="">-- Pilih Anggota --</option>
                                                                    @foreach ($availableForThisSie as $f)
                                                                        <option value="{{ $f->id }}">{{ $f->nickname ?? $f->user->name ?? 'Fungsio #' . $f->id }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <button
                                                                    type="button"
                                                                    class="remove-anggota flex-shrink-0 inline-flex items-center justify-center w-7 h-7 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-md transition-colors"
                                                                    title="Hapus"
                                                                >
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <button
                                                            type="button"
                                                            class="add-anggota mt-2 inline-flex items-center px-2 py-1 border border-gray-300 text-xs font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50"
                                                        >
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                            </svg>
                                                            Tambah Anggota
                                                        </button>
                                                    </div>
                                                    <div class="flex justify-end">
                                                        <button type="submit" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500">Simpan Anggota</button>
                                                    </div>
                                                @endif
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">Belum ada sie yang didefinisikan untuk kepanitiaan ini.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Fungsi untuk membuat anggota item baru
    function createAnggotaItem(availableOptions) {
        const div = document.createElement('div');
        div.className = 'anggota-item flex items-center gap-2';
        
        let optionsHtml = '<option value="">-- Pilih Anggota --</option>';
        availableOptions.forEach(opt => {
            optionsHtml += `<option value="${opt.value}">${opt.text}</option>`;
        });
        
        div.innerHTML = `
            <select
                name="anggota_ids[]"
                class="block w-full rounded-md border-gray-300 text-xs shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                required
            >
                ${optionsHtml}
            </select>
            <button
                type="button"
                class="remove-anggota flex-shrink-0 inline-flex items-center justify-center w-7 h-7 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-md transition-colors"
                title="Hapus"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        `;
        return div;
    }

    // Event listener untuk semua tombol "Tambah Anggota"
    document.querySelectorAll('.add-anggota').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('.member-form');
            const container = form.querySelector('.anggota-container');
            
            // Ambil options dari select pertama (skip option placeholder)
            const firstSelect = container.querySelector('select[name="anggota_ids[]"]');
            if (!firstSelect) return;
            
            const availableOptions = [];
            firstSelect.querySelectorAll('option').forEach(opt => {
                // Skip option dengan value kosong (placeholder)
                if (opt.value !== '') {
                    availableOptions.push({
                        value: opt.value,
                        text: opt.textContent
                    });
                }
            });
            
            const newItem = createAnggotaItem(availableOptions);
            container.appendChild(newItem);
            
            // Focus pada select baru
            newItem.querySelector('select').focus();
        });
    });

    // Event delegation untuk tombol hapus anggota
    document.querySelectorAll('.anggota-container').forEach(container => {
        container.addEventListener('click', function (e) {
            const removeButton = e.target.closest('.remove-anggota');
            if (removeButton) {
                const anggotaItem = removeButton.closest('.anggota-item');
                const itemCount = container.querySelectorAll('.anggota-item').length;
                
                // Minimal harus ada 1 input
                if (itemCount <= 1) {
                    alert('Minimal harus ada 1 anggota untuk ditambahkan!');
                    return;
                }
                
                anggotaItem.remove();
            }
        });
    });

    // Validasi sebelum submit
    document.querySelectorAll('.member-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            const anggotaSelects = form.querySelectorAll('select[name="anggota_ids[]"]');
            
            if (anggotaSelects.length > 0) {
                let hasEmpty = false;
                let hasValue = false;
                const selectedValues = [];
                
                anggotaSelects.forEach(select => {
                    const value = select.value;
                    if (value === '') {
                        hasEmpty = true;
                    } else {
                        hasValue = true;
                        // Check for duplicates
                        if (selectedValues.includes(value)) {
                            hasEmpty = true; // Use this flag to prevent submission
                            alert('Tidak boleh memilih anggota yang sama lebih dari sekali!');
                            e.preventDefault();
                            return false;
                        }
                        selectedValues.push(value);
                    }
                });

                if (!hasValue) {
                    e.preventDefault();
                    alert('Minimal harus ada 1 anggota yang dipilih!');
                    return false;
                }

                if (hasEmpty && selectedValues.length === 0) {
                    e.preventDefault();
                    alert('Ada anggota yang belum dipilih. Mohon pilih atau hapus input tersebut.');
                    return false;
                }
            }
        });
    });
});
</script>
