<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMP UNNES - Ikatan Mahasiswa Pati</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hero-bg {
            background-image: linear-gradient(rgba(0, 51, 102, 0.7), rgba(0, 51, 102, 0.6)), url('https://images.unsplash.com/photo-1523580494863-6f3031224c94?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    @include('partials.header')

    <section class="hero-bg h-screen flex items-center justify-center text-center px-4 relative mt-16 md:mt-0">
        <div class="max-w-4xl mx-auto text-white z-10 animate-fade-in-up">
            <p class="text-blue-200 font-semibold tracking-wider uppercase mb-2">Satu Jiwa • Satu Kota • Satu Nama</p>
            <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight">
                IKATAN MAHASISWA PATI<br>
                <span class="text-blue-400">UNNES</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-200 mb-8 max-w-2xl mx-auto">
                Pindah berkala Rumah ke Rumah, mengambil pelajaran jika berpisah. Jikalau suatu saat berujung indah, catat nama kita dalam sejarah.
            </p>
            <div class="flex justify-center gap-4">
                <a href="#program" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-full transition transform hover:scale-105 shadow-lg">
                    Lihat Program
                </a>
                <a href="#about" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/30 text-white font-bold py-3 px-8 rounded-full transition">
                    Tentang Kami
                </a>
            </div>
        </div>
    </section>

    <section class="relative -mt-16 md:-mt-20 z-20 px-4">
        <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-xl p-8 grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-gray-100">
            <div class="text-center py-4">
                <div class="text-4xl font-extrabold text-blue-600 mb-1">37</div>
                <div class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Tahun Berdiri</div>
            </div>
            <div class="text-center py-4">
                <div class="text-4xl font-extrabold text-blue-600 mb-1">112</div>
                <div class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Fungsionaris Aktif</div>
            </div>
            <div class="text-center py-4">
                <div class="text-4xl font-extrabold text-blue-600 mb-1">10+</div>
                <div class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Program Kerja</div>
            </div>
        </div>
    </section>

    <section id="about" class="py-20 md:py-32 px-4">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            
            <div class="relative order-2 md:order-1">
                <div class="absolute -top-4 -left-4 w-24 h-24 bg-blue-100 rounded-full z-0"></div>
                <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-yellow-100 rounded-full z-0"></div>
                <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" 
                     alt="Kegiatan IMP" 
                     class="relative z-10 rounded-2xl shadow-2xl w-full object-cover h-[400px]">
            </div>

            <div class="order-1 md:order-2">
                <h4 class="text-blue-600 font-bold uppercase tracking-wide mb-2">Tentang Kami</h4>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 leading-tight">
                    Mengenal Lebih Dekat <br>IMP UNNES
                </h2>
                <p class="text-gray-600 text-lg mb-6 leading-relaxed">
                    Ikatan Mahasiswa Pati Universitas Negeri Semarang (IMP UNNES) adalah organisasi daerah yang menaungi mahasiswa asal Kabupaten Pati yang sedang menempuh studi di UNNES.
                </p>
                <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                    Berdiri sejak 37 tahun lalu, kami berkomitmen untuk menciptakan rasa kekeluargaan yang erat (seduluran), mengembangkan potensi akademik maupun non-akademik, serta memberikan kontribusi nyata bagi masyarakat Pati dan lingkungan kampus.
                </p>
                <a href="#" class="inline-flex items-center text-blue-700 font-bold hover:text-blue-800 transition">
                    Pelajari Sejarah Kami <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <section id="program" class="py-20 bg-blue-50 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Program Kerja Unggulan</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Berbagai kegiatan positif yang kami rancang untuk pengembangan diri anggota dan kebermanfaatan bagi masyarakat.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($programs as $proker)
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition duration-300 overflow-hidden group border border-gray-100 flex flex-col">
                    <div class="h-2 bg-blue-600 w-0 group-hover:w-full transition-all duration-500"></div>
                    
                    <div class="p-8 flex-grow">
                        <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 mb-6 text-2xl group-hover:scale-110 transition">
                            <i class="fas fa-star"></i> </div>

                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition">
                            {{ $proker->name }}
                        </h3>
                        <p class="text-gray-500 text-sm leading-relaxed mb-4">
                            {{ Str::limit($proker->description, 100) }}
                        </p>
                        
                        <div class="flex items-center text-xs text-gray-400 font-medium uppercase tracking-wide">
                            <i class="far fa-calendar-alt mr-2"></i>
                            {{ \Carbon\Carbon::parse($proker->execution_date)->translatedFormat('d F Y') }}
                        </div>
                    </div>
                    
                    <div class="px-8 pb-8">
                        <a href="#" class="text-blue-600 text-sm font-bold hover:underline flex items-center">
                            Selengkapnya <i class="fas fa-chevron-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="#" class="inline-block border-2 border-blue-600 text-blue-600 font-bold py-3 px-8 rounded-full hover:bg-blue-600 hover:text-white transition duration-300">
                    Lihat Semua Program Kerja
                </a>
            </div>
        </div>
    </section>

    <section class="py-20 px-4">
        <div class="max-w-5xl mx-auto bg-gradient-to-r from-blue-700 to-blue-900 rounded-3xl p-10 md:p-16 text-center text-white relative overflow-hidden shadow-2xl">
            <div class="absolute top-0 left-0 w-64 h-64 bg-white opacity-5 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full translate-x-1/2 translate-y-1/2"></div>
            
            <h2 class="text-3xl md:text-4xl font-bold mb-6 relative z-10">Bergabunglah Menjadi Bagian Keluarga</h2>
            <p class="text-blue-100 text-lg mb-8 max-w-2xl mx-auto relative z-10">
                Temukan rumah keduamu di Semarang. Mari bertumbuh, belajar, dan berkontribusi bersama Ikatan Mahasiswa Pati UNNES.
            </p>
            <div class="relative z-10">
                <a href="{{ route('login') }}" class="bg-white text-blue-800 font-bold py-3 px-10 rounded-full hover:bg-gray-100 transition shadow-lg inline-block">
                    Gabung Sekarang
                </a>
            </div>
        </div>
    </section>

    @include('partials.footer')

    <script>
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.classList.add('shadow-md');
            } else {
                nav.classList.remove('shadow-md');
            }
        });
    </script>
</body>
</html>