<x-app-layout>
    <div class="space-y-6">
        <!-- Page Header & Action Button -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">
                    Manajemen Akun Pengguna (Users)
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">Kelola akun dan perizinan hak akses Admin, Guru, dan Siswa.</p>
            </div>
            <a href="{{ route('users.create') }}" class="inline-flex items-center justify-center gap-2 bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-md shadow-orange-200 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Akun User Baru</span>
            </a>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <form method="GET" action="{{ route('users.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / email user..." class="w-full rounded-lg border-gray-300 text-sm focus:border-orange-400 focus:ring-orange-300">
                </div>
                <div>
                    <select name="role" class="w-full rounded-lg border-gray-300 text-sm focus:border-orange-400 focus:ring-orange-300">
                        <option value="">-- Semua Role --</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User (Guru/Siswa)</option>
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold text-sm py-2 rounded-lg shadow-sm shadow-orange-200 transition">Filter</button>
                    @if(request('search') || request('role'))
                        <a href="{{ route('users.index') }}" class="px-3 py-2 border border-gray-300 rounded-lg text-xs font-semibold text-gray-600 hover:bg-gray-50">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
            <table class="w-full min-w-[680px] text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Nama Pengguna</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Role Hak Akses</th>
                        <th class="px-6 py-4">Total Peminjaman</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $index => $u)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-mono text-xs text-gray-400">
                                {{ $users->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900">
                                {{ $u->name }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $u->email }}
                            </td>
                            <td class="px-6 py-4">
                                @if($u->role === 'admin')
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-900 uppercase">Admin</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-900 uppercase">User</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-800">
                                {{ number_format($u->loans_count, 0, ',', '.') }}x
                            </td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <a href="{{ route('users.edit', $u) }}" class="inline-block bg-amber-50 text-amber-700 hover:bg-amber-100 font-semibold px-3 py-1 rounded text-xs">Edit</a>
                                @if($u->id !== Auth::id())
                                    <form method="POST" action="{{ route('users.destroy', $u) }}" class="inline-block" onsubmit="return confirm('Hapus akun {{ $u->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-rose-50 text-rose-700 hover:bg-rose-100 font-semibold px-3 py-1 rounded text-xs">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                Belum ada data pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
            <div class="p-4 border-t border-gray-100">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
