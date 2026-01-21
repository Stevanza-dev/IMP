<x-app-layout>
    @php
        $activeTab = request('tab', 'created');
    @endphp

	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Kepanitiaan Program Kerja') }}
		</h2>
	</x-slot>

	<div class="py-6">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			@if (session('success'))
				<div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">{{ session('success') }}</div>
			@endif
			@if (session('error'))
				<div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-700">{{ session('error') }}</div>
			@endif

			{{-- Kepanitiaan yang dibuat --}}
			<div class="bg-white shadow sm:rounded-lg mb-6" id="created">
				<div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
					<div>
						<h3 class="text-lg font-medium text-gray-900">Kepanitiaan yang Anda Buat</h3>
						<p class="mt-1 text-sm text-gray-500">Hanya kepanitiaan yang sudah disetujui yang akan muncul di halaman fungsionaris anggota.</p>
					</div>
					<a href="{{ route('fungsio.comite.create') }}"
					   class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
						Buat Kepanitiaan
					</a>
				</div>

				<div class="px-6 py-4 overflow-x-auto">
					<table class="min-w-full divide-y divide-gray-200">
						<thead class="bg-gray-50">
							<tr>
								<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program Kerja</th>
								<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kepanitiaan</th>
								<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
								<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
								<th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
							</tr>
						</thead>
						<tbody class="bg-white divide-y divide-gray-200">
							@forelse ($comites as $comite)
								<tr class="hover:bg-gray-50">
									<td class="px-4 py-3 text-sm text-gray-900">{{ $comite->workProgram->name ?? '-' }}</td>
									<td class="px-4 py-3 text-sm text-gray-900">{{ $comite->title ?? '-' }}</td>
									<td class="px-4 py-3 text-sm">
										@switch($comite->status)
											@case('draft')
												<span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-700">Draft</span>
												@break
											@case('pending')
												<span class="inline-flex items-center rounded-full bg-yellow-100 px-2 py-0.5 text-xs font-medium text-yellow-800">Menunggu Verifikasi</span>
												@break
											@case('approved')
												<span class="inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800">Disetujui</span>
												@break
											@case('rejected')
												<span class="inline-flex items-center rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800">Ditolak</span>
												@break
										@endswitch
									</td>
									<td class="px-4 py-3 text-sm text-gray-600">{{ $comite->created_at?->format('d M Y, H:i') }}</td>
									<td class="px-4 py-3 text-sm text-right">
										<a href="{{ route('fungsio.comite.show', $comite->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Detail</a>

										@if (in_array($comite->status, ['draft', 'pending']))
											<a href="{{ route('fungsio.comite.edit', $comite->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>
											<form action="{{ route('fungsio.comite.destroy', $comite->id) }}" method="POST" class="inline"
											      onsubmit="return confirm('Hapus kepanitiaan ini?');">
												@csrf
												@method('DELETE')
												<button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
											</form>
										@endif
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500">Belum ada kepanitiaan yang Anda buat.</td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>

				<div class="px-6 py-4 border-t border-gray-200">
					{{ $comites->links() }}
				</div>
			</div>

			{{-- Kepanitiaan yang diikuti --}}
			<div class="bg-white shadow sm:rounded-lg" id="my">
				<div class="px-6 py-4 border-b border-gray-200">
					<h3 class="text-lg font-medium text-gray-900">Kepanitiaan yang Anda Ikuti</h3>
					<p class="mt-1 text-sm text-gray-500">Menampilkan semua kepanitiaan yang Anda ikuti (menunggu verifikasi maupun sudah disetujui).</p>
				</div>

				<div class="px-6 py-4 overflow-x-auto">
					<table class="min-w-full divide-y divide-gray-200">
						<thead class="bg-gray-50">
							<tr>
								<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program Kerja</th>
								<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kepanitiaan</th>
								<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sie</th>
								<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peran</th>
								<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
								<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
								<th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
							</tr>
						</thead>
						<tbody class="bg-white divide-y divide-gray-200">
							@php
								$rows = [];
								foreach ($joinedComites as $comite) {
									foreach ($comite->sies as $sie) {
										foreach ($sie->members as $member) {
											if ($member->fungsio_id === $fungsio->id) {
												$rows[] = [
													'comite_id' => $comite->id,
													'status' => $comite->status,
													'program' => $comite->workProgram->name ?? '-',
													'title' => $comite->title ?? '-',
													'sie' => $sie->name,
													'role' => $member->role,
													'created_at' => $comite->created_at,
												];
											}
										}
									}
								}
							@endphp

							@forelse ($rows as $row)
								<tr class="hover:bg-gray-50">
									<td class="px-4 py-3 text-sm text-gray-900">{{ $row['program'] }}</td>
									<td class="px-4 py-3 text-sm text-gray-900">{{ $row['title'] }}</td>
									<td class="px-4 py-3 text-sm text-gray-900">{{ $row['sie'] }}</td>
									<td class="px-4 py-3 text-sm">
										@if ($row['role'] === 'ketua')
											<span class="inline-flex items-center rounded-full bg-purple-100 px-2 py-0.5 text-xs font-medium text-purple-800">Ketua Panitia</span>
										@elseif ($row['role'] === 'koor')
											<span class="inline-flex items-center rounded-full bg-indigo-100 px-2 py-0.5 text-xs font-medium text-indigo-800">Koordinator</span>
										@else
											<span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-800">Anggota</span>
										@endif
									</td>
									<td class="px-4 py-3 text-sm">
										@switch($row['status'])
											@case('pending')
												<span class="inline-flex items-center rounded-full bg-yellow-100 px-2 py-0.5 text-xs font-medium text-yellow-800">Menunggu Verifikasi</span>
												@break
											@case('approved')
												<span class="inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800">Disetujui</span>
												@break
											@case('rejected')
												<span class="inline-flex items-center rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800">Ditolak</span>
												@break
											@default
												<span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-700">Draft</span>
											@endswitch
									</td>
									<td class="px-4 py-3 text-sm text-gray-600">{{ optional($row['created_at'])->format('d M Y, H:i') }}</td>
									<td class="px-4 py-3 text-sm text-right space-x-2">
										<a href="{{ route('fungsio.comite.my.show', $row['comite_id']) }}" class="inline-flex items-center rounded-md bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700 hover:bg-indigo-100">Detail</a>

										@if (in_array($row['role'], ['ketua', 'koor']) && $row['sie'] === 'Ketua Panitia' && $row['status'] === 'pending')
											<form action="{{ route('fungsio.comite.verify', $row['comite_id']) }}" method="POST" class="inline" onsubmit="return confirm('Verifikasi kepanitiaan ini sebagai ketua panitia?');">
												@csrf
												<button type="submit" class="inline-flex items-center rounded-md bg-green-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-green-500">Verifikasi</button>
											</form>
										@endif
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="7" class="px-4 py-6 text-center text-sm text-gray-500">Anda belum terdaftar dalam kepanitiaan mana pun.</td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>

				<div class="px-6 py-4 border-t border-gray-200">
					{{ $joinedComites->links() }}
				</div>
			</div>
		</div>
	</div>

</x-app-layout>
