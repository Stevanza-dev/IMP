<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar AMPERA 2026</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-emerald-50 text-gray-800 font-sans">

    @include('partials.header')

    <section class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 mt-16 md:mt-0">
        
        <div class="max-w-2xl mx-auto">
            
            <div class="mb-12 mt-12 text-center">
                <div class="inline-block px-4 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold uppercase tracking-wide mb-4">
                    Pendaftaran
                </div>
                <h1 class="text-4xl md:text-5xl font-extrabold text-emerald-900 tracking-tight">AMPERA 2026</h1>
                <p class="mt-4 text-lg text-emerald-700 font-semibold">Open Voolunteer & Pengabdian Masyarakat</p>
                <p class="text-sm text-gray-600 mt-2">18 Januari 2026 | Wukirsari - Tambakromo - Pati</p>
            </div>

            <div class="bg-white p-8 md:p-10 rounded-2xl shadow-xl border-t-4 border-emerald-600">
                
                @if (session('success'))
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-start gap-3" role="alert">
                        <i class="fas fa-check-circle text-lg mt-0.5"></i>
                        <div>
                            <strong class="font-bold block">Berhasil!</strong>
                            <span class="text-sm">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                <form action="{{ route('registration.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition bg-white">
                    @error('name') <span class="text-red-500 text-xs mt-1 block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required 
                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition bg-white">
                    <p class="text-xs text-gray-500 mt-2"><i class="fas fa-info-circle"></i> Tiket akan dikirim ke email ini.</p>
                    @error('email') <span class="text-red-500 text-xs mt-1 block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Nomor WhatsApp</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required placeholder="Contoh: 08123456789"
                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition bg-white">
                    @error('phone') <span class="text-red-500 text-xs mt-1 block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="institution" class="block text-sm font-semibold text-gray-700 mb-2">Asal Instansi / Sekolah</label>
                    <input type="text" name="institution" id="institution" value="{{ old('institution') }}" required 
                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition bg-white">
                    @error('institution') <span class="text-red-500 text-xs mt-1 block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap</label>
                    <textarea name="address" id="address" rows="3" required 
                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition bg-white"
                        placeholder="Nama Jalan, RT/RW, Desa, Kecamatan">{{ old('address') }}</textarea>
                    @error('address') <span class="text-red-500 text-xs mt-1 block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span> @enderror
                </div>

                <div class="pt-4 border-t-2 border-gray-100">
                    <label for="payment_method" class="block text-sm font-semibold text-gray-700 mb-2">Metode Pembayaran</label>
                    <select name="payment_method" id="payment_method" required 
                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition bg-white"
                        onchange="updatePaymentInfo()">
                        <option value="" disabled selected>Pilih Metode Bayar</option>
                        <option value="gopay" {{ old('payment_method') == 'gopay' ? 'selected' : '' }}>💳 Gopay</option>
                        <option value="shopeepay" {{ old('payment_method') == 'shopeepay' ? 'selected' : '' }}>🛍️ ShopeePay</option>
                        <option value="qris" {{ old('payment_method') == 'qris' ? 'selected' : '' }}>📱 QRIS</option>
                    </select>
                    @error('payment_method') <span class="text-red-500 text-xs mt-1 block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span> @enderror
                </div>

                <div id="payment-info" class="hidden bg-gradient-to-r from-emerald-50 to-green-50 p-6 rounded-xl border-2 border-emerald-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-xs text-gray-600 uppercase font-semibold tracking-wide">Nomor <span id="payment-label"></span></p>
                            <p class="text-xl font-bold text-gray-900 mt-2" id="payment-number"></p>
                        </div>
                        <button type="button" onclick="copyToClipboard()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                            <i class="fas fa-copy"></i> Salin
                        </button>
                    </div>
                </div>

                <div id="qris-section" class="hidden bg-emerald-50 p-6 rounded-xl border-2 border-emerald-200">
                    <label class="block text-sm font-semibold text-gray-700 mb-4">Scan QRIS</label>
                    <div class="flex justify-center">
                        <img src="{{ asset('images/qrisampera.jpg') }}" alt="QRIS Code" class="w-80 rounded-lg shadow-md">
                    </div>
                </div>

                <div>
                    <label for="payment_proof" class="block text-sm font-semibold text-gray-700 mb-3">Bukti Pembayaran (Screenshot/Foto)</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-emerald-500 hover:bg-emerald-50 transition cursor-pointer bg-gray-50" id="upload-area">
                        <div class="space-y-2">
                            <div class="flex justify-center">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400"></i>
                            </div>
                            <div class="text-sm text-gray-600">
                                <label for="payment_proof" class="relative cursor-pointer">
                                    <span class="font-semibold text-emerald-600 hover:text-emerald-700">Klik untuk upload</span> atau drag file ke sini
                                    <input id="payment_proof" name="payment_proof" type="file" class="sr-only" accept="image/*" required onchange="handleFileSelect()">
                                </label>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, JPEG hingga 2MB</p>
                        </div>
                    </div>
                    <div id="file-selected" class="hidden mt-4 p-4 bg-green-50 border-2 border-green-300 rounded-lg">
                        <p class="text-sm text-green-700"><i class="fas fa-check-circle"></i> <strong>File terpilih:</strong> <span id="file-name" class="font-semibold"></span></p>
                    </div>
                    @error('payment_proof') <span class="text-red-500 text-xs mt-2 block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span> @enderror
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full flex justify-center items-center py-3 px-4 rounded-lg shadow-lg text-base font-bold text-white bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition transform hover:scale-105">
                        <i class="fas fa-check-circle mr-2"></i> DAFTAR SEKARANG
                    </button>
                </div>
            </form>
        </div>
        
        <p class="mt-8 text-center text-xs text-gray-500">
            &copy; 2025 Ikatan Mahasiswa Pati. All rights reserved.
        </p>
    </section>

    <script>
        const paymentData = {
            gopay: { label: 'Gopay', number: '088212456560', name: 'Shofiya Nurul Husna' },
            shopeepay: { label: 'ShopeePay', number: '087892748569', name: 'Sofya' },
            qris: { label: 'QRIS', number: 'QRIS Code', name: '' }
        };

        function updatePaymentInfo() {
            const method = document.getElementById('payment_method').value;
            const infoDiv = document.getElementById('payment-info');
            const qrisSection = document.getElementById('qris-section');
            
            if (method === 'qris') {
                infoDiv.classList.add('hidden');
                qrisSection.classList.remove('hidden');
            } else if (method && paymentData[method]) {
                document.getElementById('payment-label').textContent = paymentData[method].label;
                document.getElementById('payment-number').textContent = paymentData[method].number + (paymentData[method].name ? ' (' + paymentData[method].name + ')' : '');
                infoDiv.classList.remove('hidden');
                qrisSection.classList.add('hidden');
            } else {
                infoDiv.classList.add('hidden');
                qrisSection.classList.add('hidden');
            }
        }

        function copyToClipboard() {
            const method = document.getElementById('payment_method').value;
            const number = paymentData[method].number;
            navigator.clipboard.writeText(number).then(() => {
                alert('Nomor berhasil disalin!');
            });
        }

        function handleFileSelect() {
            const fileInput = document.getElementById('payment_proof');
            const fileSelectedDiv = document.getElementById('file-selected');
            const fileNameSpan = document.getElementById('file-name');
            
            if (fileInput.files && fileInput.files[0]) {
                fileNameSpan.textContent = fileInput.files[0].name;
                fileSelectedDiv.classList.remove('hidden');
            } else {
                fileSelectedDiv.classList.add('hidden');
            }
        }
    </script>

</body>
</html>