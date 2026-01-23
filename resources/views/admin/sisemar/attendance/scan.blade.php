<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Scan E-Ticket Peserta SI SEMAR') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <livewire:sisemar-scan />
    </div>
</x-app-layout>
