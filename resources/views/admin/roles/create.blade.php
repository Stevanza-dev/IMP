<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($role) ? 'Edit Role: ' . ucfirst($role->name) : 'Buat Role Baru' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ isset($role) ? route('role.update', $role->id) : route('role.store') }}">
                        @csrf
                        @if(isset($role))
                            @method('PUT')
                        @endif

                        <!-- Nama Role -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Role
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name"
                                value="{{ isset($role) ? $role->name : old('name') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                                placeholder="Misal: manager, editor, viewer"
                                required
                            >
                            @error('name')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Permissions -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Pilih Permission</h3>
                            
                            <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                                @forelse($permissions as $guardName => $permissionGroup)
                                    <div class="border-l-4 border-blue-500 pl-4">
                                        <h4 class="font-medium text-gray-700 mb-3 capitalize">
                                            {{ $guardName }} Permissions
                                        </h4>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            @foreach($permissionGroup as $permission)
                                                <label class="flex items-center space-x-3 p-2 hover:bg-white rounded">
                                                    <input 
                                                        type="checkbox" 
                                                        name="permissions[]" 
                                                        value="{{ $permission->id }}"
                                                        {{ isset($rolePermissions) && in_array($permission->id, $rolePermissions) ? 'checked' : '' }}
                                                        class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500"
                                                    >
                                                    <span class="text-sm text-gray-700">
                                                        {{ $permission->name }}
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-4 text-gray-500">
                                        <p>Tidak ada permission tersedia. Jalankan seeder untuk menambah permissions.</p>
                                    </div>
                                @endforelse
                            </div>
                            @error('permissions')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-4">
                            <button 
                                type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                                <i class="fas fa-save"></i> {{ isset($role) ? 'Update Role' : 'Buat Role' }}
                            </button>
                            <a 
                                href="{{ route('role.index') }}"
                                class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 focus:outline-none"
                            >
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
