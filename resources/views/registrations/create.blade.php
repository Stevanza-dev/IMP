<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar AMPERA 2026</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <div class="min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-green-700 tracking-tight">AMPERA 2026</h1>
            <p class="mt-2 text-gray-600">Pengabdian Masyarakat & Penanaman Pohon</p>
            <p class="text-sm text-green-600 font-semibold mt-1">18 Januari 2026</p>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-lg border-t-4 border-green-600">
            
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('registration.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 transition px-4 py-2 border">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 transition px-4 py-2 border">
                    <p class="text-xs text-gray-500 mt-1">*Tiket akan dikirim ke email ini.</p>
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required placeholder="Contoh: 08123456789"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 transition px-4 py-2 border">
                    @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="institution" class="block text-sm font-medium text-gray-700">Asal Instansi / Sekolah</label>
                    <input type="text" name="institution" id="institution" value="{{ old('institution') }}" required 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 transition px-4 py-2 border">
                    @error('institution') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                    <select name="payment_method" id="payment_method" required 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 transition px-4 py-2 border bg-white">
                        <option value="" disabled selected>Pilih Metode Bayar</option>
                        <option value="Transfer BCA" {{ old('payment_method') == 'Transfer BCA' ? 'selected' : '' }}>Transfer BCA - 1234567890 (IMP)</option>
                        <option value="Transfer BRI" {{ old('payment_method') == 'Transfer BRI' ? 'selected' : '' }}>Transfer BRI - 0987654321 (IMP)</option>
                        <option value="QRIS" {{ old('payment_method') == 'QRIS' ? 'selected' : '' }}>QRIS (Scan Barcode Panitia)</option>
                    </select>
                    @error('payment_method') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="payment_proof" class="block text-sm font-medium text-gray-700">Bukti Pembayaran (Screenshot/Foto)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-green-500 transition cursor-pointer bg-gray-50">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="text-sm text-gray-600">
                                <label for="payment_proof" class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none">
                                    <span>Upload file</span>
                                    <input id="payment_proof" name="payment_proof" type="file" class="sr-only" accept="image/*" required>
                                </label>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, JPEG up to 2MB</p>
                        </div>
                    </div>
                    @error('payment_proof') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition transform hover:-translate-y-0.5">
                        DAFTAR SEKARANG
                    </button>
                </div>
            </form>
        </div>
        
        <p class="mt-8 text-center text-xs text-gray-500">
            &copy; 2025 Ikatan Mahasiswa Pati. All rights reserved.
        </p>
    </div>

</body>
</html>