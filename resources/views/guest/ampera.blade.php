<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMPERA 2026 - IMP</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Background Khusus AMPERA (Nuansa Hutan/Alam) */
        .ampera-hero {
            background-image: linear-gradient(rgba(6, 78, 59, 0.85), rgba(6, 78, 59, 0.7)), url('https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
    </style>
</head>
<body class="bg-emerald-50 text-gray-800 font-sans">

    @include('partials.header')

    <section class="ampera-hero h-screen flex items-center justify-center text-center px-4 relative mt-16 md:mt-0">
        <div class="max-w-4xl mx-auto text-white z-10 animate-fade-in-up">
            
            <div class="mb-6 flex justify-center">
                 <div class="w-20 h-20 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center border-2 border-white/50">
                    <i class="fas fa-tree text-3xl text-white"></i>
                 </div>
            </div>

            <p class="text-emerald-200 font-bold tracking-[0.2em] uppercase mb-4">IMP UNNES PRESENT</p>
            
            <h1 class="text-5xl md:text-7xl font-extrabold mb-4 leading-tight">
                AMPERA 2026
            </h1>
            
            <h2 class="text-xl md:text-2xl font-medium text-emerald-100 mb-8 italic">
                "Menanam Harapan, Mengabdi untuk Masa Depan"
            </h2>
            
            <div class="flex flex-col md:flex-row justify-center gap-4">
                <a href="{{ route('registration.create') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 px-10 rounded-full transition transform hover:scale-105 shadow-lg shadow-emerald-900/50 border border-emerald-400">
                    Daftar Sekarang
                </a>
                
                <a href="https://instagram.com/ampera_imp" target="_blank" class="bg-white text-emerald-900 font-bold py-4 px-10 rounded-full hover:bg-gray-100 transition flex items-center justify-center gap-2">
                    <i class="fab fa-instagram text-xl"></i> Instagram Official
                </a>
            </div>
        </div>
        
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none transform rotate-180">
            <svg class="relative block w-full h-[60px] md:h-[100px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" 
                    class="fill-emerald-50"></path> </svg>
        </div>
    </section>

    <section class="py-16 px-4 bg-emerald-50">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-10">
                <h3 class="text-2xl font-bold text-emerald-900 uppercase tracking-widest">Menuju Hari Pelaksanaan</h3>
                <p class="text-emerald-600 mt-2 font-semibold">
                    {{ \Carbon\Carbon::parse($amperaData->execution_date)->translatedFormat('l, d F Y') }}
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8 text-center max-w-3xl mx-auto">
                <div class="bg-white p-6 rounded-2xl shadow-lg border-b-4 border-emerald-500">
                    <div id="days" class="text-4xl md:text-6xl font-extrabold text-emerald-700">00</div>
                    <div class="text-xs md:text-sm text-gray-500 uppercase font-bold mt-2">Hari</div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-lg border-b-4 border-emerald-500">
                    <div id="hours" class="text-4xl md:text-6xl font-extrabold text-emerald-700">00</div>
                    <div class="text-xs md:text-sm text-gray-500 uppercase font-bold mt-2">Jam</div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-lg border-b-4 border-emerald-500">
                    <div id="minutes" class="text-4xl md:text-6xl font-extrabold text-emerald-700">00</div>
                    <div class="text-xs md:text-sm text-gray-500 uppercase font-bold mt-2">Menit</div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-lg border-b-4 border-emerald-500">
                    <div id="seconds" class="text-4xl md:text-6xl font-extrabold text-emerald-700">00</div>
                    <div class="text-xs md:text-sm text-gray-500 uppercase font-bold mt-2">Detik</div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            
            <div class="flex justify-center order-1 md:order-1">
                <div class="relative group">
                    <div class="absolute inset-0 bg-emerald-200 rounded-full blur-3xl opacity-30 group-hover:opacity-50 transition duration-500"></div>
                    <img src="{{ asset('images/ampera.png') }}" alt="Logo AMPERA 2026" class="relative z-10 w-80 md:w-96 drop-shadow-2xl hover:scale-105 transition duration-500">
                </div>
            </div>

            <div class="order-2 md:order-2">
                <div class="inline-block px-4 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold uppercase tracking-wide mb-4">
                    Identitas Visual
                </div>
                <h2 class="text-4xl font-bold text-gray-900 mb-6">Filosofi Logo <br><span class="text-emerald-600">AMPERA 2026</span></h2>
                
                <div class="space-y-6">
                    <div class="flex">
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                                <i class="fas fa-leaf"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-bold text-gray-800">Daun Tumbuh</h4>
                            <p class="text-gray-600 text-sm">Melambangkan harapan baru dan kontribusi nyata mahasiswa terhadap kelestarian lingkungan Pati.</p>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                                <i class="fas fa-hands-helping"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-bold text-gray-800">Tangan Terbuka</h4>
                            <p class="text-gray-600 text-sm">Simbol pengabdian tulus dan gotong royong melayani masyarakat desa.</p>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                                <i class="fas fa-water"></i> </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-bold text-gray-800">Warna Hijau & Emas</h4>
                            <p class="text-gray-600 text-sm">Hijau untuk kesejukan alam, Emas untuk kejayaan dan kualitas mahasiswa IMP.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="py-20 bg-emerald-900 text-white relative overflow-hidden">
        <i class="fas fa-tree absolute -bottom-10 -left-10 text-[20rem] text-emerald-800 opacity-20"></i>
        
        <div class="max-w-7xl mx-auto px-4 relative z-10 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-12">Misi Utama AMPERA 2026</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-emerald-800/50 backdrop-blur-sm p-8 rounded-2xl border border-emerald-700 hover:bg-emerald-800 transition">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-emerald-700 text-2xl mx-auto mb-6">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Reboisasi 1000 Pohon</h3>
                    <p class="text-emerald-200 text-sm leading-relaxed">
                        Menanam bibit pohon produktif dan perindang di kawasan kritis Kabupaten Pati untuk mencegah banjir dan erosi.
                    </p>
                </div>

                <div class="bg-emerald-800/50 backdrop-blur-sm p-8 rounded-2xl border border-emerald-700 hover:bg-emerald-800 transition">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-emerald-700 text-2xl mx-auto mb-6">
                        <i class="fas fa-people-carry"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Bakti Sosial Desa</h3>
                    <p class="text-emerald-200 text-sm leading-relaxed">
                        Menyalurkan bantuan sembako dan renovasi fasilitas umum untuk masyarakat desa binaan IMP.
                    </p>
                </div>

                <div class="bg-emerald-800/50 backdrop-blur-sm p-8 rounded-2xl border border-emerald-700 hover:bg-emerald-800 transition">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-emerald-700 text-2xl mx-auto mb-6">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Edukasi Lingkungan</h3>
                    <p class="text-emerald-200 text-sm leading-relaxed">
                        Memberikan sosialisasi pengolahan sampah dan pentingnya menjaga ekosistem kepada anak-anak sekolah dasar.
                    </p>
                </div>
            </div>
            
            <div class="mt-12">
                <a href="{{ route('registration.create') }}" class="inline-block bg-yellow-500 hover:bg-yellow-400 text-black font-bold py-3 px-8 rounded-full transition shadow-lg">
                    Jadilah Relawan Sekarang
                </a>
            </div>
        </div>
    </section>

    @include('partials.footer')


    <script>
        // Ambil tanggal dari Variabel PHP (Database)
        // Format harus YYYY-MM-DD HH:MM:SS
        const targetDate = new Date("{{ $amperaData->execution_date }} 08:00:00").getTime();

        const timer = setInterval(function() {
            const now = new Date().getTime();
            const distance = targetDate - now;

            // Perhitungan Waktu
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Update HTML (Pastikan format 2 digit, misal 05)
            document.getElementById("days").innerText = days < 10 ? "0" + days : days;
            document.getElementById("hours").innerText = hours < 10 ? "0" + hours : hours;
            document.getElementById("minutes").innerText = minutes < 10 ? "0" + minutes : minutes;
            document.getElementById("seconds").innerText = seconds < 10 ? "0" + seconds : seconds;

            // Jika waktu habis
            if (distance < 0) {
                clearInterval(timer);
                document.getElementById("days").innerText = "00";
                document.getElementById("hours").innerText = "00";
                document.getElementById("minutes").innerText = "00";
                document.getElementById("seconds").innerText = "00";
                // Bisa tambahkan alert atau ubah teks
            }
        }, 1000);
    </script>

</body>
</html>