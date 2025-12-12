<footer class="bg-slate-900 text-white pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">

            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center space-x-3 mb-4">
                    <img src="{{ asset('images/logonocap.png') }}" class="h-10 w-10 p-1" alt="IMP Logo">
                    <span class="text-2xl font-bold tracking-tight">IMP UNNES</span>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed mb-6 max-w-sm">
                    Ikatan Mahasiswa Pati Universitas Negeri Semarang. Wadah persaudaraan, pengembangan diri, dan
                    kontribusi nyata untuk daerah tercinta.
                </p>
                <p class="text-slate-400 text-sm font-semibold">
                    Sekretariat:
                </p>
                <p class="text-slate-500 text-sm">
                    Patemon, Gunungpati, Semarang.
                </p>
            </div>

            <div>
                <h3 class="text-lg font-bold mb-4 text-white border-b-2 border-blue-500 inline-block pb-1">Menu</h3>
                <ul class="space-y-3 text-sm text-slate-300">
                    <li><a href="#" class="hover:text-blue-400 transition">Beranda</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition">Program Kerja</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition">Hubungi Kami</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-bold mb-4 text-white border-b-2 border-blue-500 inline-block pb-1">Ikuti Kami
                </h3>
                <p class="text-slate-400 text-sm mb-4">Dapatkan update terbaru kegiatan kami.</p>

                <div class="flex flex-col space-y-3">
                    @foreach($socials as $soc)
                        <a href="{{ $soc->url }}" target="_blank" class="flex items-center group">
                            <span
                                class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition duration-300">
                                <i class="{{ $soc->icon_class }}"></i>
                            </span>
                            <span
                                class="ml-3 text-sm text-slate-300 group-hover:text-white transition">{{ $soc->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="border-t border-slate-800 pt-8 text-center text-sm text-slate-500">
            <p>&copy; {{ date('Y') }} Ikatan Mahasiswa Pati UNNES. All rights reserved.</p>
        </div>
    </div>
</footer>