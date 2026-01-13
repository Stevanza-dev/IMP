<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Statistik Fungsionaris IMP') }}
		</h2>
	</x-slot>

	<div class="py-8">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
			<!-- Ringkasan Utama -->
			<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
				<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
					<div class="p-6">
						<p class="text-sm text-gray-500">Total Fungsionaris</p>
						<p class="mt-2 text-3xl font-bold text-gray-800">{{ $totalFungsio }}</p>
					</div>
				</div>

				<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
					<div class="p-6">
						<p class="text-sm text-gray-500">Angkatan 2023</p>
						<p class="mt-2 text-3xl font-bold text-gray-800">{{ $angkatan2023 }}</p>
					</div>
				</div>

				<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
					<div class="p-6">
						<p class="text-sm text-gray-500">Angkatan 2024</p>
						<p class="mt-2 text-3xl font-bold text-gray-800">{{ $angkatan2024 }}</p>
					</div>
				</div>

				<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
					<div class="p-6 flex flex-col gap-1">
						<p class="text-sm text-gray-500">Status Keaktifan</p>
						<div class="flex justify-between text-sm mt-1">
							<span class="text-green-700 font-semibold">Aktif</span>
							<span class="font-bold text-gray-800">{{ $totalAktif }}</span>
						</div>
						<div class="flex justify-between text-sm">
							<span class="text-amber-700 font-semibold">Alumni</span>
							<span class="font-bold text-gray-800">{{ $totalAlumni }}</span>
						</div>
					</div>
				</div>
			</div>

			<!-- Distribusi per Angkatan -->
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="p-6">
					<h3 class="text-lg font-semibold text-gray-800 mb-4">Distribusi per Angkatan</h3>
					@if ($perAngkatan->isEmpty())
						<p class="text-sm text-gray-500">Belum ada data fungsionaris.</p>
					@else
						<div class="overflow-x-auto">
							<table class="min-w-full divide-y divide-gray-200 text-sm">
								<thead class="bg-gray-50">
									<tr>
										<th class="px-4 py-2 text-left font-medium text-gray-600">Angkatan</th>
										<th class="px-4 py-2 text-left font-medium text-gray-600">Jumlah</th>
									</tr>
								</thead>
								<tbody class="divide-y divide-gray-100">
									@foreach ($perAngkatan as $row)
										<tr>
											<td class="px-4 py-2 text-gray-800">{{ $row->year }}</td>
											<td class="px-4 py-2 text-gray-800 font-semibold">{{ $row->total }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					@endif
				</div>
			</div>

			<!-- Distribusi per Divisi -->
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="p-6">
					<h3 class="text-lg font-semibold text-gray-800 mb-4">Distribusi per Divisi</h3>
					@if ($perDivisi->isEmpty())
						<p class="text-sm text-gray-500">Belum ada data divisi atau fungsionaris.</p>
					@else
						<div class="overflow-x-auto">
							<table class="min-w-full divide-y divide-gray-200 text-sm">
								<thead class="bg-gray-50">
									<tr>
										<th class="px-4 py-2 text-left font-medium text-gray-600">Divisi</th>
										<th class="px-4 py-2 text-left font-medium text-gray-600">Jumlah Fungsionaris</th>
									</tr>
								</thead>
								<tbody class="divide-y divide-gray-100">
									@foreach ($perDivisi as $division)
										<tr>
											<td class="px-4 py-2 text-gray-800">{{ $division->name }}</td>
											<td class="px-4 py-2 text-gray-800 font-semibold">
												{{ $division->fungsios_count }}
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</x-app-layout>

