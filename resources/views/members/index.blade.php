<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Internal Panitia & Sie') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold">Total Panitia Ampera</h3>
                        <p class="text-gray-500 text-sm">Seluruh Panitia Terdaftar</p>
                    </div>
                    <div class="text-3xl font-bold text-blue-600">
                        {{ $groupedMembers->flatten()->count() }}
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                @foreach($groupedMembers as $divisionName => $members)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                            <h3 class="font-bold text-gray-800 uppercase tracking-wide">{{ $divisionName }}</h3>
                            <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded-full">
                                {{ $members->count() }} Panitia
                            </span>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach($members as $member)
                                    <div
                                        class="flex items-center space-x-3 p-3 rounded-lg border border-gray-100 hover:bg-blue-50 hover:border-blue-200 transition">

                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm">
                                            {{ substr($member->name, 0, 1) }}
                                        </div>

                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-bold text-gray-900 truncate">
                                                {{ $member->name }}
                                            </p>
                                            <p class="text-xs text-gray-500 truncate">
                                                {{ $member->division }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>