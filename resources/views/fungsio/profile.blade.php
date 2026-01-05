<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Fungsionaris') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Data Fungsio Anda</h3>

                    @if (session('status'))
                        <div class="mb-4 text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('fungsio.profile.update') }}" class="space-y-6" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Akun</label>
                            <p class="mt-1 text-sm text-gray-900 font-semibold">{{ $user->name }} ({{ $user->email }})</p>
                        </div>

                        <div>
                            <label for="division_id" class="block text-sm font-medium text-gray-700">Divisi<span class="text-red-500">*</span></label>
                            <select id="division_id" name="division_id" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">-- Pilih Divisi --</option>
                                @foreach ($divisions as $division)
                                    <option value="{{ $division->id }}" @selected(old('division_id', $fungsio->division_id) == $division->id)>
                                        {{ $division->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('division_id')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="period_id" class="block text-sm font-medium text-gray-700">Periode<span class="text-red-500">*</span></label>
                            <select id="period_id" name="period_id" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">-- Pilih Periode --</option>
                                @foreach ($periods as $period)
                                    <option value="{{ $period->id }}" @selected(old('period_id', $fungsio->period_id) == $period->id)>
                                        {{ $period->tahun }}
                                    </option>
                                @endforeach
                            </select>
                            @error('period_id')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="nickname" class="block text-sm font-medium text-gray-700">Nama Panggilan<span class="text-red-500">*</span></label>
                                <input id="nickname" name="nickname" type="text" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    value="{{ old('nickname', $fungsio->nickname) }}">
                                @error('nickname')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nim" class="block text-sm font-medium text-gray-700">NIM<span class="text-red-500">*</span></label>
                                <input id="nim" name="nim" type="text" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    value="{{ old('nim', $fungsio->nim) }}">
                                @error('nim')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="jabatan" class="block text-sm font-medium text-gray-700">Jabatan<span class="text-red-500">*</span></label>
                            <input id="jabatan" name="jabatan" type="text" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                value="{{ old('jabatan', $fungsio->jabatan) }}">
                            @error('jabatan')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="no_hp" class="block text-sm font-medium text-gray-700">No HP<span class="text-red-500">*</span></label>
                                <input id="no_hp" name="no_hp" type="text" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    value="{{ old('no_hp', $fungsio->no_hp) }}">
                                @error('no_hp')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status<span class="text-red-500">*</span></label>
                                <select id="status" name="status" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="aktif" @selected(old('status', $fungsio->status) == 'aktif')>Aktif</option>
                                    <option value="alumni" @selected(old('status', $fungsio->status) == 'alumni')>Alumni</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Domisili<span class="text-red-500">*</span></label>
                            <textarea id="alamat" name="alamat" rows="3" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('alamat', $fungsio->alamat) }}</textarea>
                            @error('alamat')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                            <div>
                                <label for="foto" class="block text-sm font-medium text-gray-700">Foto Profil (opsional)</label>
                                <input id="foto" name="foto" type="file" accept="image/jpeg,image/png,image/jpg"
                                    class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500" />
                                <p class="mt-1 text-xs text-gray-500">Maksimal 2MB, format: JPG atau PNG.</p>
                                @error('foto')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            @if ($fungsio->foto_url)
                                <div>
                                    <span class="block text-sm font-medium text-gray-700 mb-1">Foto Saat Ini</span>
                                    <img src="{{ $fungsio->foto_url }}" alt="Foto Profil Fungsio" class="h-32 w-32 object-cover rounded-full border" />
                                </div>
                            @endif
                        </div>

                        <div class="pt-4 flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
