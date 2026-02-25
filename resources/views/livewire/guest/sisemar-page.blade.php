<div>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Font Khusus Judul Kerajaan */
        .font-royal {
            font-family: 'Cinzel', serif;
        }

        /* Background Langit (Sky Theme) sesuai referensi poster */
        .sisemar-hero {
            background: linear-gradient(180deg, #38bdf8 0%, #bae6fd 60%, #ffffff 100%);
        }

        /* Efek Teks Emas */
        .text-gold-gradient {
            background: linear-gradient(to bottom, #FDE68A, #D97706);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0px 2px 2px rgba(0, 0, 0, 0.3));
        }

        .border-gold {
            border-color: #D97706;
        }
        ";
    </style>

    <section class="sisemar-hero min-h-screen flex items-center justify-center text-center px-4 relative pt-20">

        <div class="absolute top-20 left-10 text-white opacity-40 animate-pulse"><i class="fas fa-cloud text-6xl"></i>
        </div>
        <div class="absolute top-40 right-20 text-white opacity-60"><i class="fas fa-cloud text-8xl"></i></div>
        <div class="absolute bottom-32 left-1/4 text-white opacity-30"><i class="fas fa-cloud text-5xl"></i></div>

        <div class="absolute top-24 left-1/3 text-white opacity-80"><i class="fas fa-dove text-xl"></i></div>
        <div class="absolute top-28 left-[35%] text-white opacity-80"><i class="fas fa-dove text-sm"></i></div>

        <div class="max-w-5xl mx-auto z-10 relative">

            <div class="mb-6 flex justify-center">
                <div
                    class="w-24 h-24 bg-gradient-to-b from-yellow-300 to-yellow-500 rounded-full flex items-center justify-center shadow-lg border-4 border-white">
                    <i class="fas fa-crown text-4xl text-white"></i>
                </div>
            </div>

            <p class="text-blue-900 font-bold tracking-[0.3em] uppercase mb-2">Beyond the Gate of Dreams</p>

            <h1 class="font-royal text-5xl md:text-7xl font-black mb-4 leading-tight text-white drop-shadow-md">
                <span class="text-gold-gradient block mb-2">SI SEMAR 2026</span>
            </h1>

            <p
                class="text-lg md:text-xl font-medium text-blue-800 mb-10 max-w-2xl mx-auto bg-white/30 backdrop-blur-sm py-2 px-6 rounded-full border border-white/50">
                "Simulasi Seleksi Masuk Perguruan Tinggi Negeri"
            </p>

            <div class="flex flex-col md:flex-row justify-center gap-4">
                <a href="https://docs.google.com/forms/d/e/1FAIpQLScusVXtTk7OLmE9QENj7tc16kJdy1I7XdKzflYSAa_xYBZf4w/viewform"
                    target="_blank"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-4 px-10 rounded-full transition transform hover:scale-105 shadow-lg border-b-4 border-yellow-700">
                    <i class="fas fa-scroll mr-2"></i> Daftar Sekarang
                </a>

                <a href="https://instagram.com/sisemar_imp" target="_blank"
                    class="bg-white text-blue-600 font-bold py-4 px-10 rounded-full hover:bg-blue-50 transition flex items-center justify-center gap-2 border border-blue-200 shadow-lg">
                    <i class="fab fa-instagram text-xl"></i> Info Resmi
                </a>

                <a href="{{ route('sisemar.ticket.check') }}" wire:navigate
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-10 rounded-full transition transform hover:scale-105 shadow-lg border-b-4 border-blue-800">
                    <i class="fas fa-ticket-alt mr-2"></i> Cek Tiket
                </a>

            </div>
        </div>

        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none transform rotate-180">
            <svg class="relative block w-full h-[60px] md:h-[100px]" data-name="Layer 1"
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path
                    d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"
                    class="fill-white"></path>
            </svg>
        </div>
    </section>

    <section class="py-16 px-4 bg-white">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-10">
                <h3
                    class="font-royal text-2xl font-bold text-blue-900 uppercase tracking-widest border-b-2 border-yellow-400 inline-block pb-2">
                    Gerbang Kelulusan Terbuka Dalam
                </h3>
                <p class="text-gray-500 mt-4 font-semibold">
                    {{ \Carbon\Carbon::parse($sisemarData->execution_date)->translatedFormat('l, d F Y') }}
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8 text-center max-w-3xl mx-auto">
                <div class="bg-yellow-50 p-6 rounded-xl border border-yellow-200 shadow-sm">
                    <div id="days" class="text-4xl md:text-5xl font-black text-yellow-600 font-royal">00</div>
                    <div class="text-xs text-yellow-800 uppercase font-bold mt-2">Hari</div>
                </div>
                <div class="bg-yellow-50 p-6 rounded-xl border border-yellow-200 shadow-sm">
                    <div id="hours" class="text-4xl md:text-5xl font-black text-yellow-600 font-royal">00</div>
                    <div class="text-xs text-yellow-800 uppercase font-bold mt-2">Jam</div>
                </div>
                <div class="bg-yellow-50 p-6 rounded-xl border border-yellow-200 shadow-sm">
                    <div id="minutes" class="text-4xl md:text-5xl font-black text-yellow-600 font-royal">00</div>
                    <div class="text-xs text-yellow-800 uppercase font-bold mt-2">Menit</div>
                </div>
                <div class="bg-yellow-50 p-6 rounded-xl border border-yellow-200 shadow-sm">
                    <div id="seconds" class="text-4xl md:text-5xl font-black text-yellow-600 font-royal">00</div>
                    <div class="text-xs text-yellow-800 uppercase font-bold mt-2">Detik</div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-sky-50 relative overflow-hidden">
        <div class="absolute -right-20 top-20 w-64 h-64 bg-yellow-200 rounded-full blur-3xl opacity-20"></div>
        <div class="absolute -left-20 bottom-20 w-64 h-64 bg-blue-200 rounded-full blur-3xl opacity-20"></div>

        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-12 items-center relative z-10">

            <div>
                <span class="text-yellow-600 font-bold tracking-wider uppercase text-sm mb-2 block">Tentang Acara</span>
                <h2 class="font-royal text-4xl font-bold text-blue-900 mb-6">
                    Apa Itu <span class="text-yellow-600">SI SEMAR?</span>
                </h2>
                <p class="text-gray-600 text-lg leading-relaxed mb-6 text-justify">
                    <strong>SI SEMAR (Simulasi Seleksi Masuk Perguruan Tinggi Negeri)</strong> adalah program kerja
                    unggulan IMP UNNES di bidang pendidikan. Acara ini dirancang khusus untuk memfasilitasi pelajar
                    SMA/SMK/MA di Kabupaten Pati dalam mempersiapkan diri menghadapi UTBK-SNBT.
                </p>
                <p class="text-gray-600 text-lg leading-relaxed mb-8 text-justify">
                    Hadir dengan konsep dengan tema Beyond the Gate of Dreams, kami tidak hanya memberikan simulasi
                    ujian, tetapi juga pengalaman, motivasi, dan strategi jitu untuk menembus Perguruan Tinggi Negeri
                    impian.
                </p>

                <div class="space-y-3">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-yellow-500 mr-3 text-xl"></i>
                        <span class="text-gray-700 font-medium">Standar Soal Terbaru (HOTS)</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-yellow-500 mr-3 text-xl"></i>
                        <span class="text-gray-700 font-medium">Sistem Penilaian IRT (Real UTBK)</span>
                    </div>
                </div>
            </div>

            <div class="flex justify-center">
                <div class="relative">
                    <div class="absolute inset-0 bg-yellow-400 rounded-full rotate-6 opacity-20"></div>
                    <div
                        class="relative bg-white p-2 rounded-2xl shadow-xl border-2 border-yellow-100 transform -rotate-3 hover:rotate-0 transition duration-500">
                        <img src="{{ asset('images/dokss.JPG') }}" alt="SI SEMAR Activity"
                            class="rounded-xl w-full object-cover">
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 text-center">

            <h2 class="font-royal text-3xl md:text-4xl font-bold text-blue-900 mb-4">
                Mengapa Harus Join <br><span class="text-yellow-500">SI SEMAR 2026?</span>
            </h2>
            <p class="text-gray-500 max-w-2xl mx-auto mb-12">
                Jangan biarkan masa depanmu hanya menjadi angan. Persiapkan strategi terbaikmu bersama kami melalui
                fasilitas eksklusif bak kerajaan.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="p-8 rounded-2xl bg-white border border-gray-100 shadow-lg hover:shadow-xl hover:-translate-y-2 transition duration-300 group">
                    <div
                        class="w-16 h-16 mx-auto bg-blue-50 rounded-full flex items-center justify-center text-blue-600 text-2xl mb-6 group-hover:bg-blue-600 group-hover:text-white transition">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Sistem CAT Real Time</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Rasakan atmosfer ujian yang sesungguhnya dengan sistem Computer Assisted Test yang mirip
                        tampilan UTBK asli BPPP.
                    </p>
                </div>

                <div
                    class="p-8 rounded-2xl bg-white border border-yellow-100 shadow-lg hover:shadow-xl hover:-translate-y-2 transition duration-300 group relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 bg-yellow-500 text-white text-[10px] px-2 py-1 font-bold rounded-bl-lg">
                        RECOMMENDED</div>
                    <div
                        class="w-16 h-16 mx-auto bg-yellow-50 rounded-full flex items-center justify-center text-yellow-600 text-2xl mb-6 group-hover:bg-yellow-500 group-hover:text-white transition">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Ranking & Hadiah Menarik</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Ukur kemampuanmu tidak hanya dengan teman sekolah, tapi dengan ribuan peserta lain se-Kabupaten.
                    </p>
                </div>

                <div
                    class="p-8 rounded-2xl bg-white border border-gray-100 shadow-lg hover:shadow-xl hover:-translate-y-2 transition duration-300 group">
                    <div
                        class="w-16 h-16 mx-auto bg-blue-50 rounded-full flex items-center justify-center text-blue-600 text-2xl mb-6 group-hover:bg-blue-600 group-hover:text-white transition">
                        <i class="fas fa-users-class"></i> <i class="fas fa-chalkboard-user"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Pembahasan & Konsultasi</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Dapatkan bedah soal mendalam dari tutor berpengalaman dan sesi konsultasi jurusan kuliah secara
                        gratis.
                    </p>
                </div>
            </div>

            <div class="mt-12">
                <a href="{{ route('sisemar') }}" wire:navigate
                    class="inline-block bg-blue-900 text-white font-bold py-4 px-12 rounded-full shadow-xl hover:bg-blue-800 transition">
                    Amankan Kursimu Sekarang
                </a>
            </div>

        </div>
    </section>

    <section class="py-20 bg-gradient-to-b from-white to-blue-50">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

            <div class="flex justify-center">
                <img src="{{ asset('images/maskotss.png') }}" alt="Logo SI SEMAR"
                    class="w-72 md:w-96 drop-shadow-2xl animate-pulse-slow">
            </div>

            <div>
                <h2 class="font-royal text-3xl font-bold text-blue-900 mb-8">
                    Filosofi Maskot <span class="text-yellow-600">SI SEMAR 2026</span>
                </h2>

                <div class="space-y-6">
                    <div class="flex items-start">
                        <div
                            class="flex-shrink-0 w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center text-yellow-600 mt-1">
                            <i class="fas fa-crown"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-bold text-gray-800">Mahkota Emas</h4>
                            <p class="text-sm text-gray-600">DETERMINASI (Perintis Jalan Masa Depan) Mahkota di kepala
                                adalah simbol pola pikir (mindset). Ini bermakna bahwa kamu adalah pemimpin mutlak bagi
                                kehidupanmu sendiri.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div
                            class="flex-shrink-0 w-12 h-12 bg-sky-100 rounded-lg flex items-center justify-center text-sky-600 mt-1">
                            <i class="fa-solid fa-khanda"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-bold text-gray-800">Pedang Terhunus</h4>
                            <p class="text-sm text-gray-600">KEDAULATAN (Raja atas Nasib Sendiri) Pedang ini bukan alat
                                untuk merusak, melainkan simbol tekad untuk membelah kabut ketidakpastian. Masa depan
                                itu abstrak, dan pedang yang terhunus adalah tanda kesiapanmu.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div
                            class="flex-shrink-0 w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-gray-600 mt-1">
                            <i class="fa-solid fa-flag"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-bold text-gray-800">Bendera</h4>
                            <p class="text-sm text-gray-600">VISI (Mercusuar Harapan) Bendera yang berkibar di tempat
                                tertinggi adalah visualisasi kesuksesan kita. Ia adalah
                                alasan besar kenapa kita rela kurang tidur dan belajar keras saat ini.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</div>
