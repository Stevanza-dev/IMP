<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil - AMPERA 2026</title>
    <link rel="icon" href="{{ asset('images/logonocap.png') }}" type="image/png">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        @keyframes scale-in {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-scale-in {
            animation: scale-in 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }
    </style>
</head>

<body class="bg-emerald-50 text-gray-800 font-sans min-h-screen flex flex-col">

    @include('partials.header')

    <main class="flex-grow flex items-center justify-center p-4">
        <div
            class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 text-center border-t-4 border-emerald-600 animate-scale-in">

            <div class="mb-6">
                <div class="mx-auto w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-check-circle text-5xl text-emerald-600"></i>
                </div>
            </div>

            <h1 class="text-3xl font-extrabold text-emerald-900 mb-4">
                Pendaftaran Berhasil
            </h1>

            <p class="text-lg text-gray-600 mb-8 font-medium leading-relaxed">
                Tiket akan dikirimkan ke Email Anda secara berkala. Jangan Lupa Konfirmasi ke Narahubung di bawah ini.
            </p>

            <div class="space-y-4">
                <div class="space-y-2">
                    <a href="https://wa.me/6287822043478" target="_blank"
                        class="inline-block w-full py-3 px-6 rounded-lg bg-green-500 text-white font-bold hover:bg-green-600 transition transform hover:scale-105 shadow-md">
                        <i class="fab fa-whatsapp mr-2"></i> Annas
                    </a>
                    <a href="https://wa.me/6285729922581" target="_blank"
                        class="inline-block w-full py-3 px-6 rounded-lg bg-green-500 text-white font-bold hover:bg-green-600 transition transform hover:scale-105 shadow-md">
                        <i class="fab fa-whatsapp mr-2"></i> Uta
                    </a>
                </div>

                <a href="{{ route('ampera') }}"
                    class="inline-block w-full py-3 px-6 rounded-lg bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition transform hover:scale-105 shadow-md">
                    <i class="fas fa-home mr-2"></i> Kembali ke Beranda
                </a>
            </div>

            <p class="mt-8 text-xs text-gray-400">
                &copy; 2025 Ikatan Mahasiswa Pati
            </p>
        </div>
    </main>

</body>

</html>