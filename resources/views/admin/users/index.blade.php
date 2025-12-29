<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Manage Users') }}
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

			<div class="bg-white shadow sm:rounded-lg">
				<div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
					<div>
						<h3 class="text-lg font-medium text-gray-900">Akun Terdaftar</h3>
						<p class="mt-1 text-sm text-gray-500">Daftar semua pengguna yang terdaftar.</p>
					</div>

					<div class="flex items-center gap-3">
						<form method="GET" action="{{ route('users.index') }}" class="flex items-center gap-2">
							<input
								type="text"
								name="q"
								value="{{ request('q') }}"
								placeholder="Cari nama atau email..."
								class="block w-64 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
							/>
							<button type="submit"
								class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none">
								Cari
							</button>
						</form>

						<a href="{{ route('users.create') }}"
						   class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none">
							Tambah User
						</a>
					</div>
				</div>

				<div class="px-6 py-4 overflow-x-auto">
					<table class="min-w-full divide-y divide-gray-200">
						<thead class="bg-gray-50">
							<tr>
								<th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
								<th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
								<th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
								<th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
								<th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terdaftar</th>
								<th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
							</tr>
						</thead>
						<tbody class="bg-white divide-y divide-gray-200">
							@forelse ($users as $user)
								<tr class="hover:bg-gray-50">
									<td class="px-4 py-3 text-sm text-gray-900">{{ $user->id }}</td>
									<td class="px-4 py-3 text-sm text-gray-900">{{ $user->name }}</td>
									<td class="px-4 py-3 text-sm text-gray-600">{{ $user->email }}</td>
									<td class="px-4 py-3 text-sm text-gray-900">
										@php($roles = method_exists($user, 'getRoleNames') ? $user->getRoleNames() : collect())
										@if ($roles->isEmpty())
											<span class="inline-flex items-center rounded-md bg-gray-100 px-2 py-1 text-xs font-medium text-gray-700">No Role</span>
										@else
											<div class="flex flex-wrap gap-2">
												@foreach ($roles as $role)
													<span class="inline-flex items-center rounded-md bg-indigo-100 px-2 py-1 text-xs font-medium text-indigo-700">{{ $role }}</span>
												@endforeach
											</div>
										@endif
									</td>
									<td class="px-4 py-3 text-sm text-gray-600">{{ $user->created_at?->format('d M Y, H:i') }}</td>
									<td class="px-4 py-3 text-sm">
										<div class="flex items-center gap-2">
											<a href="{{ route('users.edit', $user->id) }}"
											   class="inline-flex items-center rounded-md bg-white px-3 py-1.5 text-xs font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
												Edit
											</a>
											<form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini?');">
												@csrf
												@method('DELETE')
												<button type="submit"
														class="inline-flex items-center rounded-md bg-red-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-500">
													Hapus
												</button>
											</form>
										</div>
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="6" class="px-4 py-6 text-center text-sm text-gray-500">Belum ada user terdaftar.</td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>

				<div class="px-6 py-4 border-t border-gray-200 flex items-center justify-end">
					{{ $users->links() }}
				</div>
			</div>
		</div>
	</div>
</x-app-layout>
