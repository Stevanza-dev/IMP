<div class="space-y-6">
    <!-- Notifications -->
    <div x-data="{ show: false, message: '', type: 'success' }"
        x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type; setTimeout(() => show = false, 3000)"
        x-show="show" x-transition class="fixed top-4 right-4 z-50 px-4 py-2 rounded shadow-lg text-white text-sm"
        :class="type === 'success' ? 'bg-green-600' : 'bg-red-600'" style="display: none;">
        <span x-text="message"></span>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4" x-data="{ availablePeople: @js($availableFungsios) }">
        @forelse ($comite->sies as $sie)
            <div class="rounded-lg border border-gray-200 p-4 bg-white shadow-sm flex flex-col h-full">

                <!-- Sie Header -->
                <div class="flex items-center justify-between mb-3 pb-2 border-b border-gray-100">
                    <h5 class="text-sm font-bold text-gray-900">{{ $sie->name }}</h5>
                    <span class="text-xs text-gray-400">{{ $sie->members->count() }} Orang</span>
                </div>

                <!-- Members List -->
                <ul class="space-y-2 flex-grow overflow-y-auto max-h-60 custom-scrollbar mb-4">
                    @forelse ($sie->members as $member)
                        <li
                            class="flex items-center justify-between group p-1.5 rounded hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100">
                            <div class="flex items-center gap-2 overflow-hidden">
                                <div @class([
                                    'flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold text-white',
                                    'bg-indigo-500' => $member->role === 'ketua' || $member->role === 'koor',
                                    'bg-gray-400' => $member->role === 'anggota'
                                ])>
                                    {{ substr($member->role, 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-800 truncate">
                                        {{ $member->fungsio->user->name ?? '-' }}
                                    </p>
                                    <p class="text-[10px] text-gray-500 capitalize leading-none">
                                        {{ $member->role === 'ketua' ? 'Ketua Panitia' : $member->role }}</p>
                                </div>
                            </div>

                            @if (in_array($comite->status, ['draft', 'pending']))
                                <button wire:click="removeMember({{ $member->id }})"
                                    wire:confirm="Yakin ingin menghapus anggota ini?"
                                    class="opacity-0 group-hover:opacity-100 p-1 text-gray-400 hover:text-red-600 transition-all rounded hover:bg-red-50"
                                    title="Hapus Anggota">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            @endif
                        </li>
                    @empty
                        <li class="text-xs text-gray-400 italic text-center py-2">Belum ada anggota.</li>
                    @endforelse
                </ul>

                <!-- Add Member Section -->
                @if (in_array($comite->status, ['draft', 'pending']))
                    <div class="mt-auto pt-3 border-t border-gray-100 space-y-3">
                        @php
                            $isKetuaPanitia = $sie->name === 'Ketua Panitia';
                            $hasKoor = $sie->members->where('role', 'koor')->count() > 0;
                            $canAddKoor = !$isKetuaPanitia && !$hasKoor && !in_array($sie->name, ['Penanggung Jawab', 'Steering Committee']);
                            $canAddAnggota = !$isKetuaPanitia || $sie->members->count() === 0;

                            // If Ketua Panitia and filled, can't add anyone.
                            if ($isKetuaPanitia && $sie->members->count() > 0) {
                                $canAddKoor = false;
                                $canAddAnggota = false;
                            }
                        @endphp

                        @if($canAddKoor)
                            <div>
                                <label class="text-[10px] font-semibold text-indigo-600 uppercase tracking-wider mb-1 block">Set
                                    Koordinator</label>
                                <div x-data="dropdownSearch('koor', {{ $sie->id }})" class="relative">
                                    <input type="text" x-model="query" @focus="open = true" @click.outside="open = false"
                                        class="block w-full rounded-md border-gray-300 py-1.5 text-xs shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder:text-gray-300"
                                        placeholder="Cari Koordinator..." :disabled="loading">

                                    <!-- Dropdown -->
                                    <div x-show="open && filteredPeople.length > 0"
                                        class="absolute bottom-full mb-1 left-0 w-full bg-white rounded-md shadow-lg border border-gray-200 max-h-48 overflow-y-auto z-20">
                                        <template x-for="person in filteredPeople" :key="person.id">
                                            <div @click="add(person.id)"
                                                class="px-3 py-2 hover:bg-indigo-50 cursor-pointer border-b border-gray-50 last:border-0">
                                                <p class="text-xs font-medium text-gray-800" x-text="person.name"></p>
                                                <p class="text-[10px] text-gray-500" x-text="person.nickname || ''"></p>
                                            </div>
                                        </template>
                                    </div>
                                    <div x-show="open && query.length > 0 && filteredPeople.length === 0"
                                        class="absolute bottom-full mb-1 left-0 w-full bg-white rounded-md shadow-lg border border-gray-200 p-2 text-xs text-gray-500 z-20">
                                        Tidak ditemukan
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($canAddAnggota)
                            <div>
                                <label class="text-[10px] font-semibold text-gray-500 uppercase tracking-wider mb-1 block">
                                    {{ $isKetuaPanitia ? 'Pilih Ketua' : 'Tambah Anggota' }}
                                </label>
                                <div x-data="dropdownSearch('{{ $isKetuaPanitia ? 'ketua' : 'anggota' }}', {{ $sie->id }})"
                                    class="relative">
                                    <input type="text" x-model="query" @focus="open = true" @click.outside="open = false"
                                        class="block w-full rounded-md border-gray-300 py-1.5 text-xs shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder:text-gray-300"
                                        placeholder="Cari {{ $isKetuaPanitia ? 'Ketua' : 'Anggota' }}..." :disabled="loading">

                                    <div x-show="loading" class="absolute right-2 top-1.5">
                                        <svg class="animate-spin h-4 w-4 text-indigo-500" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                    </div>

                                    <!-- Dropdown -->
                                    <div x-show="open && filteredPeople.length > 0"
                                        class="absolute bottom-full mb-1 left-0 w-full bg-white rounded-md shadow-lg border border-gray-200 max-h-48 overflow-y-auto z-20">
                                        <template x-for="person in filteredPeople" :key="person.id">
                                            <div @click="add(person.id)"
                                                class="px-3 py-2 hover:bg-indigo-50 cursor-pointer border-b border-gray-50 last:border-0">
                                                <p class="text-xs font-medium text-gray-800" x-text="person.name"></p>
                                                <p class="text-[10px] text-gray-500" x-text="person.nickname || ''"></p>
                                            </div>
                                        </template>
                                    </div>
                                    <div x-show="open && query.length > 0 && filteredPeople.length === 0"
                                        class="absolute bottom-full mb-1 left-0 w-full bg-white rounded-md shadow-lg border border-gray-200 p-2 text-xs text-gray-500 z-20">
                                        Tidak ditemukan
                                    </div>
                                </div>
                            </div>
                        @else
                            @if(!$canAddKoor)
                                <div class="text-center py-2 bg-gray-50 rounded border border-gray-100 border-dashed">
                                    <p class="text-xs text-gray-400">Sie Penuh / Terkunci</p>
                                </div>
                            @endif
                        @endif
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-full text-center py-10 bg-white rounded-lg border border-dashed border-gray-300">
                <p class="text-gray-500">Belum ada Sie yang dibuat.</p>
            </div>
        @endforelse
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('dropdownSearch', (role, sieId) => ({
                query: '',
                open: false,
                loading: false,
                role: role,
                sieId: sieId,

                get filteredPeople() {
                    if (this.query === '') return [];
                    const q = this.query.toLowerCase();
                    return this.availablePeople.filter(p =>
                        p.name.toLowerCase().includes(q) ||
                        (p.nickname && p.nickname.toLowerCase().includes(q))
                    ).slice(0, 10); // Limit results for speed
                },

                add(fungsioId) {
                    this.loading = true;
                    this.open = false;
                    this.$wire.addMember(this.sieId, fungsioId, this.role)
                        .then(() => {
                            this.loading = false;
                            this.query = ''; // Reset query on success
                            // availablePeople will be updated by Livewire re-render automatically 
                            // because blade will re-inject the updated list into parent x-data
                        })
                        .catch(() => {
                            this.loading = false;
                        });
                }
            }));
        });
    </script>
</div>