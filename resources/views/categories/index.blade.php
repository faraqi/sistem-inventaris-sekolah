<x-app-layout>
    <div class="space-y-6">
        <!-- Page Header & Action Button -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">
                    Kelola Kategori Barang Inventaris
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">Kelola daftar pengelompokan dan kategori barang inventaris sekolah.</p>
            </div>
            <a href="{{ route('categories.create') }}" class="inline-flex items-center justify-center gap-2 bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-md shadow-pink-200 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Kategori Baru</span>
            </a>
        </div>

        <!-- Search & Filter Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <form method="GET" action="{{ route('categories.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kategori..." class="w-full rounded-lg border-gray-300 text-sm focus:border-pink-400 focus:ring-pink-300">
                </div>
                <div>
                    <select name="filter" class="w-full rounded-lg border-gray-300 text-sm focus:border-pink-400 focus:ring-pink-300">
                        <option value="">-- Semua Kategori --</option>
                        <option value="with_items" {{ request('filter') == 'with_items' ? 'selected' : '' }}>Memiliki Barang</option>
                        <option value="empty" {{ request('filter') == 'empty' ? 'selected' : '' }}>Belum Ada Barang</option>
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <button type="submit" class="w-full bg-pink-500 hover:bg-pink-600 text-white font-bold text-sm py-2 rounded-lg shadow-sm shadow-pink-200 transition">Filter</button>
                    @if(request('search') || request('filter'))
                        <a href="{{ route('categories.index') }}" class="px-3 py-2 border border-gray-300 rounded-lg text-xs font-semibold text-gray-600 hover:bg-gray-50">Reset</a>
                    @endif
                </div>
            </form>
            <p class="mt-3 pt-3 border-t border-gray-100 text-xs text-gray-500">Total Kategori: <strong>{{ number_format($categories->total(), 0, ',', '.') }}</strong></p>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Nama Kategori</th>
                        <th class="px-6 py-4">Jumlah Barang</th>
                        <th class="px-6 py-4">Tgl Dibuat</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($categories as $index => $category)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-mono text-xs text-gray-400">
                                {{ $categories->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900">
                                {{ $category->name }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 bg-pink-50 text-pink-700 border border-pink-100 rounded-full font-bold text-xs">
                                    {{ number_format($category->items_count, 0, ',', '.') }} barang
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500">
                                {{ $category->created_at->translatedFormat('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <a href="{{ route('categories.edit', $category) }}" class="inline-block bg-amber-50 text-amber-700 hover:bg-amber-100 font-semibold px-3 py-1 rounded text-xs">Edit</a>
                                <form method="POST" action="{{ route('categories.destroy', $category) }}" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $category->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-rose-50 text-rose-700 hover:bg-rose-100 font-semibold px-3 py-1 rounded text-xs">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                Belum ada data kategori barang.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
            <div class="p-4 border-t border-gray-100">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
