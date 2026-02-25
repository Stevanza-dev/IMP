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
			<p class="text-blue-200 font-semibold tracking-wider uppercase mb-2">Rekam Jejak Kegiatan IMP UNNES</p>
			<h1 class="text-3xl md:text-4xl font-extrabold mb-4 leading-tight">Timeline Kegiatan</h1>
			<p class="text-base md:text-lg text-blue-100 max-w-2xl mx-auto">
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

</div>
