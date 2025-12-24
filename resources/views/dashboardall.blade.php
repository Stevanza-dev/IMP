<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Utama') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Welcome Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                    <p class="mt-2 text-gray-600">
                        Ini adalah halaman pusat kontrol untuk semua sistem manajemen IMP.
                        Silakan pilih menu di bawah ini sesuai dengan hak akses yang Anda miliki.
                    </p>
                </div>
            </div>

            <!-- Grid Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- 1. KARTU USER IMP (Pengurus Inti) -->
                @can('manage imp')
                    <div
                        class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg transform hover:scale-105 transition duration-300 overflow-hidden text-white relative">
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="text-xl font-bold">IMP Management</h4>
                                    <p class="text-blue-100 text-sm mt-1">Sistem Tata Kelola Organisasi</p>
                                </div>
                                <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                    <i class="fas fa-users text-2xl"></i>
                                </div>
                            </div>
                            <p class="mt-4 text-sm text-blue-50 opacity-90">
                                Kelola data anggota, divisi, program kerja, dan inventaris organisasi IMP secara terpusat.
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('divisions.index') }}"
                                    class="inline-block bg-white text-blue-600 font-semibold px-4 py-2 rounded-lg shadow hover:bg-gray-100 transition">
                                    Masuk Dashboard IMP &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @endcan

                <!-- 2. KARTU AMPERA (Event Manager) -->
                @can('manage ampera')
                    <div
                        class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl shadow-lg transform hover:scale-105 transition duration-300 overflow-hidden text-white relative">
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="text-xl font-bold">AMPERA 2026</h4>
                                    <p class="text-emerald-100 text-sm mt-1">Aksi Mahasiswa Peduli Konservasi Pati</p>
                                </div>
                                <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                    <i class="fas fa-ticket-alt text-2xl"></i>
                                </div>
                            </div>
                            <p class="mt-4 text-sm text-emerald-50 opacity-90">
                                Kelola pendaftaran peserta, validasi pembayaran, tiket, dan absensi event Ampera.
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('admin.ampera.dashboard') }}"
                                    class="inline-block bg-white text-emerald-600 font-semibold px-4 py-2 rounded-lg shadow hover:bg-gray-100 transition">
                                    Kelola Event &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @endcan

                <!-- 3. KARTU SI SEMAR (Sekolah Binaan) -->
                @can('manage sisemar')
                    <div
                        class="bg-gradient-to-br from-orange-500 to-red-500 rounded-xl shadow-lg transform hover:scale-105 transition duration-300 overflow-hidden text-white relative">
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="text-xl font-bold">SI SEMAR 2026</h4>
                                    <p class="text-orange-100 text-sm mt-1">Simulasi Seleksi Masuk Perguruan Tinggi Negeri
                                    </p>
                                </div>
                                <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                    <i class="fas fa-graduation-cap text-2xl"></i>
                                </div>
                            </div>
                            <p class="mt-4 text-sm text-orange-50 opacity-90">
                                Manajemen Pendaftaran Peserta, Penukaran Tiket dan Absen Hari H.
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('admin.sisemar.index') }}"
                                    class="inline-block bg-white text-orange-600 font-semibold px-4 py-2 rounded-lg shadow hover:bg-gray-100 transition">
                                    Kelola Event &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @endcan

                <!-- 4. KARTU SUPER ADMIN -->
                @role('super-admin')
                <div
                    class="bg-gradient-to-br from-gray-700 to-gray-900 rounded-xl shadow-lg transform hover:scale-105 transition duration-300 overflow-hidden text-white relative">
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-xl font-bold">Super Admin</h4>
                                <p class="text-gray-300 text-sm mt-1">Pengaturan Sistem</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <i class="fas fa-cogs text-2xl"></i>
                            </div>
                        </div>
                        <p class="mt-4 text-sm text-gray-300 opacity-90">
                            Kelola role pengguna, konfigurasi website, dan permission akses global.
                        </p>
                        <div class="mt-6">
                            <a href="#"
                                class="inline-block bg-white text-gray-800 font-semibold px-4 py-2 rounded-lg shadow hover:bg-gray-100 transition">
                                Atur Sistem &rarr;
                            </a>
                        </div>
                    </div>
                </div>
                @endrole

            </div>

            <!-- Footer Quote or Info -->
            <div class="mt-12 text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} Ikatan Mahasiswa Pati (IMP) UNNES. All rights reserved.
            </div>

        </div>
    </div>
</x-app-layout>