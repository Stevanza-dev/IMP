<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Social Media IMP UNNES</title>
	<link rel="icon" href="{{ asset('images/logonocap.png') }}" type="image/png">

	<script src="https://cdn.tailwindcss.com"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

	<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
		rel="stylesheet">

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
</head>

<body class="bg-gray-50 text-gray-800">
	@include('partials.header')

	@php
		// Ubah link di bawah ini ke link Google Form / Google Docs untuk Media Partner
		$medpartLink = 'https://drive.google.com/drive/folders/1mXCKXQwxFFJ27xGEy9E2HRQ20CgJBJpn?usp=drive_link';
	@endphp

	<!-- Hero Section -->
	<section class="hero-bg-sosmed h-80 md:h-96 flex items-center justify-center text-center px-4 relative mt-16 md:mt-0">
		<div class="max-w-3xl mx-auto text-white z-10">
			<p class="text-blue-200 font-semibold tracking-wider uppercase mb-2">Tetap Terhubung Dengan IMP UNNES</p>
			<h1 class="text-3xl md:text-4xl font-extrabold mb-4 leading-tight">Social Media & Kerja Sama Media Partner</h1>
			<p class="text-base md:text-lg text-blue-100 max-w-2xl mx-auto">
				Ikuti seluruh update kegiatan, informasi penting, dan dokumentasi aktivitas IMP UNNES melalui berbagai
				kanal resmi kami.
			</p>
		</div>
	</section>

	<main class="max-w-6xl mx-auto px-4 py-10 md:py-16 space-y-10 md:space-y-14">
		<!-- Kartu Media Partner di Paling Atas -->
		<section>
			<div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl p-6 md:p-8 text-white shadow-xl flex flex-col md:flex-row md:items-center md:justify-between gap-6">
				<div>
					<h2 class="text-2xl md:text-3xl font-bold mb-2">Kerja Sama Media Partner</h2>
					<p class="text-blue-100 text-sm md:text-base max-w-2xl">
						Ingin berkolaborasi dengan IMP UNNES untuk publikasi acara, liputan kegiatan, atau kerja sama konten?
						Silakan baca syarat & ketentuan serta kirim pengajuan melalui link berikut.
					</p>
				</div>

				<div class="flex flex-col items-start md:items-end gap-3">
					<a href="{{ $medpartLink }}" target="_blank" rel="noopener noreferrer"
					   class="inline-flex items-center px-5 py-3 bg-white text-blue-800 font-semibold rounded-full shadow-md hover:bg-blue-50 transition">
						<i class="fas fa-handshake mr-2"></i>
						Syarat & Ketentuan Media Partner
					</a>
					<p class="text-xs text-blue-100 max-w-xs md:text-right">
						Link mengarah ke Google Drive eksternal. Pastikan untuk membaca terlebih dahulu.
					</p>
				</div>
			</div>
		</section>

		<!-- Daftar Social Media -->
		<section>
			<div class="flex items-center justify-between mb-6">
				<div>
					<h2 class="text-2xl md:text-3xl font-bold text-gray-900">Akun Resmi IMP UNNES</h2>
					<p class="text-gray-500 text-sm md:text-base mt-1">
						Gunakan hanya akun di bawah ini untuk informasi resmi dan valid.
					</p>
				</div>
			</div>

			@if($socials->isEmpty())
				<div class="bg-white border border-dashed border-gray-300 rounded-xl p-6 text-center text-gray-500">
					<p class="font-medium mb-1">Belum ada data social media yang terdaftar.</p>
					<p class="text-sm">Silakan tambahkan data social media melalui halaman admin.</p>
				</div>
			@else
				<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
					@foreach($socials as $social)
						<a href="{{ $social->url }}" target="_blank" rel="noopener noreferrer"
						   class="group bg-white rounded-2xl shadow-md hover:shadow-xl border border-gray-100 hover:border-blue-200 transition overflow-hidden flex flex-col">
							<div class="h-1.5 bg-blue-600 w-0 group-hover:w-full transition-all duration-500"></div>

							<div class="p-6 flex items-start gap-4 flex-grow">
								<div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 text-xl flex-shrink-0 group-hover:bg-blue-600 group-hover:text-white transition">
									@if(!empty($social->icon_class))
										<i class="{{ $social->icon_class }}"></i>
									@else
										<i class="fas fa-hashtag"></i>
									@endif
								</div>

								<div class="flex flex-col">
									<h3 class="text-lg font-semibold text-gray-900 mb-1 group-hover:text-blue-700 transition">
										{{ $social->name }}
									</h3>
									<p class="text-sm text-gray-500 break-all">{{ $social->url }}</p>
								</div>
							</div>

							<div class="px-6 pb-4 flex items-center justify-between text-xs text-gray-400">
								<span class="inline-flex items-center gap-1">
									<i class="fas fa-external-link-alt"></i>
									Kunjungi Akun
								</span>
								<span class="group-hover:text-blue-500 font-medium transition">Klik untuk membuka</span>
							</div>
						</a>
					@endforeach
				</div>
			@endif
		</section>
	</main>

	@include('partials.footer')

</body>

</html>
