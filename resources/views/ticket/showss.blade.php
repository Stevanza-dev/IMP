<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek E-Tiket SI SEMAR 2026</title>
    <link rel="icon" href="{{ asset('images/logonocap.png') }}" type="image/png">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-royal {
            font-family: 'Cinzel', serif;
        }

        /* Sky Theme Background similar to Sisemar Landing */
        .sisemar-bg {
            background: linear-gradient(180deg, #bae6fd 0%, #f0f9ff 100%);
            min-height: 100vh;
        }
    </style>
</head>

<body class="sisemar-bg text-gray-800 font-sans">

    @include('partials.header')

    <section class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 mt-16 md:mt-0">

        <div class="max-w-3xl mx-auto">

            <div class="mb-12 mt-12 text-center">
                <div
                    class="inline-block px-4 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold uppercase tracking-wide mb-4 border border-blue-200">
                    Official Ticket System
                </div>
                <!-- Title similar to Sisemar Landing -->
                <h1 class="text-4xl md:text-5xl font-black text-blue-900 tracking-tight font-royal">
                    <span class="text-yellow-600 block drop-shadow-sm">SI SEMAR 2026</span>
                </h1>
                <p class="mt-4 text-lg text-blue-800 font-semibold">Gerbang Masa Depanmu Ada Di Sini</p>
                <p class="text-sm text-gray-600 mt-2">Masukkan Email atau Kode E-Ticket untuk pengecekan.</p>
            </div>

            <!-- Search Form Card -->
            <div
                class="bg-white p-8 md:p-10 rounded-2xl shadow-xl border-t-4 border-blue-600 mb-8 relative overflow-hidden">
                <!-- Decorative Circle -->
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-yellow-100 rounded-full opacity-30 -mr-16 -mt-16 blur-2xl">
                </div>

                <form action="{{ route('sisemar.ticket.check') }}" method="GET" class="space-y-4 relative z-10">
                    <div>
                        <label for="search" class="block text-sm font-semibold text-gray-700 mb-2">Cari Peserta</label>
                        <div class="flex gap-2">
                            <input type="text" name="search" id="search" placeholder="Masukkan Email / Kode E-Ticket..."
                                value="{{ request('search') }}"
                                class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition bg-white"
                                required>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-bold transition shadow-lg flex items-center gap-2 border-b-4 border-blue-800 active:border-b-0 active:translate-y-1">
                                <i class="fas fa-search"></i> <span class="hidden sm:inline">Cek Tiket</span>
                            </button>
                        </div>
                    </div>
                </form>

                @if (session('error'))
                    <div
                        class="mt-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-start gap-3 relative z-10 animate-bounce">
                        <i class="fas fa-exclamation-circle text-lg mt-0.5"></i>
                        <div>
                            <strong class="font-bold block">Maaf, Data Tidak Ditemukan.</strong>
                            <span class="text-sm">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Ticket Result -->
            @if(isset($ticket))
                <div
                    class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-200 relative transform transition hover:scale-[1.01] duration-300">
                    <!-- Ticket Header -->
                    <div
                        class="bg-gradient-to-r from-blue-800 to-indigo-900 px-8 py-6 text-white flex justify-between items-center relative z-10">
                        <div>
                            <p class="text-xs text-blue-200 font-bold tracking-widest uppercase mb-1">Pass Masuk Resmi
                            </p>
                            <h2 class="text-2xl font-black tracking-tight font-royal text-yellow-400 drop-shadow-md">
                                SI SEMAR 2026
                            </h2>
                        </div>
                        <div class="text-right">
                            <div
                                class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center ml-auto border border-white/20 shadow-inner">
                                <i class="fas fa-crown text-yellow-300 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 relative z-10">
                        <!-- Watermark -->
                        <div class="absolute inset-0 flex items-center justify-center opacity-[0.03] pointer-events-none">
                            <i class="fas fa-crown text-9xl"></i>
                        </div>

                        <div class="flex flex-col md:flex-row justify-between items-start gap-8 relative z-10">
                            <div class="flex-1 space-y-6">
                                <div>
                                    <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Nama Peserta
                                    </p>
                                    <p class="text-xl md:text-2xl font-bold text-gray-900 uppercase">{{ $ticket->name }}</p>
                                </div>

                                <div>
                                    <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Asal Sekolah
                                    </p>
                                    <p class="text-lg font-medium text-gray-800">{{ $ticket->school }}</p>
                                </div>

                                <div>
                                    <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Pilihan Jurusan
                                    </p>
                                    <p class="text-sm text-gray-700 font-medium">1. {{ $ticket->major_preference_1 }}</p>
                                    <p class="text-sm text-gray-700 font-medium">2. {{ $ticket->major_preference_2 }}</p>
                                </div>

                                <div class="flex flex-wrap gap-8 border-t border-gray-100 pt-4">
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Status</p>
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">
                                            <i class="fas fa-check-circle mr-1"></i> RESMI TERDAFTAR
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Kode
                                            E-Ticket
                                        </p>
                                        <p
                                            class="text-lg font-mono font-bold text-blue-600 tracking-widest bg-blue-50 px-2 rounded">
                                            {{ $ticket->e_ticket_code }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="flex flex-col items-center justify-center bg-blue-50 p-5 rounded-xl border border-blue-100 shadow-inner w-full md:w-auto">
                                <div class="bg-white p-2 rounded-lg shadow-sm mb-3">
                                    {!! QrCode::size(150)->generate($ticket->e_ticket_code) !!}
                                </div>
                                <p class="text-[10px] text-center text-gray-500 font-medium max-w-[160px] leading-tight">
                                    Tunjukkan QR ini kepada panitia saat Penukaran Tiket.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-8 py-4 border-t border-gray-200 flex justify-center md:justify-end">
                        <button onclick="window.print()"
                            class="text-blue-700 hover:text-blue-900 font-bold text-sm flex items-center gap-2 transition hover:bg-blue-100 px-4 py-2 rounded-lg">
                            <i class="fas fa-print"></i> Cetak / Simpan PDF
                        </button>
                    </div>
                </div>
            @endif

        </div>

        <p class="mt-12 text-center text-xs text-gray-500">
            &copy; 2026 Ikatan Mahasiswa Pati. All rights reserved.
        </p>
    </section>

</body>

</html>