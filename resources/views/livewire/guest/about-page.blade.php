<div>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

		.hero-bg-sosmed {
			background-image: linear-gradient(rgba(0, 51, 102, 0.8), rgba(0, 51, 102, 0.85)), url('{{ asset("images/makrab.jpg") }}');
			background-size: cover;
			background-position: center;
		}
    </style>

    <section class="hero-bg-sosmed h-80 md:h-96 flex items-center justify-center text-center px-4 relative mt-16 md:mt-0">
		<div class="max-w-3xl mx-auto text-white z-10">
			<p class="text-blue-200 font-semibold tracking-wider uppercase mb-2">Mengenal Struktur IMP UNNES</p>
			<h1 class="text-3xl md:text-4xl font-extrabold mb-4 leading-tight">Struktur Organisasi</h1>
			<p class="text-base md:text-lg text-blue-100 max-w-2xl mx-auto">
				Mengenal lebih dalam departemen dan divisi yang menjadi motor penggerak Ikatan Mahasiswa Pati UNNES.
			</p>
		</div>
	</section>

    <section class="py-16 px-4 flex-grow">
        <div class="max-w-7xl mx-auto">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($divisions as $index => $divisi)

                    <div
                        class="bg-white rounded-2xl shadow-sm hover:shadow-lg border border-gray-100 overflow-hidden transition duration-300 flex flex-col h-full">

                        <div class="p-8">
                            <div class="flex items-start justify-between mb-4">
                                <div
                                    class="w-12 h-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xl font-bold">
                                    {{ substr($divisi->name, 0, 1) }}
                                </div>
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Divisi
                                    0{{ $index + 1 }}</span>
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
                                            <span
                                                class="flex-shrink-0 w-1.5 h-1.5 rounded-full bg-blue-400 mt-2 mr-3 group-hover:bg-blue-600 transition"></span>

                                            <div class="flex-1">
                                                <div class="flex justify-between items-start">
                                                    <span
                                                        class="text-sm font-medium text-gray-700 group-hover:text-blue-700 transition">
                                                        {{ $proker->name }}
                                                    </span>

                                                    <span
                                                        class="text-[10px] bg-white border border-gray-200 text-gray-500 px-2 py-0.5 rounded-full whitespace-nowrap ml-2">
                                                        {{ \Carbon\Carbon::parse($proker->execution_date)->translatedFormat('M Y') }}
                                                    </span>
                                                </div>

                                                {{-- <p class="text-xs text-gray-400 mt-1 line-clamp-1">{{ $proker->description }}
                                                </p> --}}
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

</div>
