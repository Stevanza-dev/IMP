<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($program) ? 'Edit Program Kerja' : 'Tambah Program Kerja' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-lg shadow">
                
                <form action="{{ isset($program) ? route('programs.update', $program->id) : route('programs.store') }}" method="POST">
                    @csrf
                    @if(isset($program)) @method('PUT') @endif

                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">Divisi Penanggung Jawab</label>
                        <select name="division_id" class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500">
                            @foreach($divisions as $div)
                                <option value="{{ $div->id }}" {{ (isset($program) && $program->division_id == $div->id) ? 'selected' : '' }}>
                                    {{ $div->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">Nama Program Kerja</label>
                        <input type="text" name="name" value="{{ old('name', $program->name ?? '') }}" class="w-full border-gray-300 rounded shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">Tanggal Pelaksanaan</label>
                        <input type="date" name="execution_date" value="{{ old('execution_date', isset($program) ? \Carbon\Carbon::parse($program->execution_date)->format('Y-m-d') : '') }}" class="w-full border-gray-300 rounded shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">Deskripsi Singkat</label>
                        <textarea name="description" rows="3" class="w-full border-gray-300 rounded shadow-sm" required>{{ old('description', $program->description ?? '') }}</textarea>
                    </div>

                    <div class="mb-6 flex items-center">
                        <input type="checkbox" name="is_active" value="1" id="active" class="rounded text-blue-600 focus:ring-blue-500" 
                            {{ (isset($program) && $program->is_active) ? 'checked' : '' }}>
                        <label for="active" class="ml-2 text-sm text-gray-700 font-bold">Status Aktif / Akan Datang</label>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('programs.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded font-bold">Simpan Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>