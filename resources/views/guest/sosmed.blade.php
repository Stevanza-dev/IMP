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
		$medpartLink = 'https://drive.google.com/file/d/13KpcAEOlzDVs3Xx0q6OvvbEtcWGzp6DX/view?usp=drive_link';
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
		<!-- Sistematika Media Partner -->
		@if($medpartSteps->isNotEmpty())
		<section>
			<div class="mb-6">
				<h2 class="text-2xl md:text-3xl font-bold text-gray-900">Sistematika Media Partner</h2>
				<p class="text-gray-500 text-sm md:text-base mt-1">
					Langkah-langkah yang harus dilakukan untuk menjalin kerja sama media partner.
				</p>
			</div>
			
			<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
				@foreach($medpartSteps as $index => $step)
					<div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100 hover:shadow-lg hover:border-blue-200 transition-all group flex flex-col h-full">
						<div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 font-bold text-xl mb-4 group-hover:bg-blue-600 group-hover:text-white transition-colors">
							{{ $step->order_number }}
						</div>
						<p class="text-gray-700 text-sm md:text-base leading-relaxed flex-grow">
							{{ $step->description }}
						</p>
					</div>
				@endforeach
			</div>
		</section>
		@endif

		<!-- Paket Medpart -->
		@if($medpartPackages->isNotEmpty())
		<section>
			<div class="mb-6">
				<h2 class="text-2xl md:text-3xl font-bold text-gray-900">Pilihan Paket</h2>
				<p class="text-gray-500 text-sm md:text-base mt-1">
					Pilih paket media partner sesuai dengan kebutuhan acara Anda.
				</p>
			</div>

			<div class="space-y-8">
			@foreach($medpartPackages as $package)
				<div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
					<div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
						<h3 class="text-xl md:text-2xl font-bold text-white tracking-wide">{{ $package->name }}</h3>
						@if($package->price > 0)
							<span class="inline-block bg-white text-blue-800 font-bold px-4 py-1.5 rounded-full text-sm shadow-sm self-start sm:self-auto">
								Rp {{ number_format($package->price, 0, ',', '.') }}
							</span>
						@else
                            <span class="inline-block bg-white text-blue-800 font-bold px-4 py-1.5 rounded-full text-sm shadow-sm self-start sm:self-auto">
								Gratis
							</span>
                        @endif
					</div>
					
					<div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-100">
						<!-- Syarat & Ketentuan -->
						<div class="p-6 md:p-8">
							<div class="flex items-center gap-3 mb-4 text-blue-600">
								<i class="fas fa-list-check text-xl"></i>
								<h4 class="text-lg font-bold text-gray-900">Syarat & Ketentuan</h4>
							</div>
							<ul class="space-y-3">
								@foreach($package->requirements as $req)
									<li class="flex items-start gap-3 text-gray-600 text-sm md:text-base">
										<i class="fas fa-check-circle text-blue-500 mt-1 flex-shrink-0"></i>
										<span>{{ $req->content }}</span>
									</li>
								@endforeach
							</ul>
						</div>

						<!-- Feedback -->
						<div class="p-6 md:p-8 bg-gray-50/50">
							<div class="flex items-center gap-3 mb-4 text-green-600">
								<i class="fas fa-bullhorn text-xl"></i>
								<h4 class="text-lg font-bold text-gray-900">Feedback Layanan</h4>
							</div>
							<ul class="space-y-3">
								@foreach($package->feedbacks as $fb)
									<li class="flex items-start gap-3 text-gray-600 text-sm md:text-base">
										<i class="fas fa-star text-green-500 mt-1 flex-shrink-0"></i>
										<span>{{ $fb->content }}</span>
									</li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
			@endforeach
			</div>
		</section>
		@endif

		<!-- Pembayaran -->
		@if($medpartPayments->isNotEmpty())
		<section>
			<div class="mb-6">
				<h2 class="text-2xl md:text-3xl font-bold text-gray-900">Metode Pembayaran</h2>
				<p class="text-gray-500 text-sm md:text-base mt-1">
					Tujuan transfer untuk paket media partner berbayar.
				</p>
			</div>
			
			<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
				@foreach($medpartPayments as $payment)
					<div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100 flex items-center gap-4 hover:shadow-lg transition group">
						<div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 text-xl flex-shrink-0 group-hover:bg-blue-600 group-hover:text-white transition">
							<i class="fas fa-wallet"></i>
						</div>
						<div>
							<h4 class="text-sm text-gray-500 font-medium mb-0.5">{{ $payment->bank_name }}</h4>
							<p class="text-lg font-bold text-gray-900 tracking-wide">{{ $payment->account_number }}</p>
							<p class="text-xs text-gray-400 mt-0.5 font-semibold">a.n. {{ $payment->account_name }}</p>
						</div>
					</div>
				@endforeach
			</div>
		</section>
		@endif

		<!-- Hubungi Kominfo Section -->
		<section class="bg-blue-50 rounded-2xl p-6 md:p-8 shadow-sm border border-blue-100 flex flex-col md:flex-row items-center justify-between gap-6">
			<div>
				<h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Tertarik untuk Media Partner?</h2>
				<p class="text-gray-600 text-sm md:text-base">
					Hubungi untuk kerja sama media partner lebih lanjut.
				</p>
			</div>
			<a href="https://wa.me/{{ $kominfo->phone }}" target="_blank"
				class="inline-flex items-center justify-center px-6 py-3 text-base font-bold text-white transition-all duration-200 bg-green-500 border border-transparent rounded-full hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-600 shadow-md whitespace-nowrap">
				<i class="fab fa-whatsapp mr-2 text-xl"></i> Hubungi {{ $kominfo->name }}
			</a>
		</section>

		<!-- Download Logo Section -->
		<section>
			<div class="flex items-center justify-between mb-6">
				<div>
					<h2 class="text-2xl md:text-3xl font-bold text-gray-900">Download Logo IMP</h2>
					<p class="text-gray-500 text-sm md:text-base mt-1">
						Unduh logo resmi IMP UNNES untuk keperluan publikasi dan media partner.
					</p>
				</div>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
				<!-- Logo Original -->
				<div class="bg-white rounded-2xl p-6 md:p-8 shadow-md border border-gray-100 flex flex-col items-center text-center hover:shadow-lg transition">
					<div class="h-48 w-full flex items-center justify-center mb-6 bg-gray-50 rounded-xl border border-dashed border-gray-200 p-6 relative group overflow-hidden">
						<div class="absolute inset-0 opacity-[0.03] bg-[radial-gradient(#000_1px,transparent_1px)] [background-size:16px_16px]"></div>
						<img src="{{ asset('images/logoimp.png') }}" alt="Logo IMP Original" class="max-h-full max-w-full object-contain drop-shadow-sm transition-transform duration-300 group-hover:scale-105">
					</div>
					<h3 class="text-lg font-bold text-gray-900 mb-2">Logo Original</h3>
					<p class="text-sm text-gray-500 mb-6 px-4">
						Format PNG transparansi tinggi dengan warna asli. Gunakan pada latar belakang terang/putih.
					</p>
					<a href="{{ asset('images/logoimp.png') }}" download
					   class="w-full inline-flex items-center justify-center px-5 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition shadow-sm hover:shadow-md active:scale-95">
						<i class="fas fa-download mr-2"></i> Download PNG
					</a>
				</div>

				<!-- Logo Putih -->
				<div class="bg-white rounded-2xl p-6 md:p-8 shadow-md border border-gray-100 flex flex-col items-center text-center hover:shadow-lg transition">
					<div class="h-48 w-full flex items-center justify-center mb-6 bg-gradient-to-br from-blue-900 to-slate-900 rounded-xl p-6 relative group overflow-hidden shadow-inner">
						<div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
						<img src="{{ asset('images/logoimp-white.png') }}" alt="Logo IMP Putih" class="max-h-full max-w-full object-contain drop-shadow-md transition-transform duration-300 group-hover:scale-105">
					</div>
					<h3 class="text-lg font-bold text-gray-900 mb-2">Logo Putih</h3>
					<p class="text-sm text-gray-500 mb-6 px-4">
						Format PNG warna putih solid. Wajib digunakan pada latar belakang gelap, foto, atau video.
					</p>
					<a href="{{ asset('images/logoimp-white.png') }}" download
					   class="w-full inline-flex items-center justify-center px-5 py-3 bg-gray-900 text-white font-semibold rounded-xl hover:bg-gray-800 transition shadow-sm hover:shadow-md active:scale-95">
						<i class="fas fa-download mr-2"></i> Download PNG
					</a>
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
