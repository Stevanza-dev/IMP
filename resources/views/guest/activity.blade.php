<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Timeline - IMP UNNES</title>
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

<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    @include('partials.header')

    <section class="bg-slate-900 text-white pt-32 pb-16 px-4 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-10">
            <svg class="absolute top-0 left-0 w-[800px] h-[800px] -translate-x-1/2 -translate-y-1/2"
                viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#3B82F6"
                    d="M44.7,-76.4C58.9,-69.2,71.8,-59.1,81.6,-46.6C91.4,-34.1,98.1,-19.2,95.8,-5.3C93.5,8.6,82.2,21.5,70.6,32.2C59,42.9,47.1,51.4,34.8,58.3C22.5,65.2,9.8,70.5,-2.2,74.3C-14.2,78.1,-25.4,80.4,-36.3,75.9C-47.2,71.4,-57.8,60.1,-66.5,47.6C-75.2,35.1,-82,21.3,-83.4,6.9C-84.8,-7.5,-80.8,-22.5,-72.6,-34.9C-64.4,-47.3,-52,-57.1,-39.3,-64.9C-26.6,-72.7,-13.3,-78.5,0.7,-79.7C14.7,-80.9,29.4,-77.5,44.7,-76.4Z"
                    transform="translate(100 100)" />
            </svg>
        </div>

        <div class="max-w-7xl mx-auto relative z-10 text-center">
            <h1 class="text-3xl md:text-5xl font-extrabold mb-4">Timeline Kegiatan</h1>
            <p class="text-blue-200 text-lg max-w-2xl mx-auto">
                Rekam jejak perjalanan kami dalam berkarya. Dari perencanaan hingga pelaksanaan program kerja.
            </p>
        </div>
    </section>

    <section class="py-16 px-4 flex-grow">
        <div class="max-w-4xl mx-auto">

            <div class="relative border-l-4 border-blue-100 ml-4 md:ml-6 space-y-12">

                @forelse($activities as $item)
                    <div class="relative pl-8 md:pl-12 group">

                        <div
                            class="absolute -left-[10px] top-6 w-6 h-6 rounded-full border-4 border-white 
                                {{ $item->is_active ? 'bg-green-500 shadow-[0_0_0_4px_rgba(34,197,94,0.2)]' : 'bg-gray-400' }}">
                        </div>

                        <div
                            class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-all duration-300 relative">

                            <div class="flex flex-col md:flex-row md:items-center justify-between mb-4 gap-2">
                                <div class="flex items-center text-blue-600 font-bold">
                                    <i class="far fa-calendar-alt mr-2 text-lg"></i>
                                    <span class="uppercase tracking-wide">
                                        {{ \Carbon\Carbon::parse($item->execution_date)->translatedFormat('l, d F Y') }}
                                    </span>
                                </div>

                                <div>
                                    @if($item->is_active)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                            AKAN DATANG / AKTIF
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-500 border border-gray-200">
                                            <i class="fas fa-check-circle mr-2"></i>
                                            TERLAKSANA
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <h2 class="text-2xl font-bold text-gray-900 mb-1 group-hover:text-blue-700 transition">
                                {{ $item->name }}
                            </h2>

                            <div class="mb-4">
                                <span class="text-xs font-semibold text-blue-500 bg-blue-50 px-2 py-1 rounded">
                                    {{ $item->division->name ?? 'Program Umum' }}
                                </span>
                            </div>

                            <p class="text-gray-600 leading-relaxed">
                                {{ $item->description }}
                            </p>

                            @if($item->is_active && \Carbon\Carbon::parse($item->execution_date)->isFuture())
                                <div class="mt-6 pt-4 border-t border-gray-100 flex items-center text-sm text-gray-500">
                                    <i class="fas fa-hourglass-half mr-2 text-orange-500"></i>
                                    Menuju pelaksanaan:
                                    <strong class="ml-1 text-gray-800">
                                        {{ \Carbon\Carbon::parse($item->execution_date)->diffForHumans() }}
                                    </strong>
                                </div>
                            @endif

                        </div>
                    </div>
                @empty
                    <div class="pl-8">
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <p class="text-yellow-700 font-bold">Belum ada kegiatan.</p>
                            <p class="text-yellow-600 text-sm">Jadwal kegiatan akan segera diupdate oleh admin.</p>
                        </div>
                    </div>
                @endforelse

            </div>
            <div class="ml-4 md:ml-6 mt-2 relative">
                <div class="absolute -left-[5px] w-4 h-4 rounded-full bg-blue-200"></div>
            </div>

        </div>
    </section>

    @include('partials.footer')

</body>

</html>