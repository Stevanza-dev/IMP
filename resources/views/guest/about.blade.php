<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - IMP UNNES</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    @include('partials.header')

    <section class="bg-blue-900 text-white pt-32 pb-16 px-4 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-800 rounded-full translate-x-1/2 -translate-y-1/2 opacity-50"></div>
        <div class="absolute bottom-0 left-0 w-40 h-40 bg-blue-500 rounded-full -translate-x-1/2 translate-y-1/2 opacity-20"></div>

        <div class="max-w-7xl mx-auto relative z-10 text-center">
            <h1 class="text-3xl md:text-5xl font-extrabold mb-4">Struktur Organisasi</h1>
            <p class="text-blue-200 text-lg max-w-2xl mx-auto">
                Mengenal lebih dalam departemen dan divisi yang menjadi motor penggerak Ikatan Mahasiswa Pati UNNES.
            </p>
        </div>
    </section>

    <section class="py-16 px-4 flex-grow">
        <div class="max-w-7xl mx-auto">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($divisions as $index => $divisi)
                
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg border border-gray-100 overflow-hidden transition duration-300 flex flex-col h-full">
                    
                    <div class="p-8">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xl font-bold">
                                {{ substr($divisi->name, 0, 1) }} </div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Divisi 0{{ $index + 1 }}</span>
                        </div>

                        <h2 class="text-2xl font-bold text-gray-900 mb-3">{{ $divisi->name }}</h2>
                        <p class="text-gray-600 leading-relaxed text-sm">
                            {{ $divisi->description }}
                        </p>
                    </div>

                    <div class="bg-gray-50 p-6 mt-auto border-t border-gray-100">
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide mb-4 flex items-center">
                            <i class="fas fa-list-check mr-2 text-blue-500"></i> Program Kerja
                        </h3>
                        
                        @if($divisi->workPrograms->count() > 0)
                            <ul class="space-y-3">
                                @foreach($divisi->workPrograms as $proker)
                                <li class="flex items-start group">
                                    <span class="flex-shrink-0 w-1.5 h-1.5 rounded-full bg-blue-400 mt-2 mr-3 group-hover:bg-blue-600 transition"></span>
                                    
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start">
                                            <span class="text-sm font-medium text-gray-700 group-hover:text-blue-700 transition">
                                                {{ $proker->name }}
                                            </span>
                                            
                                            <span class="text-[10px] bg-white border border-gray-200 text-gray-500 px-2 py-0.5 rounded-full whitespace-nowrap ml-2">
                                                {{ \Carbon\Carbon::parse($proker->execution_date)->translatedFormat('M Y') }}
                                            </span>
                                        </div>
                                        
                                        {{-- <p class="text-xs text-gray-400 mt-1 line-clamp-1">{{ $proker->description }}</p> --}}
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-sm text-gray-400 italic">Belum ada program kerja yang diinput.</p>
                        @endif
                    </div>

                </div>
                @endforeach
            </div>

        </div>
    </section>

    <section class="bg-blue-50 py-12 px-4 border-t border-blue-100">
        <div class="max-w-4xl mx-auto text-center">
            <h3 class="text-xl font-bold text-blue-900 mb-2">Ingin berkolaborasi dengan salah satu divisi kami?</h3>
            <p class="text-gray-600 mb-6">Kami sangat terbuka untuk kerjasama media partner, sponsorship, maupun kolaborasi event.</p>
            <a href="https://wa.me/6281234567890" class="inline-flex items-center justify-center px-6 py-3 text-base font-bold text-white transition-all duration-200 bg-green-500 border border-transparent rounded-full hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-600 shadow-md">
                <i class="fab fa-whatsapp mr-2 text-xl"></i> Hubungi Humas
            </a>
        </div>
    </section>

    @include('partials.footer')

</body>
</html>