<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek E-Tiket AMPERA 2026</title>
    <link rel="icon" href="{{ asset('images/logonocap.png') }}" type="image/png">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-emerald-50 text-gray-800 font-sans">

    @include('partials.header')

    <section class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 mt-16 md:mt-0">

        <div class="max-w-3xl mx-auto">

            <div class="mb-12 mt-12 text-center">
                <div
                    class="inline-block px-4 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold uppercase tracking-wide mb-4">
                    E-Ticket System
                </div>
                <h1 class="text-4xl md:text-5xl font-extrabold text-emerald-900 tracking-tight">Cek Tiket AMPERA</h1>
                <p class="mt-4 text-lg text-emerald-700 font-semibold">Pastikan Datamu Terdaftar</p>
                <p class="text-sm text-gray-600 mt-2">Silakan masukkan Email atau Kode Tiket yang telah dikirim.</p>
            </div>

            <div class="bg-white p-8 md:p-10 rounded-2xl shadow-xl border-t-4 border-emerald-600 mb-8">
                <form action="{{ route('ampera.ticket.check') }}" method="GET" class="space-y-4">
                    <div>
                        <label for="search" class="block text-sm font-semibold text-gray-700 mb-2">Cari Peserta</label>
                        <div class="flex gap-2">
                            <input type="text" name="search" id="search" placeholder="Masukkan Email / Kode Tiket..."
                                value="{{ request('search') }}"
                                class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition bg-white"
                                required>
                            <button type="submit"
                                class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-lg font-bold transition shadow-lg flex items-center gap-2">
                                <i class="fas fa-search"></i> <span class="hidden sm:inline">Cek</span>
                            </button>
                        </div>
                    </div>
                </form>

                @if (session('error'))
                    <div class="mt-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-start gap-3">
                        <i class="fas fa-exclamation-circle text-lg mt-0.5"></i>
                        <div>
                            <strong class="font-bold block">Maaf, Data Tidak Ditemukan.</strong>
                            <span class="text-sm">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif
            </div>

            @if(isset($ticket))
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-200 relative">
                    <!-- Decorative Circles -->
                    <div
                        class="absolute top-0 right-0 -mr-16 -mt-16 w-32 h-32 bg-emerald-100 rounded-full opacity-50 blur-3xl">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 -ml-16 -mb-16 w-32 h-32 bg-emerald-100 rounded-full opacity-50 blur-3xl">
                    </div>

                    <div
                        class="bg-gradient-to-r from-emerald-600 to-green-600 px-8 py-6 text-white flex justify-between items-center relative z-10">
                        <div>
                            <p class="text-xs text-emerald-100 font-bold tracking-widest uppercase mb-1">Official E-Ticket
                            </p>
                            <h2 class="text-2xl font-extrabold tracking-tight">AMPERA 2026</h2>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold">18 JAN 2026</p>
                            <p class="text-xs text-emerald-100 flex items-center justify-end gap-1">
                                <i class="fas fa-map-marker-alt"></i> Wukirsari, Tambakromo, Jawa Tengah
                            </p>
                        </div>
                    </div>

                    <div class="p-8 relative z-10">
                        <div class="flex flex-col md:flex-row justify-between items-start gap-8">
                            <div class="flex-1 space-y-6">
                                <div>
                                    <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Nama Peserta
                                    </p>
                                    <p class="text-xl md:text-2xl font-bold text-gray-900">{{ $ticket->name }}</p>
                                </div>

                                <div>
                                    <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Instansi /
                                        Sekolah</p>
                                    <p class="text-lg font-medium text-gray-800">{{ $ticket->institution }}</p>
                                </div>

                                <div class="flex gap-8">
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Status</p>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i> Terverifikasi
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Kode Tiket
                                        </p>
                                        <p class="text-lg font-mono font-bold text-emerald-600 tracking-widest">
                                            {{ $ticket->ticket_code }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="flex flex-col items-center justify-center bg-gray-50 p-4 rounded-xl border border-gray-100 shadow-inner w-full md:w-auto">
                                <div class="bg-white p-2 rounded-lg shadow-sm mb-3">
                                    {!! QrCode::size(160)->generate($ticket->ticket_code) !!}
                                </div>
                                <p class="text-[10px] text-center text-gray-400 max-w-[160px]">
                                    Tunjukkan QR Code ini kepada panitia saat registrasi ulang.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-8 py-4 border-t border-gray-200 flex justify-center md:justify-end">
                        <button onclick="window.print()"
                            class="text-emerald-700 hover:text-emerald-800 font-bold text-sm flex items-center gap-2 transition hover:underline">
                            <i class="fas fa-print"></i> Cetak / Simpan PDF
                        </button>
                    </div>
                </div>
            @endif

        </div>

        <p class="mt-8 text-center text-xs text-gray-500">
            &copy; 2025 Ikatan Mahasiswa Pati. All rights reserved.
        </p>
    </section>

</body>

</html>