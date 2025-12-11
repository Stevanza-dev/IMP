<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek E-Tiket AMPERA 2026</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen font-sans text-gray-900 flex flex-col items-center py-10 px-4">

    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-green-700">AMPERA 2026</h1>
        <p class="text-gray-500">Sistem Pengecekan Tiket Resmi</p>
    </div>

    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6 mb-8">
        <form action="{{ route('ticket.check') }}" method="GET" class="flex gap-2">
            <input type="text" name="search" placeholder="Masukkan Email / Kode Tiket..." 
                   value="{{ request('search') }}"
                   class="w-full rounded-md border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200" required>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 font-semibold">
                Cari
            </button>
        </form>

        @if (session('error'))
            <div class="mt-4 p-3 bg-red-100 text-red-700 rounded text-sm text-center">
                {{ session('error') }}
            </div>
        @endif
    </div>

    @if(isset($ticket))
    <div class="w-full max-w-lg bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
        
        <div class="bg-green-600 px-6 py-4 text-white flex justify-between items-center">
            <div>
                <p class="text-xs opacity-80 font-bold tracking-wider">EVENT TICKET</p>
                <h2 class="text-xl font-bold">AMPERA 2026</h2>
            </div>
            <div class="text-right">
                <p class="text-sm font-semibold">18 JAN 2026</p>
                <p class="text-xs opacity-80">Pati, Jawa Tengah</p>
            </div>
        </div>

        <div class="p-6">
            <div class="flex justify-between items-start mb-6 border-b border-dashed border-gray-300 pb-6">
                <div>
                    <p class="text-xs text-gray-500 uppercase">Nama Peserta</p>
                    <p class="text-lg font-bold text-gray-800">{{ $ticket->name }}</p>
                    
                    <p class="text-xs text-gray-500 uppercase mt-3">Instansi</p>
                    <p class="text-md font-medium text-gray-800">{{ $ticket->institution }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500 uppercase">Kode Tiket</p>
                    <p class="text-xl font-mono font-bold text-green-600 tracking-widest">{{ $ticket->ticket_code }}</p>
                </div>
            </div>

            <div class="flex flex-col items-center justify-center space-y-4">
                <div class="p-2 border-2 border-gray-800 rounded-lg">
                    {!! QrCode::size(180)->generate($ticket->ticket_code) !!}
                </div>
                <p class="text-sm text-center text-gray-500">
                    Tunjukkan QR Code ini kepada panitia<br>di pintu masuk acara.
                </p>
            </div>
        </div>

        <div class="bg-gray-50 px-6 py-3 text-center border-t border-gray-200">
            <button onclick="window.print()" class="text-green-600 text-sm font-bold hover:underline">
                🖨️ Cetak / Simpan sebagai PDF
            </button>
        </div>
    </div>
    @endif

</body>
</html>