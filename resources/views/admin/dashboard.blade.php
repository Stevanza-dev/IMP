<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pendaftaran AMPERA 2026') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('warning'))
                <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                    {{ session('warning') }}
                </div>
            @endif

            <!-- Toggle Button Pendaftaran -->
            <div class="mb-6 bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Status Pendaftaran</h3>
                        <p class="text-sm text-gray-600 mt-1">
                            Pendaftaran saat ini: 
                            <span class="font-bold {{ $registrationOpen ? 'text-green-600' : 'text-red-600' }}">
                                {{ $registrationOpen ? 'DIBUKA' : 'DITUTUP' }}
                            </span>
                        </p>
                    </div>
                    <form action="{{ route('admin.ampera.toggle') }}" method="POST">
                        @csrf
                        <button type="submit" 
                            class="px-6 py-3 rounded-lg font-semibold transition-all duration-200 shadow-md hover:shadow-lg
                                {{ $registrationOpen 
                                    ? 'bg-red-600 hover:bg-red-700 text-white' 
                                    : 'bg-green-600 hover:bg-green-700 text-white' }}">
                            {{ $registrationOpen ? 'Tutup Pendaftaran' : 'Buka Pendaftaran' }}
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <livewire:registrations-table />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>