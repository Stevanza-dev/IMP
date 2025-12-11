<section id="divisi" class="py-12">
    <h2 class="text-3xl font-bold text-center mb-8">8 Divisi IMP</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($divisions as $divisi)
            <div class="card p-6 border rounded shadow">
                <h3 class="text-xl font-bold">{{ $divisi->name }}</h3>
                <p>{{ $divisi->description }}</p>
                
                <div class="mt-4">
                    <h4 class="font-semibold text-sm text-gray-500">Program Kerja:</h4>
                    <ul class="list-disc ml-5 mt-2">
                        @foreach($divisi->workPrograms as $proker)
                            <li>
                                <strong>{{ $proker->name }}</strong> 
                                <span class="text-xs text-gray-400">({{ $proker->execution_date }})</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
</section>

<footer>
    @foreach($socials as $sosmed)
        <a href="{{ $sosmed->url }}" target="_blank">
            <i class="{{ $sosmed->icon_class }}"></i> {{ $sosmed->name }}
        </a>
    @endforeach
</footer>