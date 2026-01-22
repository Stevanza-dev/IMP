<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Kepanitiaan Saya') }}
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
                    <a href="{{ route('fungsio.comite.index', ['tab' => 'my']) }}" class="text-sm text-indigo-600 hover:text-indigo-500">&larr; Kembali</a>
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
                                Dibuat oleh: {{ $comite->createdBy->user->name ?? '-' }}<br>
                                @if ($comite->verified_at)
                                    @if ($comite->verifiedBy)
                                        Diverifikasi oleh: {{ $comite->verifiedBy->user->name ?? '-' }}<br>
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
                                                    {{ $member->fungsio->user->name ?? '-' }}
                                                </div>
                                            </li>
                                        @empty
                                            <li class="text-xs text-gray-400">Belum ada anggota.</li>
                                        @endforelse
                                    </ul>
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
