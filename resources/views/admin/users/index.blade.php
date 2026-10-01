<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Kelola User
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
            <div class="p-3 mb-4 text-green-700 bg-green-100 rounded">
                {{ session('status') }}
            </div>
            @endif

            @if (session('error'))
            <div class="p-3 mb-4 text-red-700 bg-red-100 rounded">
                {{ session('error') }}
            </div>
            @endif

            <div class="flex flex-col gap-3 mb-4 sm:flex-row sm:items-center sm:justify-between">
                <form method="GET" class="flex-1 max-w-sm">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, username, atau email..."
                        class="w-full text-sm border-gray-300 rounded" onchange="this.form.submit()">
                </form>
                <a href="{{ route('admin.users.create') }}"
                    class="px-4 py-2 text-sm text-center text-white bg-red-600 rounded hover:bg-red-700">
                    + Tambah User
                </a>
            </div>

            <div class="overflow-hidden bg-white rounded shadow">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-gray-600 bg-gray-50">
                            <tr>
                                <th class="px-4 py-3">Nama</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Role</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                            <tr class="border-t">
                                <td class="px-4 py-3">{{ $user->name }}</td>
                                <td class="px-4 py-3">{{ $user->email }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs rounded {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-700' }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 space-x-3">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center gap-1 text-indigo-600 hover:underline">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Yakin hapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 text-red-600 hover:underline">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1a4 4 0 100-8 4 4 0 000 8zm6 3a4 4 0 00-4-4H7a4 4 0 00-4 4v2h14v-2z" />
                                    </svg>
                                    <p class="mt-3 text-sm font-medium text-gray-600">
                                        {{ $search ? 'Tidak ada user yang cocok dengan pencarian' : 'Belum ada user' }}
                                    </p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>