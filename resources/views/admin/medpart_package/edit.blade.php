<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Paket Medpart
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
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

                <form action="{{ route('medpart-packages.update', $medpartPackage->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Paket</label>
                            <input type="text" name="name" value="{{ old('name', $medpartPackage->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Harga (Rp)</label>
                            <input type="number" name="price" value="{{ old('price', $medpartPackage->price) }}" min="0" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>
                    </div>

                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-3 border-b pb-2">
                            <label class="block text-gray-700 text-sm font-bold text-pink-600">Syarat & Ketentuan</label>
                            <button type="button" onclick="addInput('req-container', 'requirements[]')" class="text-xs bg-pink-100 text-pink-700 hover:bg-pink-200 px-2 py-1 rounded font-bold">+ Tambah</button>
                        </div>
                        <div id="req-container" class="space-y-3">
                            @forelse($medpartPackage->requirements as $req)
                                <div class="flex gap-2 items-start">
                                    <input type="text" name="requirements[]" value="{{ old('requirements.'.$loop->index, $req->content) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 text-sm" required>
                                    <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 mt-2"><i class="fas fa-times"></i></button>
                                </div>
                            @empty
                                <div class="flex gap-2 items-start">
                                    <input type="text" name="requirements[]" placeholder="Isi syarat..." class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 text-sm" required>
                                    <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 mt-2"><i class="fas fa-times"></i></button>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-3 border-b pb-2">
                            <label class="block text-gray-700 text-sm font-bold text-orange-600">Feedback Layanan</label>
                            <button type="button" onclick="addInput('fb-container', 'feedbacks[]')" class="text-xs bg-orange-100 text-orange-700 hover:bg-orange-200 px-2 py-1 rounded font-bold">+ Tambah</button>
                        </div>
                        <div id="fb-container" class="space-y-3">
                            @forelse($medpartPackage->feedbacks as $fb)
                                <div class="flex gap-2 items-start">
                                    <input type="text" name="feedbacks[]" value="{{ old('feedbacks.'.$loop->index, $fb->content) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 text-sm" required>
                                    <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 mt-2"><i class="fas fa-times"></i></button>
                                </div>
                            @empty
                                <div class="flex gap-2 items-start">
                                    <input type="text" name="feedbacks[]" placeholder="Isi feedback..." class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 text-sm" required>
                                    <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 mt-2"><i class="fas fa-times"></i></button>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="mb-8 flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" class="mr-2 border-gray-300 rounded text-blue-600" value="1" {{ old('is_active', $medpartPackage->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="text-gray-700 text-sm font-bold">Aktif Tampilkan</label>
                    </div>

                    <div class="flex items-center justify-between border-t border-gray-100 pt-6">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded focus:outline-none shadow">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('medpart-packages.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-800">
                            Batal
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function addInput(containerId, nameAttr) {
            const container = document.getElementById(containerId);
            const div = document.createElement('div');
            div.className = 'flex gap-2 items-start';
            div.innerHTML = `
                <input type="text" name="${nameAttr}" placeholder="Isi poin..." class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 text-sm" required>
                <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 mt-2"><i class="fas fa-times"></i></button>
            `;
            container.appendChild(div);
        }
    </script>
</x-app-layout>
