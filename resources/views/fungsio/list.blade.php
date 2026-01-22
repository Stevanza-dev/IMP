<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Daftar Fungsionaris per Divisi') }}
		</h2>
	</x-slot>

	<div class="py-8">
		<div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
			@forelse ($divisions as $division)
				@if ($division->fungsios->count())
					<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
						<div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
							<h3 class="font-bold text-gray-800 uppercase tracking-wide">{{ $division->name }}</h3>
							<span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded-full">
								{{ $division->fungsios->count() }} Orang
							</span>
						</div>

						<div class="p-6">
							<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
								@foreach ($division->fungsios as $fungsio)
									<div
										class="p-3 rounded-lg border border-gray-100 bg-white hover:bg-blue-50 hover:border-blue-200 transition">
										<div class="flex items-center space-x-3">
											<div
												class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm">
												{{ strtoupper(substr($fungsio->user->name ?? '?', 0, 1)) }}
											</div>
											<div class="min-w-0 flex-1">
												<p class="text-sm font-bold text-gray-900 truncate">
													{{ $fungsio->user->name ?? '-' }}
												</p>
												<p class="text-xs text-gray-500 truncate">{{ $fungsio->jabatan }}</p>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						</div>
					</div>
				@endif
			@empty
				<div class="bg-white shadow-sm sm:rounded-lg p-6 text-center text-gray-500">
					Belum ada data fungsionaris.
				</div>
			@endforelse
		</div>
	</div>
</x-app-layout>