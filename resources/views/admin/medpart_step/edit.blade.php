<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Langkah Sistematika
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('medpart-steps.update', $medpartStep->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Urutan (Angka)</label>
                        <input type="number" name="order_number" value="{{ old('order_number', $medpartStep->order_number) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Singkat</label>
                        <textarea name="description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ old('description', $medpartStep->description) }}</textarea>
                    </div>

                    <div class="mb-6 flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" class="mr-2 leading-tight" value="1" {{ old('is_active', $medpartStep->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="text-gray-700 text-sm font-bold">Aktif Tampilkan</label>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none shadow">
                            Perbarui Data
                        </button>
                        <a href="{{ route('medpart-steps.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-800">
                            Batal
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
